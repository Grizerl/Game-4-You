<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\StoreRequest;
use App\Http\Requests\Admin\Company\UpdateRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::latest()->get();
        return view('dashboard.company.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        unset($data['name'], $data['description'], $data['country']);
        $path = null;

        if ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/company'), $filename);
            $path = 'uploads/company/'.$filename;
        }

        $company = new Company($data);

        $company->setTranslations('name', $request->input('name'));
        $company->setTranslations('description', $request->input('description'));
        $company->setTranslations('country', $request->input('country'));

        $company->logo_path = $path;

        $company->save();

        return redirect()->route('companies.index');
    }

    public function edit(Company $company)
    {
        return view('dashboard.company.edit', compact('company'));
    }

   public function update(UpdateRequest $request, Company $company)
    {
        $data = $request->validated();

        unset($data['name'], $data['description'], $data['country']);

        $path = $company->logo_path;

        if ($request->hasFile('logo_path')) {
            if ($company->logo_path && file_exists(public_path($company->logo_path))) {
                unlink(public_path($company->logo_path));
            }

            $file = $request->file('logo_path');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/company'), $filename);
            $path = 'uploads/company/'.$filename;
        }

        $company->update($data);

        $company->setTranslations('name', $request->input('name'));
        $company->setTranslations('description', $request->input('description'));
        $company->setTranslations('country', $request->input('country'));

        $company->logo_path = $path;

        $company->save();

        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if ($company->logo_path && file_exists(public_path($company->logo_path))) {
            unlink(public_path($company->logo_path));
        }

        $company->delete();
        return redirect()->route('companies.index');
    }
}
