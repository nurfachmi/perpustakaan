<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowBook extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function borrow(): BelongsTo
    {
        return $this->belongsTo(Borrow::class);
    }
}
