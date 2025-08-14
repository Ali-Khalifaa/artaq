<?php

use App\Models\Booking;
use App\Models\FreeSession;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('student.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['student_api']]);


Broadcast::channel('teacher.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['teacher_api']]);


Broadcast::channel('App.Models.Admin.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
}, ['guards' => ['admin_api']]);

Broadcast::channel('session-{sessionId}', function ($user,$sessionId) {
    $session = FreeSession::find($sessionId);
    return $session && (($session->teacher_id == $user->id && get_class($user) == Teacher::class) || ($session->student_id == $user->id && get_class($user) == Student::class)) ;
});
