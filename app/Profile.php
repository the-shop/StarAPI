<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class Profile
 * @package App
 */
class Profile extends StarModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'github',
        'trello',
        'slack',
        'valid',
        'employee',
        'xp',
        'active',
        'xp_id',
        'admin',
        'role',
        'employeeRole',
        'skills',
        'minimumsMissed',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $model = new static($attributes);

        $model->xp = 50;
        $model->role = 'standard';
        $model->minimumsMissed = 0;

        $model->save();

        return $model;
    }

    /**
     * Passwords must always be hashed
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        // Let's hash the password when setting the attribute
        $this->attributes['password'] = Hash::make($password);
    }
}
