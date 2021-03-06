<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlockedUser;
use Illuminate\Http\Response;

class BlockedUserController extends Controller
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

        if (! BlockedUser::where('id_str', $request->id_str)->first()) {
            $user = new BlockedUser();

            $user->id_str = $request->id_str;
            $user->screen_name = $request->screen_name;

            $user->save();

            return response()->json(['msg' => $user->screen_name.' blocked!'], 200);
        } else {
            return response()->json(['msg' => 'User '.$request->screen_name.' already blocked.'], 200);
        }
    }

    /**
     * List all blocked authors
     * @return Response
     */
    public function index()
    {
        $authors = BlockedUser::all();

        return view('authors.index', compact('authors'));
    }
}
