<?php

namespace App\Enums;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Tax;
use Modules\Driver\Models\Driver;
use Modules\Rest\Models\RestRestaurant;
use Modules\User\Models\User;

enum ClientTypeEnum: string
{

    case USER   = 'User';
    case DRIVER = 'Driver';
    case RESTAURANT = 'Restaurant';


    public function label(): string
    {
        return match ($this) {
            self::USER   => __('messages.user'),
            self::DRIVER => __('messages.driver'),
            self::RESTAURANT => __('messages.restaurant'),

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
