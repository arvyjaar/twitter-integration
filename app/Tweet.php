<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Tweet extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'tweet_id',
        'tweet_user_id',
        'tweet_username',
        'tweet_userscreenname',
        'tweet_avatar',
        'tweet_time',
        'tweet_message',
    ];

    /**
     * Create human readable date string
     * @param $value
     * @return false|string
     */
    public function getTweetTimeAttribute($value)
    {
        return Carbon::parse($value);
    }

    /**
     * Insert in to database tweets received from Twitter API
     * @param $tweets
     * @throws \Exception
     */
    public static function insertTweets($tweets)
    {
        $tweets_data = [];
        $rt = 0;
        foreach ($tweets->statuses as $tweet) {
            // Exclude retweets
            if (!isset($tweet->retweeted_status)) {
                $arr = [];
                $arr['tweet_id'] = $tweet->id_str;
                $arr['tweet_user_id'] = $tweet->user->id_str;
                $arr['tweet_username'] = $tweet->user->name;
                $arr['tweet_userscreenname'] = $tweet->user->screen_name;
                $arr['tweet_avatar'] = $tweet->user->profile_image_url_https;
                $arr['tweet_time'] = $tweet->created_at;
                $arr['tweet_message'] = $tweet->text;
                $arr['created_at'] = date('Y-m-d H:m:s');
                $tweets_data[] = $arr;
            }
            else $rt += 1;
        }
        if (Tweet::insert($tweets_data)) {
            echo count($tweets_data), ' rows inserted.', "\n";
        } else throw new \Exception('Insertion to database failed!');
        echo $rt, " retweets skipped"."\n";
    }

    /**
     * If author is promoted, mark this tweet as promoted
     * @return int
     */
    public function getPromotedAttribute()
    {
        $promoted = Cache::get('promoted');

        if (in_array($this->tweet_user_id, $promoted))
            return 1;
        else
            return 0;
    }

    /**
     * If tweet text contains at least one word from restricted keywords array,
     * this tweet will be marked as filtered =1
     *
     * @return int
     */
    public function getFilteredAttribute()
    {
        $filtered = Cache::get('filtered');

        $spam = 0;
        foreach ($filtered as $f) {
            if (strpos($this->tweet_message, $f) !== false) {
                $spam = 1;
            }
        }
        return $spam;
    }
}
