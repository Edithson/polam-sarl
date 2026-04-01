<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['title', 'content', 'picture', 'public', 'user_id'];

    protected static function booted()
    {
        static::creating(function ($article) {
            // 1. Génération de l'ID unique (Ex: 8a2f-9b4e...)
            if (empty($article->id)) {
                $article->id = (string) Str::orderedUuid();
                // Note: orderedUuid est excellent pour les performances SQL
            }

            // 2. Génération du Slug intelligent
            if (empty($article->slug)) {
                $slug = Str::slug($article->title);

                // Vérification de l'unicité du slug
                $count = static::withTrashed()->where('slug', 'like', "$slug%")->count();
                $article->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }

    //utiliser le slug pour les routes au lieu de l'id
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //obtenir le user associé à l'article
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
