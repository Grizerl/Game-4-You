<?php

namespace App\Http\Controllers\Pages;

use App\Models\Creator;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CreatorController extends Controller
{
    public function index(): View
    {
        $creators = Creator::with(['games', 'company'])->paginate(15);
        return view('pages.creator.creators', compact('creators'));
    }
}
