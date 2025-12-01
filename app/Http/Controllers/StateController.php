<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Str;
use Inertia\Inertia;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::all();

        return Inertia::render('States/Index', [
            'states' => $states
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('States/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {

        $state = $request->validated();

        $state['slug'] = Str::slug($state['name']);
        
        State::create($state);

        return redirect()->route('estados.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {

        return Inertia::render(
            'States/Show',
            [
                'state' => $state
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {

        return Inertia::render(
            'States/Edit',
            [
                'state' => $state
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state)
    {

        $data = $request->validated();

        $data['slug'] = Str::slug($data['name']);

        $state->update($data);

        return redirect()->route('estados.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('estados.index');
    }
}
