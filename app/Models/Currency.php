<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'abbreviation', 'name', 'simbol', 'rate', 'is_base_currency'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
