<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'currency_id', 'abbreviation', 'name', 'balance', 'is_debit'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
