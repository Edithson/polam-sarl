<?php

namespace App\Http\Controllers;

use App\Models\Laws;
use App\Http\Requests\StoreLawsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateLawsRequest;

class LawsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laws = Laws::latest()->paginate(9);
        return view('home.pages.laws', compact('laws'));
    }

    public function index_admin()
    {
        return view('dashboard.pages.laws.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->cannot('create', Laws::class)) {
            return redirect()->route('laws.index_admin')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour créer une loi.");
        }
        return view('dashboard.pages.laws.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLawsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Laws $laws)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laws $law)
    {
        if (auth()->user()->cannot('update', $law)) {
            return redirect()->route('laws.index_admin')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour modifier cette loi.");
        }
        return view('dashboard.pages.laws.edit', compact('law'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLawsRequest $request, Laws $laws)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laws $law)
    {
        if (auth()->user()->cannot('delete', $law)) {
            return redirect()->route('laws.index_admin')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour supprimer cette loi.");
        }
        // supprimer le média de la loi s'il existe
        if ($law->document_path) {
            Storage::disk('public')->delete($law->document_path);
        }
        $law->delete();

        return redirect()->to(url()->previous())
        ->with('status', 'La loi a été supprimée avec succès.');
    }
}
