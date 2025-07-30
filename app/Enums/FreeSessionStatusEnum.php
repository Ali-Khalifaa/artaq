<?php

namespace App\Enums;

enum FreeSessionStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';


    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'primary',
            self::ACTIVE => 'success',
            self::COMPLETED => 'success',
            self::CANCELED => 'danger',
        };
    }

    public function colorCode(): string
    {
        return match ($this) {
            self::PENDING => '#ffc107',
            self::APPROVED => '#49b6f5',
            self::ACTIVE => '#198754',
            self::COMPLETED => '#198754',
            self::CANCELED => '#dc3545',
        };
    }

    public function translated(): string
    {
        return match ($this) {
            self::PENDING => __('messages.pending'),
            self::APPROVED => __('messages.approved'),
            self::ACTIVE => __('messages.active'),
            self::COMPLETED => __('messages.completed'),
            self::CANCELED => __('messages.canceled'),
        };
    }

}
