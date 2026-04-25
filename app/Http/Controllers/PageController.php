<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        // Simple validation or processing can be added here
        return redirect()->back()->with('success', __('Votre message a été envoyé avec succès !'));
    }

    public function celiac()
    {
        return view('pages.celiac');
    }

    public function tips()
    {
        return view('pages.tips');
    }

    public function advice()
    {
        return view('pages.advice');
    }
}
