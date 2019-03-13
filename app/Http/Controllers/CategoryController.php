<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CategoryResource;

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
            'categories' => CategoryResource::collection(Category::withCount('posts')->latest()->get())
        ], Response::HTTP_OK);
    }

    /**
     * Display all posts for  this category
     *
     * @return \Illuminate\Http\Response
     */
    public function posts(Category $category)
    {
        $obj = $category->posts()->paginate(6);

        return response()->json([
            'posts' => PostResource::collection($obj),
            'current_category' => new CategoryResource($category),
            'current_page' => $obj->currentPage(),
            'length' => $obj->lastPage()
        ], Response::HTTP_OK);
    }
}
