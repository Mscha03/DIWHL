from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import TaskViewSet, SubTaskViewSet, DueDateViewSet

router = DefaultRouter()
router.register('tasks', TaskViewSet, basename='tasks')
router.register('subtasks', SubTaskViewSet, basename='subtasks')
router.register('due_dates', DueDateViewSet, basename='due_dates')

urlpatterns = [
   path('', include(router.urls)),
]