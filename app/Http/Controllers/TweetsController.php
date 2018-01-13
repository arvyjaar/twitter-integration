<?php

namespace App\Http\Controllers;

use App\BlockedUser;
use App\PromotedUser;
use App\FilteredKeyword;
use App\Tweet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TweetsController extends Controller
{
    /**
     * Display a listing of Tweets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*if (! Gate::allows('category_access')) {
            return abort(401);
        }*/
        $blocked_users = BlockedUser::all()->pluck('id_str')->toArray();

       if(! Cache::has('promoted')) {
            $promoted = PromotedUser::all()->pluck('id_str')->toArray();
            Cache::add('promoted', $promoted, 0.2);
       }

       if(! Cache::has('filtered')) {
            $filtered = FilteredKeyword::all()->pluck('keyword')->toArray();
            Cache::add('filtered', $filtered, 0.2);
       }

        $tweets = Tweet::whereNotIn('tweet_user_id', $blocked_users)->orderBy('tweet_id', 'desc')->paginate(50);

        return view('tweets.index', compact('tweets'));
    }
}
