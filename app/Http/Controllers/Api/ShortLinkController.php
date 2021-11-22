<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\BitLy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortLinkController extends Controller
{
    /**
     * @var BitLy
     */
    protected BitLy $service;

    /**
     * ShortLinkController constructor.
     * @param BitLy $service
     */
    public function __construct(BitLy $service)
    {
        $this->service = $service;
    }

    public function short(Request $request)
    {

        $validator = Validator::make(['url' => $request->input('url')], [
            "url" => "required|url"
        ]);

        $data = $validator->validated();

        $shortlink = $this->service->shortProcess($data['url']);

        return redirect("/?link=" . $shortlink);

    }
}
//. __DIR__ . "?link=" . $shortlink
