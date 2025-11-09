<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PrivacyRequest;
use App\Models\Privacy;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PrivacyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // return [];
        return [
            new Middleware('can:privacy read', only: ['show']),
            new Middleware('can:privacy edit',only:['update']),
        ];
    }

    public function show($id)
    {
        $vision = Privacy::findOrFail($id);
        return responseJson($vision, 'Updated Successfully', 200);
    }

    public function update(PrivacyRequest $request,$id){
        $vision = Privacy::find($id);
         $vision->update([
            'content' => $request->content,
        ]);
        return responseJson($vision,'Updated Successfully', 200);
    }

}
