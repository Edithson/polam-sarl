<?php

namespace App\Http\Controllers;

use App\Models\Laws;
use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Loading homepage
    public function index()
    {
        $articles = Article::where('public', true)
                        ->with('user')
                        ->latest()
                        ->take(3)
                        ->get();
        $laws = Laws::latest()->take(3)->get();
        return view('home.pages.home', compact('articles', 'laws'));
    }

    public function list_articles()
    {
        // On ne récupère que les articles publics
        $articles = Article::where('public', true)
                        ->with('user')
                        ->latest()
                        ->paginate(9);

        return view('home.pages.article.list', compact('articles'));
    }

    public function show_article($slug)
    {
        // Récupération de l'article par son slug
        $article = Article::where('slug', $slug)
                    ->where('public', true)
                    ->firstOrFail();

        // Récupération de 3 articles récents (sauf celui en cours) pour la sidebar
        $recentArticles = Article::where('public', true)
                            ->where('id', '!=', $article->id)
                            ->latest()
                            ->take(3)
                            ->get();

        return view('home.pages.article.show', compact('article', 'recentArticles'));
    }
}
