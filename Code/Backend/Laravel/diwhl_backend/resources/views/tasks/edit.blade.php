@extends('layout')

@section('page-title', 'edit task')

@section('content')
    <main class="container mx-auto p-4 mt-6">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6">Edit Task</h2>
            <form action="{{ route('tasks.edit', ['task' => $task]) }}" method="post">
                @method('put')
                @csrf

                <!--title-->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input name= "title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" value="{{ old('title', $task->title) }}">
                </div>

                <!--description-->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" rows="4">{{ old('description', $task->description) }}</textarea>
                </div>


                <!-- has_due_date checkbox -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input name="has_due_date" type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="hasDueDate" {{ $task['has_due_date'] ? 'checked' : '' }} >
                        <span class="ml-2 text-gray-700">Has due date?</span>
                    </label>
                </div>

                <!-- due_at date input (initially hidden) -->
                <div id="dueDateContainer" class="mb-4 hidden">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="due_at">
                        Due Date
                    </label>
                    <input name="due_at" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="due_at"
                        @if(isset($task->dueDate))
                            value="{{$task->dueDate['due_at']}}"
                        @endif>
                </div>
                <!-- repeat days -->
                <div id="dueDateAlarmRepeat" class="mb-4 hidden">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="repeat_days">
                        Repeat Alarm
                    </label>

                    <input name="repeat_days" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="repeat_days" type="number" placeholder="repeat days"
                           @if(isset($task->dueDate))
                               value="{{$task->dueDate['repeat_days']}}"
                           @endif>

                </div>

                <!--update button-->
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Update Task
                    </button>
                </div>
            </form>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasDueDateCheckbox = document.getElementById('hasDueDate');
            const dueDateContainer = document.getElementById('dueDateContainer');
            const dueDateAlarmRepeat = document.getElementById('dueDateAlarmRepeat');

            // تابع برای نمایش/مخفی کردن فیلد تاریخ
            function toggleDueDateField() {
                if (hasDueDateCheckbox.checked) {
                    dueDateContainer.classList.remove('hidden');
                    dueDateAlarmRepeat.classList.remove('hidden');
                } else {
                    dueDateContainer.classList.add('hidden');
                    dueDateAlarmRepeat.classList.add('hidden');
                }
            }

            // رویداد تغییر وضعیت checkbox
            hasDueDateCheckbox.addEventListener('change', toggleDueDateField);

            // مقداردهی اولیه بر اساس وضعیت checkbox
            toggleDueDateField();

            // اگر خطایی وجود داشت و فرم بازگشت داده شد، وضعیت را بررسی می‌کنیم
            @if(old('has_due_date'))
            dueDateContainer.classList.remove('hidden');
            @endif
        });
    </script>
@endsection
