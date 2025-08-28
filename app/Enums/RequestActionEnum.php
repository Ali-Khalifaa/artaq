<?php

namespace App\Enums;

enum RequestActionEnum: string
{
    case WAITING   = 'Waiting';
    case ACCEPT    = 'Accept';
    case REJECT    = 'Reject';
    case COMPLETED    = 'Completed';

    public function label(): string
    {
        return match ($this) {
            self::WAITING   => __('messages.waiting'),
            self::ACCEPT    => __('messages.accept'),
            self::REJECT    => __('messages.reject'),
            self::COMPLETED    => __('messages.completed'),

        };
    }

    public static function toDictionary(): array {
        $dictionary = [];
        foreach (self::cases() as $index=>$case) {
            $dictionary[$index]['name'] = $case->name;
            $dictionary[$index]['value'] = $case->value;
            $dictionary[$index]['label'] = $case->label();
        }
        return $dictionary;
    }

}
