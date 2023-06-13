<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    // Store data 
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'short_description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Adjust the mime types and maximum file size as needed
            'tag_names' => 'required|array',
        ]);

        $imagePath = $request->file('image')->store('category_images', 'public');

        $category = Category::create([
            'name' => $request->input('name'),
            'short_description' => $request->input('short_description'),
            'image' => $imagePath,
        ]);

        $tagNames = $request->input('tag_names');
        $tags = [];

        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tags[] = $tag->id;
        }

        $category->tags()->sync($tags);

        return response()->json(['message' => 'Category created successfully']);
    }

    //Get All
    public function index()
    {
    $categories = Category::with('tags')->get();

    return response()->json(CategoryResource::collection($categories), Response::HTTP_OK);
    }






    // Update category 
    public function update(Request $request, $id)
    {
    $request->validate([
        'name' => 'required',
        'short_description' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:2048', // Adjust the mime types and maximum file size as needed
        'tag_names' => 'required|array',
    ]);

    $category = Category::findOrFail($id);

    $category->name = $request->input('name');
    $category->short_description = $request->input('short_description');

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('category_images', 'public');
        $category->image = $imagePath;
    }

    $category->save();

    $tagNames = $request->input('tag_names');
    $tags = [];

    foreach ($tagNames as $tagName) {
        $tag = Tag::firstOrCreate(['name' => $tagName]);
        $tags[] = $tag->id;
    }

    $category->tags()->sync($tags);

    return response()->json(['message' => 'Category updated successfully']);
}

public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->tags()->detach(); // Remove the category's association with tags
    $category->delete();

    return response()->json(['message' => 'Category deleted successfully']);
}


}
