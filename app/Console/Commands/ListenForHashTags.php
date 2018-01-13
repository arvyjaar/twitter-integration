<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TwitterStreamingApi;

/**
 * Class ListenForHashTags
 * @package App\Console\Commands
 * Command once entered - runs forever. Listens for string in real time, uses Twitter Streaming API, Phirehose,
 * Package: spatie/laravel-twitter-streaming-api
 */
class ListenForHashTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:listen-for-hash-tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for hashtags being used on Twitter';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        TwitterStreamingApi::publicStream()
            ->whenHears(env('SEARCH_KEYWORD'), function (array $tweet) {
                dump($tweet);
                dump("{$tweet['user']['screen_name']} tweeted {$tweet['text']}");
            })
            ->startListening();
    }
}