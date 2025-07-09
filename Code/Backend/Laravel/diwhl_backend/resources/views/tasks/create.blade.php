@extends('layout')

@section('page-title', 'create task')

@section('content')
    <main class="container mx-auto p-4 mt-6">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6">Create New Task</h2>
            <form action="{{ route('tasks.store') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" placeholder="Task title">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" rows="4" placeholder="Task description"></textarea>
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input name="due_at" type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="hasDueDate">
                        <span class="ml-2 text-gray-700">Has due date?</span>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
