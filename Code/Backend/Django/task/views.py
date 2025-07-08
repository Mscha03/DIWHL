from django.shortcuts import get_object_or_404
from rest_framework import viewsets, status
from rest_framework.response import Response

from .models import Task, SubTask, DueDate
from .serializers import TaskSerializer, SubTaskSerializer, DueDateSerializer, TaskCompletedSerializer
from rest_framework.permissions import IsAuthenticated

# Create your views here.

class TaskViewSet(viewsets.ModelViewSet): # مدیریت همه توابع crud
    queryset = Task.objects.all()  # لیست تمام تسک ها
    serializer_class = TaskSerializer # serializer رو مشخص میکنه
    permission_classes = [IsAuthenticated] # فقط کاربران لاگین کرده اجازه دسترسی دارن
    # جلوگیری از دسترسی به تسک های دیگران
    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)
    # اضافه کردن خودکار کاربر
    def perform_create(self, serializer):
        serializer.save(user=self.request.user)


class SubTaskViewSet(viewsets.ModelViewSet):
    queryset = SubTask.objects.all()
    serializer_class = SubTaskSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(task__user=self.request.user)


class DueDateViewSet(viewsets.ModelViewSet):
    queryset = DueDate.objects.all()
    serializer_class = DueDateSerializer
    permission_classes = [IsAuthenticated]

    def get_queryset(self):
        return self.queryset.filter(task__user=self.request.user)


    #TODO:  تبدیل ویو های تغییر وضعیت به ای پی ای  های ساده بدون ویو

class TaskSetCompletedViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = Task.objects.all()
    serializer_class = TaskCompletedSerializer

    def get_queryset(self):
        return self.queryset.filter(user=self.request.user)


    """def post(self, request, pk):
        task = get_object_or_404(Task, pk=pk, user=self.request.user)
        is_completed = request.data.get('is_completed')

        #if is_completed is not None:
        #    task.is_completed = is_completed in [True, 'true', 'True', 1, '1']
        #else:
        #    task.is_completed = not task.is_completed
        

        if is_completed is not None:
            task.is_completed = bool(is_completed)
        else:
            # اگر چیزی نیومده بود، toggle کنیم
            task.is_completed = not task.is_completed
        task.save()

        return Response({
            "id": task.id,
            "is_completed": task.is_completed,
            "message": "Task status updated successfully."
        }, status=status.HTTP_200_OK)"""

class SubTaskCompletedViewSet(viewsets.ModelViewSet):
    permission_classes = [IsAuthenticated]
    queryset = SubTask.objects.all()
    serializer_class = TaskCompletedSerializer

    def get_queryset(self):
        return self.queryset.filter(task__user=self.request.user)