from django.contrib import admin

from task.models import Task, SubTask, DueDate

# Register your models here.
admin.site.register(Task)
admin.site.register(SubTask)
admin.site.register(DueDate)