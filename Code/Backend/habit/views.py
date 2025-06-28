from django.shortcuts import render
from rest_framework import viewsets
from rest_framework.permissions import IsAuthenticated

from habit.models import Habit, HabitLog, HabitPattern
from habit.serializers import HabitSerializer, HabitLogSerializer, HabitPatternSerializer


# Create your views here.
class HabitViewSet(viewsets.ModelViewSet):
    queryset = Habit.objects.all()
    serializer_class = HabitSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)

    def perform_create(self, serializer):
        serializer.save(user=self.request.user)


class HabitLogViewSet(viewsets.ModelViewSet):
     queryset = HabitLog.objects.all()
     serializer_class = HabitLogSerializer
     permission_classes = [IsAuthenticated]

     def get_queryset(self):
         return self.queryset.filter(habit__user=self.request.user)


class HabitPatternViewSet(viewsets.ModelViewSet):
    queryset = HabitPattern.objects.all()
    serializer_class = HabitPatternSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(habit__user=self.request.user)