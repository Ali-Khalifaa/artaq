<?php

namespace App\Enums;

enum SerialTypesEnum: string
{
    case STUDENT = 'Student';
    case TEACHER = 'Teacher';
    case ADMIN = 'Admin';

    public function label(): string
    {
        return match ($this) {
            self::STUDENT =>  __('label.student'),
            self::TEACHER => __('label.teacher'),
            self::ADMIN => __('label.admin'),
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
