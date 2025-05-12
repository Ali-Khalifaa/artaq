<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DriverSettingRequest;
use App\Http\Requests\Dashboard\JoinUsRequest;
use App\Http\Resources\Dashboard\DriverSettingResource;
use App\Http\Resources\Dashboard\JoinUsResource;
use App\Models\DriverSetting;
use App\Models\JoinUs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JoinUsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:join us read', only: ['index']),
            new Middleware('can:join us edit',only:['update']),
        ];
    }
    public function index(Request $request)
    {
        $joinUs = JoinUs::searchAndFilter()->latest()->paginate(10);

        return responseJson(JoinUsResource::collection($joinUs->items()), 'joinUs', 200, getPaginates($joinUs));
    }

    public function show($id)
    {
        $JoinUs = JoinUs::findOrFail($id);
        return responseJson($JoinUs, 'Updated Successfully', 200);
    }

    public function update(JoinUsRequest $request,$id){
        $data =$request->validated();
        $joinUs = JoinUs::find($id);
        $joinUs->update($data);
        return responseJson(new JoinUsResource($joinUs),'Updated Successfully', 200);
    }

}
