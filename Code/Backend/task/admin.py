from django.contrib import admin

from task.models import Task, SubTask

# Register your models here.
admin.site.register(Task)
admin.site.register(SubTask)