<?php
namespace App\Interfaces;

interface SmsInterface extends BaseInterface
{
   public function sendOtp($phone,$massage);
}
