@props(['category' => null])

<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $category?->name)" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>
