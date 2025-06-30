<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SerialRequest;
use App\Http\Resources\Dashboard\SerialResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Enums\SerialTypesEnum;
use App\Models\Serial;

class SerialController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:serial read', only: ['index']),
            new Middleware('can:serial edit',only:['update', 'show']),
        ];
    }
    public function index(Request $request)
    {
        $serials = Serial::searchAndFilter()->latest()->paginate(10);

        return responseJson(SerialResource::collection($serials->items()), 'Serials', 200, getPaginates($serials));
    }

    public function show($id){
        $serial = Serial::find($id);
        return responseJson($serial, 'Updated Successfully', 200);
    }

    public function update(SerialRequest $request ,Serial $serial){
        $data =$request->validated();
        $serial->update($data);
        return responseJson(new SerialResource($serial),'Updated Successfully', 200);
    }

    public function enums ()
    {
        $types = SerialTypesEnum::toDictionary();
        return responseJson(['types'=>$types],'Deleted Successfully',200);
    }

}
