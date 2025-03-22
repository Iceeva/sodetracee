<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    /**
     * Vérifie si l'utilisateur est un administrateur.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un agent.
     */
    public function isAgent()
    {
        return $this->role === 'agent';
    }

    /**
     * Vérifie si l'utilisateur est un acheteur.
     */
    public function isAcheteur()
    {
        return $this->role === 'acheteur';
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Ajout du champ rôle
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
