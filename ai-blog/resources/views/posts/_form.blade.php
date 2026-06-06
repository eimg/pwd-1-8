@props(['post' => null, 'categories'])

<div>
    <x-input-label for="title" :value="__('Title')" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post?->title)" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('title')" />
</div>

<div class="mt-4">
    <x-input-label for="category_id" :value="__('Category')" />
    <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400" required>
        <option value="">{{ __('Select a category') }}</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post?->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
</div>

<div class="mt-4">
    <x-input-label for="feature_image" :value="__('Feature Image URL')" />
    <x-text-input id="feature_image" name="feature_image" type="url" class="mt-1 block w-full" :value="old('feature_image', $post?->feature_image)" required />
    <x-input-error class="mt-2" :messages="$errors->get('feature_image')" />
</div>

<div class="mt-4">
    <x-input-label for="body" :value="__('Body')" />
    <textarea id="body" name="body" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:focus:border-indigo-400 dark:focus:ring-indigo-400" required>{{ old('body', $post?->body) }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('body')" />
</div>
