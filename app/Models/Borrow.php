<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Borrow extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
        'return_at' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function borrow_books(): HasMany
    {
        return $this->hasMany(BorrowBook::class);
    }

    protected function lateDays(): Attribute
    {
        return Attribute::make(
            get: function () {
                $tanggal_kembali = $this->end_at;
                $tanggal_dikembalikan = $this->return_at;

                if ($tanggal_kembali->isFuture() and empty($this->return_at)) {
                    return 0;
                }

                if (empty($this->return_at)) $tanggal_dikembalikan = now();

                return $tanggal_kembali->diffInDays($tanggal_dikembalikan);
            },
        );
    }

    protected function lateFee(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->late_days * $this->late_price;
            }
        );
    }

    protected function lostFee(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->return_at)) return 0;
                return ($this->books_borrowed - $this->books_returned) * $this->book_price;
            }
        );
    }
}
