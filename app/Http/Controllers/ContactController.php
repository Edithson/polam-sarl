<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    //
    public function index ()
    {
        return view('home.pages.contact');
    }

    public function index_admin()
    {
        if (auth()->user()->cannot('viewAny', \App\Models\Contact::class)) {
            return redirect()->route('admin_dashboard')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour accéder à la gestion des contacts.");
        }
        return view('dashboard.contacts.index');
    }
}
