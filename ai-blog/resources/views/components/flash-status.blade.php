@if (session('status'))
    <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700 dark:bg-green-950 dark:text-green-300">
        {{ session('status') }}
    </div>
@endif
