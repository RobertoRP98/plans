<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\State;
use App\Models\Category;
use App\Models\Municipio;
use Illuminate\Support\Facades\Auth;

class PostClientController extends Controller
{
    public function misAnuncios()
    {
        $categories = Category::all();
        $states = State::all();
        $municipios = Municipio::all();
        $plans = Plan::all();
        $posts = Post::with(['user', 'category', 'state', 'municipio', 'plan'])
        ->where('user_id',Auth::id())
        ->get();
        $phone = Auth::user()->phone;

        return Inertia::render('Client/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'states' => $states,
            'municipios' => $municipios,
            'plans' => $plans,
            'phone' => $phone
        ]);
    }
}
