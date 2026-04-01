<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('user')->latest()->paginate(10);

        return view('dashboard.pages.article.list', compact('articles'));
        // return view('livewire.pages.admin.article-list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if (auth()->user()->cannot('update', $article)) {
            return redirect()->route('articles.index')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour modifier cet article.");
        }
        return view('dashboard.pages.article.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (auth()->user()->cannot('delete', $article)) {
            return redirect()->route('articles.index')
                ->with('error', "Vous n'avez pas les permissions nécessaires pour supprimer cet article.");
        }

        // 1. Suppression de l'image sur le disque si elle existe
        if ($article->picture) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($article->picture);
        }

        // 2. Suppression de l'entrée en base de données
        $article->delete();

        return redirect()->to(url()->previous())
        ->with('status', 'Article supprimé définitivement.');

    }
}
