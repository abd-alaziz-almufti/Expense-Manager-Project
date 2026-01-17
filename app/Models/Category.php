<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'expected_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function monthlyExpenses(): float
    {
        return $this->expenses()
            ->currentMonth()
            ->sum('amount');
    }

    public function remainingAmount(): float
    {
        return $this->expected_amount - $this->monthlyExpenses();
    }


    public function spentThisMonth(): float
    {
        return $this->expenses()
            ->currentMonth()
            ->sum('amount');
    }


    public function isOverBudget(): bool
    {
        return $this->spentThisMonth() > $this->expected_amount;
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->id();
        });
    }
}
