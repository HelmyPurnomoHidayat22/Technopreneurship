<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
        'status',
        'payment_proof_path',
        'download_token',
        'token_expired_at',
        'order_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'custom_category',
        'custom_notes',
        'custom_deadline',
        'custom_reference_link',
        'rejection_note',
        'rejected_at',
    ];

    protected $casts = [
        'token_expired_at' => 'datetime',
        'rejected_at' => 'datetime',
        'custom_deadline' => 'date',
    ];


    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the order.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Generate unique order code
     */
    public static function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . strtoupper(Str::random(8));
        } while (self::where('order_code', $code)->exists());

        return $code;
    }

    /**
     * Generate download token
     */
    public function generateDownloadToken(): void
    {
        $this->download_token = Str::random(64);
        $this->token_expired_at = Carbon::now()->addDays(7);
        $this->save();
    }

    /**
     * Check if download token is valid
     */
    public function isDownloadTokenValid(): bool
    {
        if (!$this->download_token || !$this->token_expired_at) {
            return false;
        }

        return Carbon::now()->lessThan($this->token_expired_at);
    }

    /**
     * Get payment proof URL
     */
    public function getPaymentProofUrlAttribute()
    {
        if (!$this->payment_proof_path) {
            return null;
        }

        // Extract filename from path
        $filename = basename($this->payment_proof_path);
        return route('files.payment', ['orderId' => $this->id, 'path' => $filename]);
    }

    /**
     * Get custom design files for this order
     */
    public function customDesignFiles()
    {
        return $this->hasMany(CustomDesignFile::class);
    }

    /**
     * Get messages for this order
     */
    public function messages()
    {
        return $this->hasMany(OrderMessage::class);
    }

    /**
     * Check if order is custom design
     */
    public function isCustomDesign(): bool
    {
        return $this->product && $this->product->category && 
               $this->product->category->name === 'Custom Design';
    }

    /**
     * Check if chat is active for this order
     */
    public function isChatActive(): bool
    {
        return in_array($this->status, ['approved', 'in_progress', 'revision']);
    }
}
