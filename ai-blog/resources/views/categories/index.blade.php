<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
                {{ __('Categories') }}
            </h2>
            @auth
                <a href="{{ route('categories.create') }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                    {{ __('Create Category') }}
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-flash-status />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden dark:bg-gray-800 dark:shadow-gray-900/50">
                <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach ($categories as $category)
                        <li class="flex items-center justify-between px-6 py-4">
                            <div>
                                <a href="{{ route('categories.show', $category) }}" class="font-medium text-gray-900 hover:text-indigo-600 dark:text-gray-100 dark:hover:text-indigo-400">
                                    {{ $category->name }}
                                </a>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ trans_choice(':count post|:count posts', $category->posts_count, ['count' => $category->posts_count]) }}</p>
                            </div>
                            @auth
                                <div class="flex items-center gap-3 text-sm">
                                    <a href="{{ route('categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        {{ __('Edit') }}
                                    </a>
                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Delete this category?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
