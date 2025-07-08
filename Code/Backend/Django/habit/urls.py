from django.urls import path, include
from rest_framework.routers import DefaultRouter

from habit.views import *

router = DefaultRouter()
router.register('habits', HabitViewSet, basename='habits')
router.register('patterns', HabitPatternViewSet, basename='pattern')
router.register('logs', HabitLogViewSet, basename='logs')

urlpatterns = [
   path('', include(router.urls)),
]