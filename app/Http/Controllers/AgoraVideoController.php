<?php

namespace App\Http\Controllers;

use App\Class\AgoraDynamicKey\RtcTokenBuilder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Events\MakeAgoraCall;

class AgoraVideoController extends Controller
{


    public function token(Request $request)
    {
        $user = auth()->user();
        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $request->channelName;
        $user = $user->name??$user->phone;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 20*60;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);

        return $token;
    }

    public function callUser(Request $request)
    {

        $data['userToCall'] = $request->user_to_call;
        $data['channelName'] = $request->channel_name;
        $data['from'] = Auth::id();

        broadcast(new MakeAgoraCall($data))->toOthers();
    }
}
