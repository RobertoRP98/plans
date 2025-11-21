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

        $categories = Category::all();
        $states = State::all();
        $municipios = Municipio::all();
        $plans = Plan::all();
        $posts = Post::with(['user', 'category', 'state', 'municipio', 'plan'])->get();
        $phone = Auth::user()->phone;

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'states' => $states,
            'municipios' => $municipios,
            'plans' => $plans,
            'phone' => $phone
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $plan = Plan::findOrFail($data['plan_id']);

        $start = Carbon::now();

        $end = $start->copy()->addDays($plan->duration);

        if (!$plan || $plan->price == 0) {
            $post = Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'slug' => Str::slug($data['title']) . '-' . uniqid(),
                'start' => $start,
                'end' => $end,
                'views' => 0,
                'active' => true,
                'is_premium' => $plan->price > 0,
                'status' => 'active',
                'user_id' => Auth::id(),
                'phone' => Auth::user()?->phone,
                'category_id' => $data['category_id'],
                'state_id' => $data['state_id'],
                'municipio_id' => $data['municipio_id'],
                'plan_id' => $plan->id,
            ]);

            return redirect()->route('anuncios.index')->with('success', 'Anuncio creado correctamente');
        }

        // SI ELIJE PLAN → crear anuncio pero SIN ACTIVARLO
        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'slug' => Str::slug($data['title']) . '-' . uniqid(),
            'start' => null,               // aún no empieza
            'end' => null,                 // se asigna después del pago
            'views' => 0,
            'active' => false,             // aún no está público
            'is_premium' => true,
            'status' => 'pending',         // pendiente de pago
            'user_id' => Auth::id(),
            'phone' => Auth::user()?->phone,
            'category_id' => $data['category_id'],
            'state_id' => $data['state_id'],
            'municipio_id' => $data['municipio_id'],
            'plan_id' => $plan->id,        // lo guardamos para calcular luego
        ]);

        // Redirigir a pagar
        return redirect()->route('anuncios.pagar', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // Incrementa el contador de vistas
        $post->increment('views');

        $post->load('user');

        return Inertia::render('Posts/Show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        $post->load('user', 'category', 'state', 'municipio', 'plan');

        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'states' => State::all(['id', 'name']),
            'categories' => Category::all(['id', 'name']),
            'phone' => $post->user->phone, // si quieres mostrarlo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'state_id' => $request->state_id,
            'municipio_id' => $request->municipio_id,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
        ]);

        return redirect()->route('anuncios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
