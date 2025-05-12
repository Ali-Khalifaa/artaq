<?php

use App\Models\Booking;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('track-booking.{id}.{booking_no}', function ($user,$id, $booking_no) {
    return true;
},['guards' => ['admin_api']]);

Broadcast::channel('App.Models.Admin.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['admin_api']]);

Broadcast::channel('Modules.User.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['user_api']]);

Broadcast::channel('Modules.Driver.Models.Driver.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['driver_api']]);

Broadcast::channel('Modules.Showroom.Models.SRShowroom.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['showroom_api']]);

Broadcast::channel('Modules.Rest.Models.RestOwner.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['rest_api']]);

Broadcast::channel('Modules.Store.Models.StrOwner.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['store_api']]);
