<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $post_request)
    {
        //dd("Hola estoy en el método store del post controller");
        $post_request->merge(['user_id' => auth()->id()]);
        Post::create($post_request->input()); // Esto coge todos los datos que vienen vía Post y los inserta
        return back()->with('message', ['success', __('Post creado correctamente')]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)  // Con esto estamos inyectando el Post completo
    {
        $replies = $post->replies()->with('autor')->paginate(2);
		
		return view('posts.detail', compact('post','replies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if( ! $post->isOwner()){
            abort(401);
        }
        $post->delete();
        return back()->with('message', ['success', __('Post y respuestas eliminados correctamente')]);
    }
}