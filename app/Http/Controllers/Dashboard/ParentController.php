<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ParentRequest;
use App\Http\Resources\Dashboard\ParentResource;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ParentController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:parent read', only: ['index']),
            new Middleware('can:parent create', only: ['store']),
            new Middleware('can:parent edit', only: ['update', 'show']),
            new Middleware('can:parent delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $parents = StudentParent::searchAndFilter()->latest()->paginate(10);

        return responseJson(ParentResource::collection($parents->items()),'',200,getPaginates($parents));
    }



    public function store(ParentRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        StudentParent::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $parent = StudentParent::with([
            'students.nationality',
            'students.country',
            'students.level'
        ])->find($id);
        if (!$parent) {
            return responseJson([],'Data not found',404);
        }
        return responseJson($parent,'Data exited successfully',200);
    }

    public function update(ParentRequest $request, $id)
    {
        $data = $request->validated();
        $parent = StudentParent::find($id);
        if (!$parent) {
            return responseJson([],'Data not found',404);
        }

        if($request->hasFile('image')){
            unlink_image_by_path($parent->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }

        $parent->update($data);
        return responseJson($parent,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $parent = StudentParent::find($id);
        if (!$parent) {
            return responseJson([],'Data not found',404);
        }
        unlink_image_by_path($parent->getAttributes()['image']);
        $parent->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
