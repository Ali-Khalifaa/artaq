<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PrivacyRequest;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PolicyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:policy read', only: ['show']),
            new Middleware('can:policy edit',only:['update']),
        ];
    }

    public function show($id)
    {
        $vision = Policy::findOrFail($id);
        return responseJson($vision, 'Updated Successfully', 200);
    }

    public function update(PrivacyRequest $request,$id){
        $vision = Policy::find($id);
        $vision->update([
            'content' => $request->content,
        ]);
        return responseJson($vision,'Updated Successfully', 200);
    }

}
