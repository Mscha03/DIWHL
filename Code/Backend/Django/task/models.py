from django.db import models
from django.contrib.auth.models import User

# Create your models here.


class Task(models.Model):
    user = models.ForeignKey(to=User, on_delete=models.CASCADE, related_name='tasks')
    title = models.CharField(max_length=100)
    description = models.CharField(null=True)
    is_completed = models.BooleanField(default=False)
    has_due_date = models.BooleanField(default=False)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

class SubTask(models.Model):
    task = models.ForeignKey(to=Task,on_delete=models.CASCADE, related_name='subtasks')
    title = models.CharField(max_length=50)
    is_completed = models.BooleanField(default=False)


class DueDate(models.Model):
    task = models.OneToOneField(to=Task, on_delete=models.CASCADE, related_name='due_date')
    due_date = models.DateField()
    repeat_days = models.IntegerField(default=0)