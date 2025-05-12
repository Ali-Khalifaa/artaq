<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BannerRequest;
use App\Http\Resources\Dashboard\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class BannerController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:banner read', only: ['index']),
            new Middleware('can:banner create', only: ['store']),
            new Middleware('can:banner edit', only: ['update', 'show']),
            new Middleware('can:banner delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $banners = Banner::searchAndFilter()->latest()->paginate(10);

        return responseJson(BannerResource::collection($banners->items()),'',200,getPaginates($banners));
    }



    public function store(BannerRequest $request)
    {
        $data = $request->validated();
        $data['image'] = store_single_image($request->image);
        Banner::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show(Banner $banner)
    {
        return responseJson($banner,'Data exited successfully',200);
    }

    public function update(BannerRequest $request, Banner $banner)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            unlink_image_by_path($banner->getAttributes()['image']);
            $data['image'] = store_single_image($request->image);
        }
        $banner->update($data);
        return responseJson($banner,'Updated Successfully',200);
    }

    public function destroy(Banner $banner)
    {
        unlink_image_by_path($banner->getAttributes()['image']);
        $banner->delete();
        return responseJson([],'Deleted Successfully',200);
    }
}
