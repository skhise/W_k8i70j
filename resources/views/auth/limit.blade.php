<x-app-layout>
    
<div class="main-content">
        <section class="section">
        <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="text-center">
        <h1 class="text-2xl font-bold mb-4">You have exceeded the users.</h1>
        <p class="mb-6">Please contact support for further assistance.</p>

        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            Go Home
        </a>
    </div>
        </div>
        </section>
    </div>
</x-app-layout>