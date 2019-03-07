<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'categories' => Category::withCount('posts')->latest()->get()
        ], Response::HTTP_OK);
    }

    /**
     * Display all posts for  thiis category
     *
     * @return \Illuminate\Http\Response
     */
    public function posts(Category $category)
    {
        $obj = $category->posts()->paginate(6);

        return response()->json([
            'posts' => $obj->all(),
            'current_category' => $category,
            'current_page' => $obj->currentPage(),
            'length' => $obj->lastPage()
        ], Response::HTTP_OK);
    }
}
