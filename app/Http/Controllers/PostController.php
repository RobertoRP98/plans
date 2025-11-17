<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\State;
use App\Models\Category;
use App\Models\Municipio;
use Illuminate\Support\Str;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user','category','state','municipio','plan']);

        return Inertia::render('Posts/Index',[
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $states = State::all();
        $municipios = Municipio::all();
        $plans = Plan::all();
        
        return Inertia::render('Posts/Create',[
            'categories' => $categories,
            'states' => $states,
            'municipios' => $municipios,
            'plans' => $plans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $plan = Plan::findOrFail($data['plan_id']);

        $start = Carbon::now();

        $end = $start->copy()->addDays($plan->duration);

        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'slug' => Str::slug($data['title']).'-'.uniqid(),
            'start' => $start,
            'end' => $end,
            'views' => 0,
            'active' => true,
            'is_premium'=>$plan->price > 0,
            'status' => 'active',
            'user_id' => Auth::id(),
            'category_id' => $data['category_id'],
            'state_id' => $data['state_id'],
            'municipio_id' => $data['municipio_id'],
            'plan_id' => $plan->id,
         ]);

         return redirect()->route('anuncios.index')->with('success','Anuncio creado correctamente');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
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
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
