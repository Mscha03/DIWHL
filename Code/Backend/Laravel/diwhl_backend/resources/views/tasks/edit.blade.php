@extends('layout')

@section('page-title', 'edit task')

@section('content')
    <main class="container mx-auto p-4 mt-6">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6">Edit Task</h2>
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" value="Complete project proposal">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                        Description
                    </label>
                    <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" rows="4">Finish the project proposal document and send it to the client by Friday.</textarea>
                </div>
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="hasDueDate" checked>
                        <span class="ml-2 text-gray-700">Has due date?</span>
                    </label>
                    <div class="mt-2">
                        <input type="date" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Update Task
                    </button>
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Delete Task
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
