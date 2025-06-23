from rest_framework import serializers
from .models import Task, SubTask

"""مسئول تبدیل داده های مدل به json"""

class SubTaskSerializer(serializers.ModelSerializer):
    class Meta:
        model = SubTask
        fields = ['id', 'task', 'title', 'is_completed']

class TaskSerializer(serializers.ModelSerializer):
    subtasks = SubTaskSerializer(many=True, read_only=True)
    class Meta:
        model = Task
        fields = ['id', 'user', 'title', 'description', 'is_completed', 'has_due_date', 'created_at', 'updated_at', 'subtasks']
