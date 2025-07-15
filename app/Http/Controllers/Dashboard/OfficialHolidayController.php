<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OfficialHolidayRequest;
use App\Http\Resources\Dashboard\OfficialHolidayResource;
use App\Models\OfficialHoliday;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OfficialHolidayController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:official holiday read', only: ['index']),
            new Middleware('can:official holiday create', only: ['store']),
            new Middleware('can:official holiday edit', only: ['update', 'show']),
            new Middleware('can:official holiday delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $nationality = OfficialHoliday::searchAndFilter()->latest()->paginate(10);

        return responseJson(OfficialHolidayResource::collection($nationality->items()),'',200,getPaginates($nationality));
    }



    public function store(OfficialHolidayRequest $request)
    {
        $data = $request->validated();
        OfficialHoliday::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $nationality = OfficialHoliday::find($id);
        return responseJson($nationality,'Data exited successfully',200);
    }

    public function update(OfficialHolidayRequest $request, $id)
    {
        $data = $request->validated();
        $nationality = OfficialHoliday::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }

        $nationality->update($data);
        return responseJson($nationality,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $nationality = OfficialHoliday::find($id);
        if (!$nationality) {
            return responseJson([],'Data not found',404);
        }
        $nationality->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
