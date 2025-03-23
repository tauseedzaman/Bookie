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
                <ul class="list-none text-gray-800 dark:text-gray-200 space-y-4">
                    @php
                    // Group bookmarks by category
                    $groupedBookmarks = $favoriteBookmarks->groupBy(fn($bookmark) => $bookmark->category->name ?? 'Uncategorized');
                    @endphp

                    @foreach ($groupedBookmarks as $category => $bookmarks)
                    <li class="mb-4">
                        <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200 ">
                            <i class="fas fa-folder"></i> {{ $category }}
                        </h5>
                        <ul class="list-none text-gray-800 dark:text-gray-200 pl-4 space-y-2 mt-2">
                            @foreach ($bookmarks as $bookmark)
                            <li class="flex justify-between items-center border-b-2 pb-1 border-cyan-300">
                                <div>
                                    <a href="{{ $bookmark->url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-link"></i> {{ $bookmark->title ?? $bookmark->url }}
                                    </a>
                                </div>

                                <!-- Unstar Button -->
                                <button onclick="confirmUnfavorite({{ $bookmark->id }}, '{{ route('bookmark.unfavorite', $bookmark->id) }}')" class="text-yellow-500 hover:text-yellow-700">
                                    <i class="fas fa-star"></i> <!-- Filled Star for Favorite -->
                                </button>

                                <!-- Delete Button with SweetAlert -->
                                <button onclick="confirmDelete({{ $bookmark->id }}, '{{ route('bookmark.destroy', $bookmark->id) }}')" class="text-red-500 hover:text-red-700 ml-2">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </li>
                            @endforeach
                        </ul>
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
                            <li class="flex justify-between items-center border-b border-b-gray-600">
                                <div>
                                    <a href="{{ $bookmark->url }}" target="_blank" class="text-blue-800 dark:text-blue-400 hover:underline">
                                        <i class="fas fa-link"></i> {{ $bookmark->title ?? $bookmark->url }}
                                    </a>
                                </div>


                                <!-- Favorite/Unfavorite Button with SweetAlert -->
                                @if ($bookmark->is_favorite)
                                <!-- Unstar Button -->
                                <button onclick="confirmUnfavorite({{ $bookmark->id }}, '{{ route('bookmark.unfavorite', $bookmark->id) }}')" class="text-gray-500 hover:text-gray-700">
                                    <!-- Filled Star for Favorite -->
                                    <i class="fas fa-star"></i>
                                </button>
                                @else
                                <!-- Add to Favorite Button -->
                                <button onclick="confirmFavorite({{ $bookmark->id }}, '{{ route('bookmark.favorite', $bookmark->id) }}')" class="text-yellow-500 hover:text-yellow-700">
                                    <i class="far fa-star"></i> <!-- Empty Star for Not Favorite -->
                                </button>
                                @endif


                                <!-- Delete Button with SweetAlert -->
                                <button onclick="confirmDelete({{ $bookmark->id }},'{{ route('bookmark.destroy',$bookmark->id) }}')" class="text-red-500 hover:text-red-700 ml-2">
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
        function confirmDelete(bookmarkId, endpoint_url) {
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
                    form.action = endpoint_url;
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

        // Confirm Add to Favorite
        function confirmFavorite(bookmarkId, url) {
            Swal.fire({
                title: 'Add to Favorites?'
                , text: 'Do you want to add this bookmark to your favorites?'
                , icon: 'question'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, add it!'
                , cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        // Confirm Unfavorite
        function confirmUnfavorite(bookmarkId, url) {
            Swal.fire({
                title: 'Remove from Favorites?'
                , text: 'Do you want to remove this bookmark from your favorites?'
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , cancelButtonColor: '#3085d6'
                , confirmButtonText: 'Yes, remove it!'
                , cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

    </script>
</x-app-layout>
