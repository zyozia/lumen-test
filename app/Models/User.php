<?php

namespace App\Models;

use App\Trait\JwtAuthTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordInterface;

/**
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property Collection|Company[] $companies
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordInterface
{
    use Authenticatable, Authorizable, HasFactory, Notifiable, CanResetPasswordTrait, JwtAuthTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * User's company relationship
     *
     * @return HasMany|Collection|Company[]
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
