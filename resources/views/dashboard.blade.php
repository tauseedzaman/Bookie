<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-tachometer-alt"></i> {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-validation-errors class="mb-4" />

            @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
            @endif

            <!-- Create Bookmark Button -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    <i class="fas fa-bookmark"></i> Manage Bookmarks
                </h3>
                <x-link-button href="{{ route('bookmark.create') }}">
                    <i class="fas fa-plus-circle mx-2"></i>
                    <span class="mx-2">New Bookmark</span>
                </x-link-button>
            </div>

            <!-- Favorites Section -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">
                    <i class="fas fa-star"></i> Favorite Bookmarks
                </h4>
                @if ($favoriteBookmarks->isEmpty())
                <p class="text-gray-500 dark:text-gray-400"><i class="fas fa-exclamation-circle"></i> No favorite bookmarks yet.</p>
                @else
                <ul class="list-none text-gray-800 dark:text-gray-200 space-y-2">
                    @foreach ($favoriteBookmarks as $bookmark)
                    <li class="flex justify-between items-center">
                        <div>
                            <a href="{{ $bookmark->url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                <i class="fas fa-link"></i> {{ $bookmark->title }}
                            </a>
                            <span class="text-gray-500 dark:text-gray-400">({{ $bookmark?->category?->name ?? 'Uncategorized' }})</span>
                        </div>
                        <!-- Delete Button with SweetAlert -->
                        <button onclick="confirmDelete({{ $bookmark->id }})" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash-alt"></i>
                        </button>

                        <!-- Add to Favorites with SweetAlert -->
                        <form id="fav-form-{{ $bookmark->id }}" action="{{ route('bookmark.favorite', $bookmark->id) }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                        <button onclick="addToFavorites({{ $bookmark->id }})" class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas fa-star"></i>
                        </button>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

            <!-- All Bookmarks by Category -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">
                    <i class="fas fa-folder-open"></i> All Bookmarks by Category
                </h4>

                @if ($categories->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">
                    <i class="fas fa-exclamation-circle"></i> No categories found. Start by creating one!
                </p>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($categories as $category)
                    <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md p-4">
                        <h5 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            <i class="fas fa-folder"></i> {{ $category->name }}
                        </h5>
                        @if ($category->bookmarks->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400">
                            <i class="fas fa-exclamation-circle"></i> No bookmarks in this category.
                        </p>
                        @else
                        <ul class="space-y-2">
                            @foreach ($category->bookmarks as $bookmark)
                            <li class="flex justify-between items-center">
                                <div>
                                    <a href="{{ $bookmark->url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-link"></i> {{ $bookmark->title }}
                                    </a>
                                </div>
                                <!-- Delete Button with SweetAlert -->
                                <button onclick="confirmDelete({{ $bookmark->id }})" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(bookmarkId) {
            Swal.fire({
                title: 'Are you sure?'
                , text: "This bookmark will be permanently deleted!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: '#3085d6'
                , confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = `{{ url('bookmark') }}/${bookmarkId}`;
                    form.method = 'POST';
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function addToFavorites(bookmarkId) {
            Swal.fire({
                title: 'Add to Favorites?'
                , text: "Do you want to add this bookmark to favorites?"
                , icon: 'question'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`fav-form-${bookmarkId}`).submit();
                    Swal.fire(
                        'Added!'
                        , 'The bookmark has been added to favorites.'
                        , 'success'
                    );
                }
            });
        }

    </script>
</x-app-layout>
