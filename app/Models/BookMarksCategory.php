<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookMarksCategory extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'parent_id', 'is_default'];



    /**
     * Get the user that owns the BookMarksCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent that owns the BookMarksCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(BookMarksCategory::class, );
    }

    /**
     * Get all of the bookmarks for the BookMarksCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(BookMark::class,'category_id', 'id');
    }
}
