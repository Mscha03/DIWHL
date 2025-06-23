from rest_framework import serializers
from .models import Task, SubTask, DueDate

"""مسئول تبدیل داده های مدل به json"""

class DueDateSerializer(serializers.ModelSerializer):
    class Meta:
        model = DueDate
        fields = ['id', 'task', 'due_date', 'repeat_days']

class SubTaskSerializer(serializers.ModelSerializer):
    class Meta:
        model = SubTask
        fields = ['id', 'task', 'title', 'is_completed']

class TaskSerializer(serializers.ModelSerializer):
    subtasks = SubTaskSerializer(many=True, read_only=True)
    due_date = DueDateSerializer(   read_only=True)
    class Meta:
        model = Task
        fields = ['id', 'user', 'title', 'description', 'is_completed', 'has_due_date', 'due_date', 'subtasks',]
