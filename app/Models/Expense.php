<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'expense_date',
        'note',
    ];

    protected $casts = [
        'expense_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope: current month expenses
     */
    public function scopeCurrentMonth(Builder $query)
    {
        return $query
            ->whereYear('expense_date', now()->year)
            ->whereMonth('expense_date', now()->month);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
