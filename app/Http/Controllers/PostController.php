<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Create a new QuestionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj =  Post::latest()->paginate(6);

        return response()->json([
            'posts' => $obj->all(),
            'current_page' => $obj->currentPage(),
            'length' => $obj->lastPage()
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request(['title','description', 'category_id', 'body']);

        $validator = Validator::make($data, [
            'title' => ['required', 'string', 'max:125','unique:posts'],
            'description' => ['required', 'string',  'max:255'],
            'body' => ['required', 'string',  'max:3255'],
            'category_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $post = auth()->user()->posts()->create([
            'title' => $data['title'],
            'slug' => str_slug($data['title']),
            'description' => $data['description'],
            'category_id' => $data['category_id'],
            'body' => $data['body']
        ]);

        if ($post) {
            return response()->json([
                'post' => $post,
                'categories' =>  Category::withCount('posts')->latest()->get()
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => 'Post didn\'t create'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            'post' => $post
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
