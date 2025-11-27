<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use Inertia\Inertia;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Plans/Index');
    }

    public function dataIndex()
    {
        return datatables()
            ->eloquent(Plan::query())
            ->addColumn('active_text', fn($plan) => $plan->active ? 'Si' : 'No')
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Plans/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {

        $plan = $request->validated();

        Plan::create($plan);

        return redirect()->route('planes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return Inertia::render('Plans/Show', [
            'plan' => $plan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return Inertia::render('Plans/Edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());

        return redirect()->route('planes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
