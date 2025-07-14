@extends('layouts.base')

@section('page-title', 'tasks list')

@section('content')
    <main class="container mx-auto p-4 mt-6">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold">Your Tasks</h2>
            </div>
            <div class="divide-y divide-gray-200">

                @foreach($tasks as $task)

                    <!-- Task 1 -->
                    <div class="p-6 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <!--title-->
                                <h3 class="text-lg font-medium text-blue-600">
                                    <a href="{{ route('tasks.show', ['task' => $task]) }}">{{ $task->title }}</a>
                                    @if($task->is_completed)
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mt-2">Done</span>
                                    @else
                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full mt-2">unDone</span>
                                    @endif
                                </h3>

                                <!--description-->
                                <p class="text-gray-600 mt-1"> {{ $task->description }} </p>

                                <!--due-->
                                @if(isset($task->dueDate))
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full mt-2">Deadline: {{$task->dueDate->due_at}} </span>
                                @endif
                            </div>

                            <div class="flex space-x-2">
                                <!--edit button-->
                                <a href="{{ route('tasks.edit', ['task' => $task]) }}" class="text-blue-500 hover:text-blue-700">Edit</a>

                                <span class="text-gray-300">|</span>
                                <!--delete button-->
                                <form action="{{ route('tasks.destroy', ['task' => $task]) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>

                        </div>
                    </div>


                @endforeach


            </div>
        </div>
    </main>
@endsection
