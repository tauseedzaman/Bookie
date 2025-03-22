<?php

namespace App\Http\Controllers;

use App\Models\BookMark;
use App\Models\BookMarksCategory;
use App\Models\PredefinedCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $favoriteBookmarks = BookMark::where('user_id', auth()->id())
            ->where('is_favorite', true)
            ->get();

        $categories = BookMarksCategory::where('user_id', auth()->id())
            ->with('bookmarks')
            ->get();

        return view('dashboard', compact('favoriteBookmarks', 'categories'));
    }

    public function create()
    {
        $categories = PredefinedCategory::all();
        return view('bookmark.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $category = BookMarksCategory::firstOrCreate([
            'name' => $request->category ?? 'Default',
            'user_id' => auth()->id(),
        ]);

        BookMark::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'category_id' => $category?->id ?? null,
            'user_id' => auth()->id(),
        ]);
        session()->flash('success', 'Bookmark created successfully');

        return redirect()->route('dashboard');
    }

}
