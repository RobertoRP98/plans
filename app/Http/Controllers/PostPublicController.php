<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\State;
use App\Models\Category;
use App\Models\Municipio;

class PostPublicController extends Controller

{

    public function solicitantes()
    {
        $states = State::all();

        return Inertia::render('Solicitantes/SelectState', [
            'states' => $states
        ]);
    }


    public function indexPublic($state, $municipio = null, $category = null, $search = null)
    {
        $stateSearch = State::all();
        $categoriesSearch = Category::all();

        $estado = State::where('slug', $state)->firstOrFail();

        $query = Post::query()
            ->where('state_id', $estado->id);

        if ($municipio) {
            $municipio = Municipio::where('slug', $municipio)
                ->where('state_id', $estado->id)
                ->firstOrFail();

            $query->where('municipio_id', $municipio->id);
        }

        if ($category) {
            $category = Category::where('slug', $category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        $search = request()->query('search');

        if ($search) {
            // convierte "-" en espacios (si viene como slug)
            // $search = str_replace('-', ' ', $search);
            $query->where('title', 'LIKE', "%{$search}%");
        }

        return Inertia::render('Solicitantes/Index', [
            'anuncios' => $query->paginate(20),
            'state' => $state,
            'municipio' => $municipio ? $municipio->slug : null,
            'category' => $category ? $category->slug:null,
            'searchquery' => $search,
            'stateSearch' => $stateSearch,
            'categoriesSearch' => $categoriesSearch,
        ]);
    }
}
