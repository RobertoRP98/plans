<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicPostResource;
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


    public function indexPublic($state, $category = null, $municipio = null, $search = null)
    {
        // normalizar valores vacios

        $searchquery = null;

        if ($municipio === '_' || $municipio === '') {
            $municipio = null;
        }

        if ($search && str_starts_with($search, 'buscar-')) {
            $searchquery = str_replace('buscar-', '', $search);
            $searchquery = str_replace('-', ' ', $searchquery);
        }

        $municipio = $municipio === '' ? null : $municipio;
        $category = $category === '' ? null : $category;

        if (is_null($municipio) && !is_null($category)) {
            $tmpMunicipio = Municipio::where('slug', $category)
                ->whereHas('state', fn($q) => $q->where('slug', $state))
                ->first();

            if ($tmpMunicipio) {
                //category realmente era municipio - hacen un intercambio de espacios

                $municipio = $category;
                $category = null;
            }
        }

        $estado = State::where('slug', $state)->firstOrFail();

        $query = Post::query()->where('state_id', $estado->id)->with('category', 'municipio');

        if (!is_null($municipio)) {
            $municipioModel = Municipio::where('slug', $municipio)
                ->where('state_id', $estado->id)
                ->firstOrFail();

            $query->where('municipio_id', $municipioModel->id);
        }

        if (!is_null($category)) {
            $categoryModel = Category::where('slug', $category)->firstOrFail();
            $query->where('category_id', $categoryModel->id);
        }

        $search = request()->query('searchquery');

        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }

        return Inertia::render('Solicitantes/Index', [
            // 'anuncios' => $query->paginate(2),
            'anuncios' => $query->paginate(10)->withQueryString(),
            'state' => $state,
            'municipio' => $municipio,
            'category' => $category,
            'searchquery' => $search,
            'stateSearch' => State::all(),
            'categoriesSearch' => Category::all(),
        ]);
    }

    public function showPublic(Post $post)
    {
        $post->increment('views');

        $post->load('user', 'category', 'state', 'municipio');

        return Inertia::render('Solicitantes/Show', [
            'post' => new PublicPostResource($post),
            'backUrl' => url()->previous() !== url()->current()
                ? url()->previous()
                : route('solicitantes'),
        ]);
    }
}
