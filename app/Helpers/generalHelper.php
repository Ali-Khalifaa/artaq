<?php

use App\Models\Country;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

function responseJson($object = null, $massage = '', $response_status = 200, $pagination = null)
{
    $response = [
        'message'     => $massage,
        'data'        => $object,
        'pagination'  => $pagination,
    ];

    return response()->json($response, $response_status);
}

function getPaginates($collection)
{
    return [
        'per_page' => $collection->perPage(),
        'path' => $collection->path(),
        'total' => $collection->total(),
        'current_page' => $collection->currentPage(),
        'next_page_url' => $collection->nextPageUrl(),
        'prev_page_url' => $collection->previousPageUrl(),
        'last_page' => $collection->lastPage(),
        'has_more_pages' => $collection->hasMorePages(),
        'from' => $collection->firstItem(),
        'to' => $collection->lastItem(),
    ];
}
function sendNotification($receivers, $modelData,$pageVueName,$notificationImage,$title, $message,$variables=[],$type = null,$expire_date = null)
{

    $receivers = $receivers instanceof \Illuminate\Database\Eloquent\Collection  || is_array($receivers) ? $receivers : [$receivers];

    try{
        foreach ($receivers as $receiver) {

            $receiver?->notify(new GeneralNotification(
                $modelData,
                $pageVueName,
                $notificationImage,
                $title,
                $message,
                $variables,
                $type,
                $expire_date
            ));

        }
    }catch(\Exception $e){
        storeNoteInErrorLog('Send Pusher Notification error: ' . $e->getMessage());
    }finally{
        return;
    }

}



function saveFiles($files, $model, $folder, $action = 'store', $identifier = null)
{
    if(!$files)
        return ;
    $files = is_array($files) ? $files : [$files]; // it works for single and multiple files
    if ($action == 'update' && count($files) > 0) {
        deleteFile($model);
    }
    foreach ($files as $file) {

        $file_size = $file->getSize();
        $file_type = $file->getMimeType();
        $image = time() . "-" . rand(0, 9999999) . '.' . $file->getClientOriginalName();

        // picture move
        $file->storeAs($folder, $image, 'general');

        $model->media()->create([
            'name' =>  $image,
            'size' => $file_size,
            'mime_type' => $file_type,
            'identifier' => $identifier,
        ]);
    }
}

function deleteFile($model)
{
    foreach ($model->media as $media) {
        unlink_image_by_path($media->name);
    }
    $model->media()->delete();
}

function store_single_image($file, $path = '')
{
    if(!$file || is_string($file)){
        return $file;
    }
    $path = $path ? rtrim($path, '/') . '/' : '';
    $image = time() . "-" . rand(0, 999999) . '.' . $file->getClientOriginalName();
    $file->storeAs('general', $path . $image, 'general');

    return $path . $image;
}

function unlink_image_by_path($image_path)
{
    if (File::exists(public_path("upload/general/$image_path")) && $image_path) {
        unlink(public_path("upload/general/$image_path"));
    }
}

function default_image($type = '')
{
    $images = [
        'noimage'   => 'images/language.png',
        'vehicles'  => 'images/language.png',
        'contacts'  => 'images/language.png',
    ];
    return asset(@$images[$type] ?? 'images/noimage.jfif');
}

function convertImageToWebp($path,$deleteOriginalFile = false,int $width = null,int $height = null){
    $manager = new ImageManager(new ImagickDriver());
    $fullPath = public_path("upload/general/" . $path);
    $image = $manager->read($fullPath);
    // $image->toWebp(5);
    if($width && $height) $image->resize($width, $height);

    $image->save($fullPath.'.webp', quality: 5, progressive: true);

    if($deleteOriginalFile) unlink_image_by_path($path);

    return $path.'.webp';
}


function generate_code($digits_number = 5) {
    if(request()->has('test')){ return '123456';}
    // Create a string of all alpha characters and randomly shuffle them
    $alpha   = str_shuffle('0123456789');

    // Grab the 4 first alpha characters
    $code = substr($alpha, 0, $digits_number);

    // Shuffle the code to get the alpha and numeric in random positions
    $code = str_shuffle($code);

    return $code;


//    return '12345'; // test code
}

function convertAndTranslateTime($timeInMinutes,$hours, $lang = 'ar')
{
    if($lang != 'ar')
        return floor($timeInMinutes / 60)  > 0 ? sprintf('%d h and  %d min', $hours, $timeInMinutes % 60) : sprintf('%d min', ($timeInMinutes < 1 ? 1 : $timeInMinutes) % 60); // shows duration in hours and minutes like  if i have 380 minutes appear like  6 h and 20 min

    $minutes =  ($timeInMinutes < 1 ? 1 : $timeInMinutes) % 60;
    $convertedMinutes = convertToArabicNumeral($minutes);
    if (floor($timeInMinutes / 60)  > 0) {
        $convertedHours = convertToArabicNumeral($hours);
        $hoursText = $convertedHours . (((int) $hours) <= 10 ? ' ساعات': ' ساعة');
        $minutesText = $convertedMinutes . (((int) $minutes) <= 10 ? ' دقائق': ' دقيقة');
        return "$hoursText و $minutesText";
    }
    $minutesText = $convertedMinutes .  ($minutes <= 10 ? ' دقائق': ' دقيقة');
    return $minutesText;
}

function convertToArabicNumeral($number) {
    $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    $arabicNumeral = '';

    // Convert each digit to Arabic numeral
    foreach (str_split($number) as $digit) {
        $arabicNumeral .= $arabicDigits[$digit];
    }

    return $arabicNumeral;
}

function getPeakPeriod($tableName){
    if(!Cache::has($tableName))
        Artisan::call('cache:peak-periods');

    if(Cache::has($tableName))
        return Cache::get($tableName);
}

function storeNoteInErrorLog($text){
    $filePath = public_path('user_error_log.txt');
    // Add a new line before writing to the file
    $textToWrite = PHP_EOL . $text;
    // Write the text to the file
    file_put_contents($filePath, $textToWrite, FILE_APPEND);
}

 function allOrPaginate($query,$resource,$groupBy = null )
{
    if (isset(request()->paginate) &&  request()->paginate != null){
        request()->validate([
            'paginate' => 'gt:0|lte:50'
        ]);
        $query = $query->paginate(request()->paginate);

        if ($groupBy != null){
            $data = $resource::collection($query->items())->groupBy($groupBy);
        }else{
            $data = $resource::collection($query->items());
        }
        $paginate = getPaginates($query);
    }else{
        if ($groupBy != null){
            $data = $resource::collection($query->get())->groupBy($groupBy);
        }else{
            $data = $resource::collection($query->get());
        }

        $paginate = null;
    }

    return ['data' =>$data ,'paginate'=>$paginate];

}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrs092u3tuvwxyzaskdhfhf9882323ABCDEFGHIJKLMNksadf9044OPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getCountryCodeByIp(){
    $ip = request()->ip();
    $response = Http::get("http://www.geoplugin.net/json.gp?ip=$ip");
    $ipCountryCode = $response->json()['geoplugin_countryCode']?? 'SA';
    $countriesCodes = Country::select('alpha_code')->get()->pluck('alpha_code')->toArray();
    return in_array($ipCountryCode, $countriesCodes) ? $ipCountryCode :'SA';
}


function getCurrencyRate($firstCurrency, $secondCurrency){
    $response = Http::get("https://api.exchangerate-api.com/v4/latest/$firstCurrency");
    return $response['rates'][$secondCurrency];
}


