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
        if (!($originLink = $bitLy->getOriginalLink($short))) {
            abort(404);
        }

        return redirect(
            $originLink
        );
    }
}
