<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MemorizationAmountRequest;
use App\Http\Resources\Dashboard\MemorizationAmountResource;
use App\Models\MemorizationAmount;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MemorizationAmountController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:memorization amount read', only: ['index']),
            new Middleware('can:memorization amount create', only: ['store']),
            new Middleware('can:memorization amount edit', only: ['update', 'show']),
            new Middleware('can:memorization amount delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $memorization = MemorizationAmount::searchAndFilter()->latest()->paginate(10);

        return responseJson(MemorizationAmountResource::collection($memorization->items()),'',200,getPaginates($memorization));
    }



    public function store(MemorizationAmountRequest $request)
    {
        $data = $request->validated();
        MemorizationAmount::create($data);
        return responseJson([],'Created Successfully',200);
    }


    public function show($id)
    {
        $memorization = MemorizationAmount::find($id);
        return responseJson($memorization,'Data exited successfully',200);
    }

    public function update(MemorizationAmountRequest $request, $id)
    {
        $data = $request->validated();
        $memorization = MemorizationAmount::find($id);
        if (!$memorization) {
            return responseJson([],'Data not found',404);
        }

        $memorization->update($data);
        return responseJson($memorization,'Updated Successfully',200);
    }

    public function destroy($id)
    {
        $memorization = MemorizationAmount::find($id);
        if (!$memorization) {
            return responseJson([],'Data not found',404);
        }
        $memorization->delete();
        return responseJson([],'Deleted Successfully',200);
    }

    public function dropdown()
    {
        $level = MemorizationAmount::all();

        return responseJson(MemorizationAmountResource::collection($level),'',200);
    }
}
