<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnLog extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'returned_at', 'condition_on_return', 'notes'];

    protected $casts = [
        'returned_at' => 'date',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class)->withTrashed();
    }
}
