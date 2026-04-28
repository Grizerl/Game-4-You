<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Models\Company;
use App\Models\Creator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Creator\StoreRequest;
use App\Http\Requests\Admin\Creator\UpdateRequest;

class CreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creator = Creator::all();
        return view('dashboard.creators.index', compact('creator'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::select('id', 'name')->get();
        return view('dashboard.creators.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')
                ->store('creators', 'public');
        }

        Creator::create($data);
        return redirect()->route('creator.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Creator $creator)
    {
        $companies = Company::all();
        return view('dashboard.creators.edit', compact('creator', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Creator $creator)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) 
        {
            if ($creator->avatar) {
                Storage::disk('public')->delete($creator->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('creators', 'public');
        }

        $creator->update($data);
        return redirect()->route('creator.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Creator $creator)
    {
        if ($creator->avatar) {
            Storage::disk('public')->delete($creator->avatar);
        }

        $creator->delete();
        return redirect()->route('creator.index');
    }
}
