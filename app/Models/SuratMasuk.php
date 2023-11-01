<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $fillable = ['nomor', 'tanggal', 'diterima', 'asal', 'sifat', 'disposisi', 'perihal', 'file'];

    public function disposisi(): HasMany
    {
        return $this->hasMany(disposisi::class);
    }

    public function bagian(): BelongsToMany
    {
        return $this->belongsToMany(Bagian::class, 'disposisis', '');
    }
}
