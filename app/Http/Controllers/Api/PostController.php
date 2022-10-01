<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $orderColumn = request('order_column', 'created_at');
        if (!in_array($orderColumn, ['id', 'title', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }
        $posts = Post::with('category')
            ->when(request('search_category'), function ($query) {
                $query->where('category_id', request('search_category'));
            })
            ->when(request('search_id'), function ($query) {
                $query->where('id', request('search_id'));
            })
            ->when(request('search_title'), function ($query) {
                $query->where('title', 'like', '%'.request('search_title').'%');
            })
            ->when(request('search_content'), function ($query) {
                $query->where('content', 'like', '%'.request('search_content').'%');
            })
            ->when(request('search_global'), function ($query) {
                $query->where(function($q) {
                    $q->where('id', request('search_global'))
                        ->orWhere('title', 'like', '%'.request('search_global').'%')
                        ->orWhere('content', 'like', '%'.request('search_global').'%');

                });
            })
            ->orderBy($orderColumn, $orderDirection)
            ->paginate(50);
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        dd($request->all());
        $this->authorize('posts.create');
        if ($request->hasFile('thumbnail')) {
            $filename = $request->file('thumbnail')->getClientOriginalName();
            info($filename);
        }
        $post = Post::create($request->validated());

        return new PostResource($post);
    }

    public function show(Post $post)
    {
        $this->authorize('posts.update');
        return new PostResource($post);
    }

    public function update(Post $post, StorePostRequest $request)
    {
        $this->authorize('posts.update');
        $post->update($request->validated());

        return new PostResource($post);
    }

    public function destroy(Post $post) {
        $this->authorize('posts.delete');
        $post->delete();

        return response()->noContent();
    }
}
