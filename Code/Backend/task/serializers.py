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

class TaskSerializer(serializers.ModelSerializer):
    subtasks = SubTaskSerializer(many=True, required=False,)
    due_date = DueDateSerializer(required=False)

    class Meta:
        model = Task
        fields = ['id', 'user', 'title', 'description', 'is_completed', 'has_due_date', 'subtasks', 'due_date',]
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