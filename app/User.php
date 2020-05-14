<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;



    /** @var string SUPER_ADMIN_ROLE */
    public const SUPER_ADMIN_ROLE = 'Super Admin';

    /** @var string ADMIN_ROLE */
    public const ADMIN_ROLE = 'Admin';

    /** @var string SUPERVISOR_ROLE */
    public const SUPERVISOR_ROLE = 'Supervisor';

    /** @var string OPERATING_AGENT_ROLE */
    public const OPERATING_AGENT_ROLE = 'Operating Agent';

    /** @var string USER_ROLE */
    public const USER_ROLE = 'User';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $guard_name = 'api';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getJWTIdentifier()
    {

        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }



    /**
     * Check if logged in user has the "Admin" role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(self::ADMIN_ROLE);
    }

    /**
     * Check if logged in user has the "Super Admin" role.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(self::SUPER_ADMIN_ROLE);
    }

    /**
     * Check if logged in user has the "Operating Agent" role.
     *
     * @return bool
     */
    public function isOperatingAgent(): bool
    {
        return $this->hasRole(self::OPERATING_AGENT_ROLE);
    }

    /**
     * Check if logged in user has the "supervisor" role.
     *
     * @return bool
     */
    public function isSupervisor(): bool
    {
        return $this->hasRole(self::SUPERVISOR_ROLE);
    }

    /**
     * Check if logged in user has the "user" role.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->hasRole(self::USER_ROLE);
    }


}
