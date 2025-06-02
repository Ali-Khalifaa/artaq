<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\QuranResource;
use App\Models\Ayah;
use App\Models\Surah;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class QuranController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware('can:quran read', only: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $memorization = Surah::searchAndFilter()->paginate(20);

        return responseJson(QuranResource::collection($memorization->items()),'',200,getPaginates($memorization));
    }

    public function show(Request $request,$id)
    {
        $ayahs = Ayah::where('surah_id',$id)->where('page',$request->page)->get();
        return responseJson($ayahs,'Data exited successfully',200);
    }

    public function getSurahDropdown()
    {
        $surah = Surah::all();

        return responseJson($surah,'Data exited successfully',200);
    }

    public function getAyahsBySurahId( $id)
    {
        $ayahs = Ayah::where('surah_id', $id)->get();
        return responseJson($ayahs, 'Data exited successfully', 200);
    }

}
