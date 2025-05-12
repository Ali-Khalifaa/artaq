<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Interfaces\PageInterface;

class WebPagesController extends Controller
{
    protected $interface;
    protected $title = 'Pages';
    public function __construct(PageInterface $interface)
    {
        $this->interface = $interface;
    }
    /**
     * Display a listing of the resource.
    */
    public function terms(Request $request)
    {
        $page = Page::with('translations')->where('key','TermsConditionsWab')->where('client_type','User')->first();
        return responseJson(new PageResource($page),'Data exited successfully',200);
    }

    /**
     * Display a listing of the resource.
    */
    public function privacy(Request $request)
    {
        $page = Page::with('translations')->where('key','PrivacyPolicyWeb')->where('client_type','User')->first();
        return responseJson(new PageResource($page),'Data exited successfully',200);
    }

}
