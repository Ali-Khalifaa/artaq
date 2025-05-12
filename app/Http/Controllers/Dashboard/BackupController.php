<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\DatabaseBackupResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BackupController extends Controller implements HasMiddleware
{
    public function __construct(private  \App\Models\DatabaseBackup $model)
    {

    }
    public static function middleware(): array
    {
        return [
            new Middleware('can:database backup read', only: ['index']),
            new Middleware('can:database backup create', only: ['store']),
        ];
    }

    public function index(Request $request)
    {
        $carBrands = $this->model::searchAndFilter()->latest()->paginate(10);

        return responseJson(DatabaseBackupResource::collection($carBrands->items()),'',200,getPaginates($carBrands));
    }

    public function store(Request $request)
    {
        // check if folder uploads exists
        if (!\Illuminate\Support\Facades\File::exists(public_path('upload/database'))) {
            // if not create it
            \Illuminate\Support\Facades\File::makeDirectory(public_path('upload/database'));
        }
        // check if folder Laravel exists
        if (!\Illuminate\Support\Facades\File::exists(public_path('upload/database/' . env('APP_NAME')))) {
            // if not create it
            \Illuminate\Support\Facades\File::makeDirectory(public_path('upload/database/' . env('APP_NAME')));
        }
        \Illuminate\Support\Facades\Artisan::call("backup:run");

        $files = \Illuminate\Support\Facades\File::files(public_path('upload/database/' . env('APP_NAME')));
        foreach ($files as $file) {
            $path = $file->getFilename();
            $model = $this->model->where(
                'path',
                $path
            )->first();
            if (!$model) {
                $this->model->create([
                    'path' => $path,
                ]);
            }
        }

        return responseJson(200, 'created');

    }


}
