<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'customer_name',
        'phone',
        'email',
        'quantity',
        'notes',
        'status',
        'read_at',
    ];

    /**
     * Available statuses and their default human-readable labels.
     */
    public const STATUSES = [
        'pending' => 'قيد الانتظار',
        'contacted' => 'تم التواصل',
        'in_progress' => 'قيد التسعير والدراسة',
        'completed' => 'مكتمل / تم تقديم العرض',
        'cancelled' => 'ملغي',
    ];

    /**
     * Get localized statuses array.
     *
     * @return array<string, string>
     */
    public static function localizedStatuses(): array
    {
        return array_map(fn(string $label) => __($label), self::STATUSES);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Scope a query to only include unread pending quote requests.
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'pending')->whereNull('read_at');
    }

    /**
     * Determine if the quote request notification is unread.
     */
    public function getIsUnreadAttribute(): bool
    {
        return $this->status === 'pending' && is_null($this->read_at);
    }

    /**
     * Get the product associated with the quote request.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the human-readable localized status label.
     */
    public function getStatusLabelAttribute(): string
    {
        $label = self::STATUSES[$this->status] ?? $this->status;

        return __($label);
    }

    /**
     * Get Tailwind CSS badge classes based on status.
     */
    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-50 text-amber-700 border-amber-200/80',
            'contacted' => 'bg-blue-50 text-blue-700 border-blue-200/80',
            'in_progress' => 'bg-purple-50 text-purple-700 border-purple-200/80',
            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
            'cancelled' => 'bg-slate-100 text-slate-600 border-slate-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }

    /**
     * Get status indicator dot color.
     */
    public function getStatusDotClassesAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-amber-500',
            'contacted' => 'bg-blue-500',
            'in_progress' => 'bg-purple-500',
            'completed' => 'bg-emerald-500',
            'cancelled' => 'bg-slate-400',
            default => 'bg-slate-400',
        };
    }

    /**
     * Generate clean WhatsApp click-to-chat URL.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $this->phone);
        if (str_starts_with($phone, '05')) {
            $phone = '966' . substr($phone, 1);
        } elseif (str_starts_with($phone, '5')) {
            $phone = '966' . $phone;
        }

        if (app()->getLocale() === 'en') {
            $message = urlencode("Hello {$this->customer_name}, we are contacting you from Nibras Al-Arab Printing Press regarding quote request #{$this->id}" . ($this->product ? " for product: {$this->product->name}" : '') . '.');
        } else {
            $message = urlencode("مرحباً {$this->customer_name}، نتواصل معك من مطبعة نبراس العرب بخصوص طلب تسعير رقم #{$this->id}" . ($this->product ? " لمنتج: {$this->product->name}" : '') . '.');
        }

        return "https://wa.me/{$phone}?text={$message}";
    }
}
