<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['title', 'subtitle', 'image', 'link', 'button_text', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
