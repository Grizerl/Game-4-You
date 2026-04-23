<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Contracts\View\View;

class CompanyController extends Controller
{
    public function index(): View
    {
        $company = Company::all();
        return view('pages.store.stores', compact('company'));
    }
}
