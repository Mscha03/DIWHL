from django.db.models.functions import NullIf
from drf_writable_nested import WritableNestedModelSerializer
from rest_framework import serializers
from .models import Task, SubTask, DueDate

"""مسئول تبدیل داده های مدل به json"""

class DueDateSerializer(serializers.ModelSerializer):
    class Meta:
        model = DueDate
        fields = ['id', 'due_date', 'repeat_days'] #فیلد های مورد نیاز در هنگام ساخت
        extra_kwargs = {  # گزینه های بیشتر
            'due_date': {'required': False},
            'repeat_days': {'required': False},
        }

class SubTaskSerializer(serializers.ModelSerializer):
    class Meta:
        model = SubTask
        fields = ['id', 'title', 'is_completed']
        extra_kwargs = {
            'title': {'required': False},
            'is_completed': {'read_only': True},
        }

class TaskSerializer(WritableNestedModelSerializer):
    subtasks = SubTaskSerializer(required=False , many=True, allow_null=True)
    due_date = DueDateSerializer(required=False, allow_null=True)

    class Meta:
        model = Task
        fields = ['id', 'user', 'title', 'description', 'is_completed', 'has_due_date', 'subtasks', 'due_date',]
        read_only_fields = ['created_at', 'updated_at']
        extra_kwargs = {
            'description': {'required': False},
            'is_completed': {'read_only': True},
        }
    def create(self, validated_data):
        subtasks = validated_data.pop('subtasks',[])
        due_date = validated_data.pop('due_date', None)

        task = Task.objects.create( **validated_data)

        for subtask in subtasks: #اضافه کردن زیرکار ها در صورت وجود
            SubTask.objects.create(task=task, **subtask)

        if due_date: # اضافه کردن موعد در صورت وجود
            DueDate.objects.create(task=task, **due_date)

        return task

    def update(self, instance, validated_data):

        new_subtasks_data = validated_data.pop('subtasks', [])
        existing_subtasks = instance.subtasks.all()

        # آیدی‌ زیرکارهای جدیدی که باقی می‌مونن
        new_subtask_ids = []

        for subtask_data in new_subtasks_data:
            subtask_id = subtask_data.get('id')

            if subtask_id:
                # اگر آیدی داشت یعنی قبلاً وجود داشته، ویرایشش کن
                subtask = SubTask.objects.get(id = subtask_id, task = instance)
                subtask.title = subtask_data.get('title', subtask.title)
                subtask.is_completed = subtask_data.get('is_completed', subtask.is_completed)
                subtask.save()
                new_subtask_ids.append(subtask.id)

            else:
                # اگر آیدی نداشت، زیرکار جدید بساز
                subtask = SubTask.objects.create(task = instance, **subtask_data)
                new_subtask_ids.append(subtask.id)

            # حذف زیرکارهایی که دیگه در لیست جدید نیستن
        for subtask in existing_subtasks:
            if subtask.id not in new_subtask_ids:
                subtask.delete()

        # پردازش موعد
        new_due_date_data = validated_data.pop('due_date', None)
        if new_due_date_data:
            if hasattr(instance, 'due_date'):
                if instance.due_date:
                      # موعد قبلی رو ویرایش کن
                    due_date = instance.due_date
                    due_date.id = instance.due_date.id
                    due_date.due_date = new_due_date_data.get('due_date', due_date.due_date)
                    due_date.repeat_days = new_due_date_data.get('repeat_days', due_date.repeat_days)
                    due_date.save()
            else:
                # موعد جدید بساز
                DueDate.objects.create(task=instance, **new_due_date_data)
        else:
            # اگه چیزی نیومده یعنی حذفش کن
            instance.due_date.delete()

        # به‌روزرسانی بقیه فیلدهای تسک
        instance.title = validated_data.get('title', instance.title)
        instance.description = validated_data.get('description', instance.description)
        instance.is_completed = validated_data.get('is_completed', instance.is_completed)
        instance.has_due_date = validated_data.get('has_due_date', instance.has_due_date)
        instance.save()

        return instance