from django.contrib.auth.models import User
from django.db import models

# Create your models here.
class Habit(models.Model):
    user = models.ForeignKey(to=User, on_delete=models.CASCADE, related_name='habits')
    title = models.CharField(max_length=100)
    description = models.TextField(null=True)
    state_mode = models.CharField(max_length=20)
    frequency = models.CharField(max_length=7)
    has_pattern = models.BooleanField(default=False)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

class HabitPattern(models.Model):
    habit = models.ForeignKey(to=Habit, on_delete=models.CASCADE, related_name='patterns')
    day = models.IntegerField()

class HabitLog(models.Model):
    habit = models.ForeignKey(to=Habit, on_delete=models.CASCADE, related_name='logs')
    date = models.DateField()
    completion_state = models.IntegerField()