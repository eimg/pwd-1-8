<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
                {{ $category->name }}
            </h2>
            @auth
                <a href="{{ route('categories.edit', $category) }}" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                    {{ __('Edit Category') }}
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-flash-status />

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800 dark:shadow-gray-900/50">
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="h-48 w-full object-cover">
                        </a>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <a href="{{ route('posts.show', $post) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 line-clamp-3 dark:text-gray-400">{{ Str::limit($post->body, 140) }}</p>
                            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('By :author', ['author' => $post->user->name]) }}
                            </p>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-600 dark:text-gray-400">{{ __('No posts in this category yet.') }}</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
