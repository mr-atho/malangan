<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['image'] = $request->file('image')->store('banners', 'public');

        Banner::create($data);
        return back()->with('success', 'Banner berhasil ditambahkan!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return back()->with('success', 'Banner berhasil dihapus.');
    }
}
