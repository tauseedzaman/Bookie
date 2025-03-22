<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookMark extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'url', 'description', 'user_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(BookMarksCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
