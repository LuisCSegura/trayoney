<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'user_id',
        'account_id',
        'category_id',
        'destination_account_id',
        'detail',
        'amount',
        'type'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function destination_account()
    {
        return $this->belongsTo(Account::class, 'destination_account_id', 'id');
    }
}
