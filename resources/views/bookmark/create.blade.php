{{-- create new bookmark view --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Bookmark
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-validation-errors class="mb-4" />

            @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
            @endsession
            <!-- Bookmark Form -->
            <form action="{{ route('bookmark.store') }}" method="POST">
                @csrf
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                    <div class="mb-4">
                        <x-label for="title" value="Title" />
                        <x-input id="title" name="title" class="block mt-1 w-full" type="text" />
                        <x-input-error for="title" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="url" value="URL" />
                        <x-input id="url" name="url" class="block mt-1 w-full" type="url" required autofocus />
                        <x-input-error for="url" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="description" value="Description" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm"></textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-label for="category_id" value="Category" />
                        <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 sm:text-sm" onchange="toggleCustomCategory(this)">
                            <option value="">Select a category</option>
                            <option value="custom">Create New Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="category_id" class="mt-2" />
                    </div>

                    <div class="mb-4 hidden" id="custom-category-div">
                        <x-label for="custom_category" value="Custom Category" />
                        <x-input id="custom_category" name="custom_category" class="block mt-1 w-full" type="text" />
                        <x-input-error for="custom_category" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-button>Create Bookmark</x-button>
                    </div>
                </div>
            </form>


        </div>
    </div>

    <script>
        function toggleCustomCategory(select) {
            const customCategoryDiv = document.getElementById('custom-category-div');
            if (select.value === 'custom') {
                customCategoryDiv.classList.remove('hidden');
            } else {
                customCategoryDiv.classList.add('hidden');
            }
        }

    </script>
</x-app-layout>
