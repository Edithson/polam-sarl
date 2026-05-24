<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.settings.settings-manager');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        //
    }

    public function fastUpdate(Request $request)
    {
        // 1. Validation manuelle pour un meilleur contrôle du retour JSON
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phones' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(), // Retourne la première erreur
            ], 422);
        }

        try {
            // 2. Mise à jour des paramètres
            Setting::updateOrCreate(
                ['id' => 1],
                [
                    'name' => $request->input('name'),
                    'slogan' => $request->input('slogan'),
                    'email' => $request->input('email'),
                    'phones' => $request->input('phones'),
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Paramètres mis à jour avec succès.',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur : ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
