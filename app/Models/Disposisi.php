<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disposisi extends Model
{
    use HasFactory;

    public function surat_masuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class);
    }
}
