<?php

namespace App\Enums;

enum ExpireStatus: string
{
    case ACTIVE = 'Active';
    case EXPIRED = 'Expired';

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::EXPIRED => 'danger',
        };
    }

    public function translate(): string
    {
        return match ($this) {
            self::ACTIVE => __('messages.active'),
            self::EXPIRED => __('messages.expired'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ACTIVE => 'bx bx-check',
            self::EXPIRED => 'bx bx-x',
        };
    }

}
