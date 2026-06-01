<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', __('Veuillez vous connecter pour envoyer un message.'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $user = Auth::user();

        ContactMessage::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $user->email,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'open',
        ]);

        return redirect()->back()->with('success', __('Votre message a été envoyé avec succès ! Les réponses seront envoyées à votre email.'));
    }

    public function showContactMessage(ContactMessage $contactMessage)
    {
        abort_unless($contactMessage->user_id === Auth::id(), 403);

        return view('messages.show', compact('contactMessage'));
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
