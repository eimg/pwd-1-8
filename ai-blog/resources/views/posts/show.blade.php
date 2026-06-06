<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-200">
                {{ $post->title }}
            </h2>
            @can('update', $post)
                <div class="flex items-center gap-3 text-sm">
                    <a href="{{ route('posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('{{ __('Delete this post?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-flash-status />

            <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800 dark:shadow-gray-900/50">
                <img src="{{ $post->feature_image }}" alt="{{ $post->title }}" class="w-full h-72 object-cover">
                <div class="p-6 sm:p-8">
                    <p class="text-sm text-indigo-600 dark:text-indigo-400">
                        <a href="{{ route('categories.show', $post->category) }}" class="hover:underline">
                            {{ $post->category->name }}
                        </a>
                    </p>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('By :author', ['author' => $post->user->name]) }} · {{ $post->created_at->format('M j, Y') }}
                    </p>
                    <div class="mt-6 whitespace-pre-line text-gray-800 leading-relaxed dark:text-gray-200">
                        {{ $post->body }}
                    </div>
                </div>
            </article>

            <section class="bg-white shadow-sm sm:rounded-lg p-6 sm:p-8 dark:bg-gray-800 dark:shadow-gray-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('Comments') }} ({{ $post->comments->count() }})</h3>

                @auth
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-6">
                        @csrf
                        <x-input-label for="content" :value="__('Add a comment')" />
                        <textarea id="content" name="content" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400" required>{{ old('content') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        <div class="mt-4">
                            <x-primary-button>{{ __('Post Comment') }}</x-primary-button>
                        </div>
                    </form>
                @else
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('Log in') }}</a>
                        {{ __('to leave a comment.') }}
                    </p>
                @endauth

                <div class="mt-8 space-y-6">
                    @forelse ($post->comments as $comment)
                        <div class="border-t border-gray-100 pt-6 dark:border-gray-700" x-data="{ editing: false }">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                                @can('update', $comment)
                                    <div class="flex items-center gap-3 text-sm">
                                        <button type="button" @click="editing = !editing" class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            {{ __('Edit') }}
                                        </button>
                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}" onsubmit="return confirm('{{ __('Delete this comment?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>

                            <p x-show="!editing" class="mt-3 text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>

                            <form x-show="editing" method="POST" action="{{ route('comments.update', $comment) }}" class="mt-3">
                                @csrf
                                @method('PATCH')
                                <textarea name="content" rows="3" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400" required>{{ $comment->content }}</textarea>
                                <div class="mt-3 flex gap-3">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    <button type="button" @click="editing = false" class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('No comments yet.') }}</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
