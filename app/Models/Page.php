<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'meta_description', 'is_active', 'show_in_footer', 'sort_order'];

    protected $casts = ['is_active' => 'boolean', 'show_in_footer' => 'boolean'];
}
