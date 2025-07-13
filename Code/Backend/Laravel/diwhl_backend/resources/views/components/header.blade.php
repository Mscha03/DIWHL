<header class="bg-blue-600 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Task Manager</h1>
        <nav>
            <div class="flex gap-1">
            @auth
                    <a href="{{ route('tasks.index') }}" class="px-3 py-2 rounded bg-blue-700 hover:bg-blue-800">All
                        Tasks</a>
                    <a href="{{ route('tasks.create') }}" class="px-3 py-2 rounded hover:bg-blue-700">Create Task</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded bg-red-600 hover:bg-red-700">Logout</button>
                    </form>
            @else
                    <a href="{{ route('login') }}"> login </a>
                    <a href="{{ route('register') }}"> Register </a>
            @endauth
            </div>

        </nav>
    </div>
</header>
