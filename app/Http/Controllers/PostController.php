<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CategoryResource;
use App\Events\CreatePostEvent;

class PostController extends Controller
{
    /**
     * Create a new QuestionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['index','show','byUser']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj =  Post::latest()->with("user")->paginate(6);

        return response()->json([
            'posts' => PostResource::collection($obj),
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
            $postJSR = new PostResource($post);

            broadcast(new CreatePostEvent($postJSR))->toOthers();

            return response()->json([
                'post' => new PostResource($postJSR),
                'categories' =>  CategoryResource::collection(Category::withCount('posts')->latest()->get())
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
        if ($post) {
            return response()->json([
                'post' => new PostResource($post),
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => "There isn't the post"
            ], Response::HTTP_BAD_REQUEST);
        }
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

    /**
     * Display all posts for user
     *
     * @return \Illuminate\Http\Response
     */
    public function byUser(User $user)
    {
        $obj = $user->posts()->latest()->paginate(6);

        return response()->json([
            'posts' => PostResource::collection($obj),
            'user' => new UserResource($user),
            'current_page' => $obj->currentPage(),
            'length' => $obj->lastPage()
        ], Response::HTTP_OK);
    }
}
