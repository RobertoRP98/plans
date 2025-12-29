<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\State;
use App\Models\Category;
use App\Models\Municipio;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class PostClientController extends Controller
{
    public function misAnuncios()
    {
        $categories = Category::all();
        $states = State::all();
        $municipios = Municipio::all();
        $plans = Plan::all();
        $posts = Post::with(['user', 'category', 'state', 'municipio', 'plan'])
            ->where('user_id', Auth::id())
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

    public function showPlans(Post $post)
    {
        $plans = Plan::where('price', '>', 0)->get();

        return Inertia::render('Client/ShowPlan', [
            'post' => $post,
            'plans' => $plans,
        ]);
    }

    public function selectPlan(Request $request, Post $post)
    {

        $this->authorize('update', $post);

        $plan = Plan::findOrFail($request->plan_id);

        //Guardar el plan seleccionado en el anuncio
        $post->update([
            'plan_id' => $plan->id,
            'status' => 'pending',
            'active' => false,
            'is_premium' => true,
        ]);

        return redirect()->route('anuncios.pagar', $post);
    }
}
