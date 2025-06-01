<?php

namespace App\Enums;

enum StudentStatusEnum: string
{
    case IN_ACTIVE = 'inactive';
    case PENDING = 'pending';
    case ACTIVE = 'active';


    public function color(): string
    {
        return match ($this) {
            self::IN_ACTIVE => 'danger',
            self::PENDING => 'warning',
            self::ACTIVE => 'success'
        };
    }

    public function colorCode(): string
    {
        return match ($this) {
            self::IN_ACTIVE => '#dc3545',
            self::PENDING => '#ffc107',
            self::ACTIVE => '#198754'
        };
    }

    public function translated(): string
    {
        return match ($this) {
            self::IN_ACTIVE => __('messages.inactive'),
            self::PENDING => __('messages.pending'),
            self::ACTIVE => __('messages.active')
        };
    }

}
