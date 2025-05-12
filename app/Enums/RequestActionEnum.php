<?php

namespace App\Enums;

enum RequestActionEnum: string
{
    case WAIRING   = 'Waiting';
    case ACCEPT    = 'Accept';
    case REJECT    = 'Reject';

    public function label(): string
    {
        return match ($this) {
            self::WAIRING   => __('messages.waiting'),
            self::ACCEPT    => __('messages.accept'),
            self::REJECT    => __('messages.reject'),

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
