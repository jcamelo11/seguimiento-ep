<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Filament\Panel; 

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    public function instructorSeguimiento(): HasOne
    {
        return $this->hasOne(InstructorSeguimiento::class);
    }

    public function canAccessPanel(Panel $panel): bool 
    {
        // For the admin panel
        if ($panel->getId() === 'admin') {
            // Only allow access for admin role
            return $this->hasRole('super_admin');
        }

        if ($panel->getId() === 'instructoresseguimiento') {
            // Only allow access for admin role
            return $this->hasRole('instructor_seguimiento');
        }
        

        // Allow access to other panels
        return true;
    }

   
}
