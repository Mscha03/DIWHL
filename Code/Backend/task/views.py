from rest_framework import viewsets
from .models import Task, SubTask, DueDate
from .serializers import TaskSerializer, SubTaskSerializer, DueDateSerializer
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