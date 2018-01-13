<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twitter;
use App\Tweet;

/**
 * Class SearchTweets
 * @package App\Console\Commands
 * Searches for tweets containing specified string
 * Uses package thujohn/twitter, Twitter Search API
 */
class SearchTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:search-keyword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for keywords being used on Twitter';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $max_tweet_id = Tweet::whereRaw('tweet_id = (SELECT MAX(`tweet_id`) FROM tweets)')->value('tweet_id');
        if(! $max_tweet_id) {
            $max_tweet_id = 0;
        }

        $tweets = Twitter::getSearch([
            'q'         => env('SEARCH_KEYWORD'),
            'count'     => '500', // Twitter API can return max 100 records per request.
            'since_id'  => $max_tweet_id,
            'lang'      => 'en',
        ]);

        if(isset($tweets->statuses) && is_array($tweets->statuses)) {
            if (count($tweets->statuses)) {
                Tweet::insertTweets($tweets);
            } else {
                echo 'The result is empty. It is possible that no new tweets found since last search.', "\n";
            }
        } else {
            throw new \Exception('$tweets->statuses is not set or it is not an array');
        }
    }
}
