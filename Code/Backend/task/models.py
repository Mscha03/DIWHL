from django.db import models
from django.contrib.auth.models import User

# Create your models here.

"""
class Task(models.Model):
    user_id = models.ManyToOneRel(to=User,field=id, field_name='user_id', on_delete=models.CASCADE)
    title = models.CharField(max_length=50)
    description = models.CharField(null=True)
    is_completed = models.BooleanField(default=False)
    has_due_date = models.BooleanField(default=False)
    created_at = models.DateTimeField(auto_now=True)
    updated_at = models.DateTimeField(auto_now=True)

class SubTask(models.Model):
    task_id = models.ManyToOneRel(to=Task,field=id, field_name='task_id', on_delete=models.CASCADE)
    title = models.CharField(max_length=50)
    is_compeleted = models.BooleanField(default=False)

"""