<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function base_currency()
    {
        return $this->belongsTo(Currency::class, 'id', 'base_currency_user_id');
    }
    public function shared_accounts()
    {
        return $this->belongsToMany(Account::class, 'accounts_users', 'user_id', 'account_id');
    }
}
