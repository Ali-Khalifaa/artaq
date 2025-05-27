<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DigitalBadgeRequest;
use App\Http\Resources\Dashboard\DigitalBadgeResource;
use App\Models\DigitalBadge;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DigitalBadgeController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:digital badge read', only: ['index']),
            new Middleware('can:digital badge create', only: ['store']),
            new Middleware('can:digital badge edit', only: ['update', 'show']),
            new Middleware('can:digital badge delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $digitalBadge = DigitalBadge::searchAndFilter()->latest()->paginate(10);

        return responseJson(DigitalBadgeResource::collection($digitalBadge->items()),'',200,getPaginates($digitalBadge));
    }



    public function store(DigitalBadgeRequest $request)
    {

        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        DigitalBadge::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $digitalBadge = DigitalBadge::find($id);
        return responseJson($digitalBadge,'Data exited successfully',200);
    }

    public function update(DigitalBadgeRequest $request, $id)
    {
        $data = $request->validated();
        $digitalBadge = DigitalBadge::find($id);
        if($request->hasFile('image')){
            unlink_image_by_path($digitalBadge->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $digitalBadge->update($data);
        return responseJson($digitalBadge,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $digitalBadge = DigitalBadge::find($id);
        unlink_image_by_path($digitalBadge->getAttributes()['image']);
        $digitalBadge->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
