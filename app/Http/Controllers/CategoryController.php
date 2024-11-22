<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {


    public function index() {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create() {
        return view('categories.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    public function show(Category $category) {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category) {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function destroy(Category $category) {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }
}
