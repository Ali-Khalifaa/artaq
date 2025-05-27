<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TeacherBadgeRequest;
use App\Http\Resources\Dashboard\TeacherBadgeResource;
use App\Models\TeacherBadge;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TeacherBadgeController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:teacher badge read', only: ['index']),
            new Middleware('can:teacher badge create', only: ['store']),
            new Middleware('can:teacher badge edit', only: ['update', 'show']),
            new Middleware('can:teacher badge delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $digitalBadge = TeacherBadge::searchAndFilter()->latest()->paginate(10);

        return responseJson(TeacherBadgeResource::collection($digitalBadge->items()),'',200,getPaginates($digitalBadge));
    }



    public function store(TeacherBadgeRequest $request)
    {

        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        TeacherBadge::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $digitalBadge = TeacherBadge::find($id);
        return responseJson($digitalBadge,'Data exited successfully',200);
    }

    public function update(TeacherBadgeRequest $request, $id)
    {
        $data = $request->validated();
        $digitalBadge = TeacherBadge::find($id);
        if($request->hasFile('image')){
            unlink_image_by_path($digitalBadge->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $digitalBadge->update($data);
        return responseJson($digitalBadge,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $digitalBadge = TeacherBadge::find($id);
        unlink_image_by_path($digitalBadge->getAttributes()['image']);
        $digitalBadge->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
