<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    private function sanitizeHtml(string $html): string
    {
        $html = preg_replace('#<script\b[^>]*>.*?</script>#is', '', $html);
        $html = preg_replace('#<(iframe|object|embed|form)\b[^>]*>.*?</\1>#is', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*(?:"[^"]*"|\'[^\']*\'|[^\s>]*)/i', '', $html);
        $html = preg_replace('/\bhref\s*=\s*["\']?\s*javascript:/i', 'href="#" data-blocked=', $html);
        return $html;
    }

    public function index()
    {
        $pages = Page::orderBy('sort_order')->orderBy('title')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'content'          => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'sort_order'       => 'nullable|integer|min:0',
        ]);

        $data['slug']           = $this->uniqueSlug(Str::slug($data['title']));
        $data['is_active']      = $request->boolean('is_active', true);
        $data['show_in_footer'] = $request->boolean('show_in_footer', false);
        $data['sort_order']     = $data['sort_order'] ?? 0;
        $data['content']        = $this->sanitizeHtml($data['content']);

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman "' . $data['title'] . '" berhasil dibuat.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:200',
            'content'          => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'sort_order'       => 'nullable|integer|min:0',
        ]);

        $data['is_active']      = $request->boolean('is_active', true);
        $data['show_in_footer'] = $request->boolean('show_in_footer', false);
        $data['sort_order']     = $data['sort_order'] ?? $page->sort_order;
        $data['content']        = $this->sanitizeHtml($data['content']);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman "' . $page->title . '" berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $title = $page->title;
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman "' . $title . '" berhasil dihapus.');
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base;
        $i = 2;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
