from django.shortcuts import render
from rest_framework import viewsets
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response

from habit.models import Habit, HabitLog, HabitPattern
from habit.serializers import HabitSerializer, HabitLogSerializer, HabitPatternSerializer
from habit.utils.utils import fill_missing_logs


# Create your views here.
class HabitViewSet(viewsets.ModelViewSet):
    queryset = Habit.objects.all()
    serializer_class = HabitSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)

    #TODO: add fill_missing_logs() after creation
    """def get_queryset(self):
        user = self.request.user
        habits = Habit.objects.filter(user=user)

        for habit in habits:
            fill_missing_logs(habit)

        return habits """

    def perform_create(self, serializer):
        serializer.save(user=self.request.user)


class HabitPatternViewSet(viewsets.ModelViewSet):
    queryset = HabitPattern.objects.all()
    serializer_class = HabitPatternSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(habit__user=self.request.user)


class HabitLogViewSet(viewsets.ModelViewSet):
     queryset = HabitLog.objects.all()
     serializer_class = HabitLogSerializer
     permission_classes = [IsAuthenticated]

     def get_queryset(self):
         return self.queryset.filter(habit__user=self.request.user)

     def destroy(self, request, *args, **kwargs):
         return Response(
             {'detail': 'Method "DELETE" not allowed.'},
             status=405
         )
