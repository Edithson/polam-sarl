<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Article;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enums\AccessLevel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permissions' => 'array', // Cast 'permissions' as an array
        ];
    }

    //obtenir les articles associés à l'utilisateur
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    //méthode de vérification des permissions
    public function hasPermission(string $feature, AccessLevel $level): bool
    {
        $userPerm = $this->permissions[$feature] ?? 'none';

        // Logique de hiérarchie simple ou stricte
        if ($level === AccessLevel::FULL) {
            return $userPerm === AccessLevel::FULL->value;
        }

        if ($level === AccessLevel::AUTHOR) {
            return in_array($userPerm, [AccessLevel::AUTHOR->value, AccessLevel::FULL->value]);
        }

        return $userPerm !== AccessLevel::NONE->value;
    }
}
