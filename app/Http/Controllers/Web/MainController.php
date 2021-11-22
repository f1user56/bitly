<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Services\BitLy;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function view(Request $request)
    {
        return view('main', [
            'shortLink' => null,
            'error' => $request->input('error'),
            'link' => $request->input('link')
        ]);
    }

    public function redirect($short, BitLy $bitLy)
    {
        return redirect(
            $bitLy->getOriginalLink($short)
        );
    }
}
