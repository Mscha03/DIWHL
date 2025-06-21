from django.contrib import admin
from django.urls import path, include
from .views import HelloView


urlpatterns = [
   path('api/hello/', HelloView.as_view(), name='hello'),
]