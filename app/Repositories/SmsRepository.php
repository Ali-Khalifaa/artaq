<?php
namespace App\Repositories;
use App\Interfaces\PageInterface;
use App\Interfaces\SmsInterface;
use App\Models\Page;
use App\Models\SmsSetting;

class SmsRepository extends BaseRepository implements SmsInterface
{

    protected $model;
    protected $app_id ,$app_sec,$app_hash,$url ;


    public function __construct(SmsSetting $model)
    {
        $this->model = $model;
    }

    public function smsDate($phones, $massage)
    {
        $array             = [];
        $data              = $this->model->first();
        $array['app_id']   = $data->api_key;
        $array['app_sec']  = $data->api_secret;
        $array['app_hash'] = base64_encode("{$array['app_id']}:{$array['app_sec']}");
        $array['url']      = "https://api-sms.4jawaly.com/api/v1/account/area/sms/send";
        $array['messages'] = [
            "messages" => [
                [
                    "text" => $massage,
                    "numbers" => $phones,
                    "sender" => "Lee Taxi"
                ]
            ]
        ];
        $array['headers'] = [
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic {$array['app_hash']}"
        ];

        $array['curl'] = curl_init($array['url']);
        curl_setopt($array['curl'], CURLOPT_POST, true);
        curl_setopt($array['curl'], CURLOPT_POSTFIELDS, json_encode($array['messages']));
        curl_setopt($array['curl'], CURLOPT_HTTPHEADER, $array['headers']);
        curl_setopt($array['curl'], CURLOPT_RETURNTRANSFER, true);

        $response    = curl_exec($array['curl']);
        $status_code = curl_getinfo($array['curl'], CURLINFO_HTTP_CODE);
        curl_close($array['curl']);

        $array['response_json'] = json_decode($response, true);

        if ($status_code == 200) {
            if (isset($array['response_json']["messages"][0]["err_text"])) {
                $array['response'] = $array['response_json']["messages"][0]["err_text"];
            } else {
                $array['response'] = "تم الارسال بنجاح  " . " job id:" . $array['response_json']["job_id"];
            }
        } elseif ($status_code == 400) {
            $array['response'] = $array['response_json']["message"];
        } elseif ($status_code == 422) {
            $array['response'] = "نص الرسالة فارغ";
        } else {
            $array['response'] = "محظور بواسطة كلاودفلير. Status code: {$status_code}";
        }
        return $array;

    }

    public function sendOtp($phones, $massage)
    {
      return  $this->smsDate($phones ,$massage);
    }

}
