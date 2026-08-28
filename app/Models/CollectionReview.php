<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectionReview extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const STATUS_LABELS = [
        self::STATUS_PENDING => 'Menunggu Verifikasi',
        self::STATUS_APPROVED => 'Disetujui',
        self::STATUS_REJECTED => 'Ditolak / Disembunyikan',
    ];

    protected $guarded = ['id'];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Scope: Hanya ulasan yang disetujui
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope: Ulasan yang menunggu moderasi
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: Ulasan yang ditolak
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Helper badge styling untuk Admin & UI
     */
    public function statusBadge(): array
    {
        return match ($this->status) {
            self::STATUS_APPROVED => [
                'label' => 'Disetujui',
                'class' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'icon' => 'fa-solid fa-circle-check text-emerald-500',
            ],
            self::STATUS_REJECTED => [
                'label' => 'Ditolak',
                'class' => 'bg-red-50 text-red-700 border border-red-200',
                'icon' => 'fa-solid fa-circle-xmark text-red-500',
            ],
            default => [
                'label' => 'Perlu Ditinjau',
                'class' => 'bg-amber-50 text-amber-700 border border-amber-200 animate-pulse',
                'icon' => 'fa-solid fa-clock text-amber-500',
            ],
        };
    }
}
