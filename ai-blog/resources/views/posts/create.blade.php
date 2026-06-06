<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800 dark:shadow-gray-900/50">
                <form method="POST" action="{{ route('posts.store') }}">
                    @csrf
                    @include('posts._form', ['categories' => $categories])
                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button>{{ __('Create Post') }}</x-primary-button>
                        <a href="{{ route('posts.index') }}" class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
