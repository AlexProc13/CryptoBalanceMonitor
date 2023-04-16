<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HistoryBalance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'address'];

    /**
     * Get the comments for the blog post.
     */
    public function historyBalances(): HasMany
    {
        return $this->hasMany(HistoryBalance::class);
    }

    public function lastBalance()
    {
        return $this->hasOne(HistoryBalance::class)->latestOfMany()->withDefault(['balance' => 0]);
    }
}
