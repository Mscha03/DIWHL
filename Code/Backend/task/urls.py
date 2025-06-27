from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import TaskViewSet, SubTaskViewSet, DueDateViewSet, TaskSetCompletedViewSet, SubTaskCompletedViewSet

router = DefaultRouter()
router.register('tasks', TaskViewSet, basename='tasks')
router.register('subtasks', SubTaskViewSet, basename='subtasks')
router.register('due_dates', DueDateViewSet, basename='due_dates')
router.register('task_completed', TaskSetCompletedViewSet, basename='tasks-completed')
router.register('sub_task_complete', SubTaskCompletedViewSet, basename='sub_tasks-completed')

urlpatterns = [
   path('', include(router.urls)),
]