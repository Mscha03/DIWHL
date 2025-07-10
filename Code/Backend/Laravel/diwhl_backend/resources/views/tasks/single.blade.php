@extends('layout')

@section('content')
    <main class="container mx-auto p-4 mt-6">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">

            <!--title-->
            <div class="flex justify-between items-start mb-6">
                <h2 class="text-2xl font-bold text-gray-800"> {{ $task->title }} </h2>
                <!--due-->
                @if(isset($task->dueDate))
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full mt-2">Deadline: {{$task->dueDate->due_at}} </span>
                @endif
            </div>

            <!--description-->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Description</h3>
                <p class="text-gray-600">{{ $task->description }}</p>
            </div>

            <!--status-->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Details</h3>
                <ul class="text-gray-600 space-y-2">

                    <!--is_completed-->
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Status:
                        @if($task->is_completed)
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full ml-2">Done</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full ml-2">unDone</span>
                        @endif
                    </li>

                    <!--created_at-->
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Created: <span class="font-medium ml-1"> {{ $task->created_at }} </span>
                    </li>
                </ul>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('tasks.getedit', ['task' => $task]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Edit Task
                </a>
                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Back to All Tasks
                </a>
                <!-- delete button-->
                <form name="deleteform" action="{{route('tasks.delete', ['task' => $task])}}" method="post">
                    @method('delete')
                    @csrf
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Delete Task
                    </button>
                </form>
            </div>
        </div>
    </main>
@endsection
