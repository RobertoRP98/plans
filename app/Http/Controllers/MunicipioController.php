<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Http\Requests\StoreMunicipioRequest;
use App\Http\Requests\UpdateMunicipioRequest;
use App\Models\State;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipios = Municipio::with('state')->get();

        return Inertia::render('Municipios/Index', ['municipios' => $municipios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::orderBy('name')->get();

        return Inertia::render('Municipios/Create',[
            'states' => $states
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMunicipioRequest $request)
    {
        $municipio = $request->validated();

        $municipio ['slug'] = Str::slug($municipio['name']);

        Municipio::create($municipio);

        return redirect()->route('municipios.index')->with('success','Municipio agregado desde back correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Municipio $municipio)
    {
        $municipio->load('state');

        return Inertia::render('Municipios/Show',[
            'municipio' => $municipio
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Municipio $municipio)
    {
        $states = State::orderBy('name')->get();

        return Inertia::render('Municipios/Edit',[
            'states' => $states,
            'municipio' => $municipio,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMunicipioRequest $request, Municipio $municipio)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        $municipio->update($data);
        
        return redirect()->route('municipios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Municipio $municipio)
    {
        
    }
}
