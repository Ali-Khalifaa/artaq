<?php

namespace App\Enums;

enum ExamStatusEnum: string
{
    case PENDING = 'pending';
    case SUCCESSED = 'successed';
    case FAILED = 'failed';


    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::SUCCESSED => 'success',
            self::FAILED => 'danger',
        };
    }

    public function colorCode(): string
    {
        return match ($this) {
            self::PENDING => '#ffc107',
            self::SUCCESSED => '#198754',
            self::FAILED => '#dc3545',
        };
    }

    public function translated(): string
    {
        return match ($this) {
            self::PENDING => __('messages.pending'),
            self::SUCCESSED => __('messages.successed'),
            self::FAILED => __('messages.failed'),
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'bi bi-clock',
            self::SUCCESSED => 'bi bi-check-circle',
            self::FAILED => 'bi bi-x-circle',
        };
    }

}
