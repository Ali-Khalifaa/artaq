<?php


namespace App\Traits;

use App\Models\Serial;

trait SerialTrait
{

    function createSerialNumber($fullyQualifiedClassName,$type)
    {
        $serial = Serial::where('type',$type)->first();

        $model = new $fullyQualifiedClassName();
        $countRows = $model->withTrashed()->count();

        if($serial){
            $serialNumber = $serial->prefix . ($serial->start_number + $countRows);
            return $serialNumber;
        }

        return $countRows;
    }
}
