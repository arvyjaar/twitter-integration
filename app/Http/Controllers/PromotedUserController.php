<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PromotedUser;
use Illuminate\Http\Response;

class PromotedUserController extends Controller
{
    /**
     * Create a new blocked user instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Validate the request...

        if (! PromotedUser::where('id_str', $request->id_str)->first()) {
            $user = new PromotedUser();

            $user->id_str = $request->id_str;
            $user->screen_name = $request->screen_name;

            $user->save();

            return response()->json(['msg' => $user->screen_name.' promoted!'], 200);
        } else {
            return response()->json(['msg' => 'User '.$request->screen_name.' already promoted.'], 200);
        }
    }

    /**
     * List all promoted authors
     * @return Response
     */
    public function index()
    {
        $authors = PromotedUser::all();

        return view('authors.index', compact('authors'));
    }
}
