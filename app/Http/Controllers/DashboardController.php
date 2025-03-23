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

        if ($request->category) {
            if ($request->category == 'custom') {
                $_category = $request->custom;
            } else {
                $_category = $request->category;
            }
        } else {
            $_category = 'Default';
        }

        $category = BookMarksCategory::firstOrCreate([
            'name' => $_category,
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

    // destroy method
    public function destroy(BookMark $bookmark)
    {
        $bookmark->delete();
        session()->flash('success', 'Bookmark deleted successfully');
        return redirect()->route('dashboard');
    }

    // add to fav
    public function favorite($id)
    {
        $bookmark = BookMark::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $bookmark->is_favorite = true;
        $bookmark->save();

        session()->flash('success', 'Bookmark added to favorite');
        return redirect()->route('dashboard');
    }

    // remove from fav
    public function unfavorite($id)
    {
        $bookmark = BookMark::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $bookmark->is_favorite = false;
        $bookmark->save();
        session()->flash('success', 'Bookmark removed from favorite');
        return redirect()->route('dashboard');
    }




}
