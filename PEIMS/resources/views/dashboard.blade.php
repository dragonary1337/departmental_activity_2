<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (auth()->check())
            <div id="login-success-message" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("You're logged in!") }}
                    </div>
                </div>
            </div>
        @endif
            <script>
                setTimeout(() => {
                    const message = document.getElementById('login-success-message');
                    if (message) message.remove();
                }, 3000);
            </script>

            <div class="container p-5 mx-auto mt-8 grid grid-cols-1 gap-6 max-w-7xl sm:grid-cols-2 lg:grid-cols-3">
                <div class="card mb-3 bg-white rounded-lg shadow-md h-40">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <p>Welcome, {{ auth()->user()->name }}!</p>
                        <p>Your email: {{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="card mb-3 bg-white rounded-lg shadow-md h-40">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <p>Welcome, {{ auth()->user()->name }}!</p>
                        <p>Your email: {{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="card mb-3 bg-white rounded-lg shadow-md h-40">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <p>Welcome, {{ auth()->user()->name }}!</p>
                        <p>Your email: {{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

    </div>
</x-app-layout>
