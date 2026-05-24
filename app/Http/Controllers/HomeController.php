<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->withCount('activeProducts')->get();
        $featuredProducts = Product::where('is_active', true)->where('is_featured', true)->with('category')->latest()->take(8)->get();
        $bestsellerProducts = Product::where('is_active', true)->where('is_bestseller', true)->with('category')->latest()->take(8)->get();
        $newProducts = Product::where('is_active', true)->with('category')->latest()->take(8)->get();

        return view('home', compact('banners', 'categories', 'featuredProducts', 'bestsellerProducts', 'newProducts'));
    }
}
