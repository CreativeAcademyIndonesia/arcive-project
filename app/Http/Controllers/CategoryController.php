<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories'
        ]);

        Category::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(Category $kategori)
    {
        return view('categories.edit', compact('kategori'));
    }

    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $kategori->id
        ]);

        $kategori->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
