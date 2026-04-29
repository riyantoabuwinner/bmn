<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, Impersonate;

    /**
     * Determine if the user can impersonate another user.
     *
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->hasAnyRole(['superadmin', 'admin']);
    }

    /**
     * Determine if the user can be impersonated.
     *
     * @return bool
     */
    public function canBeImpersonated()
    {
        return !$this->hasRole('superadmin');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'unit_id',
        'phone',
        'is_active',
        'approval_status',
        'avatar',
        'signature',
    ];

    public function roleRequests()
    {
        return $this->hasMany(RoleRequest::class);
    }

    public function isApproved()
    {
        return $this->approval_status === 'approved';
    }

    public function adminlte_image()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://picsum.photos/300/300'; // Default placeholder
    }

    public function adminlte_desc()
    {
        return $this->getRoleNames()->first() ?? 'User';
    }

    public function adminlte_profile_url()
    {
        return route('profile.edit');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

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
        ];
    }
}
