@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table id="Not-DataTable" class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th colspan="2">User</th>
                        <th>Actions</th>
                        <th>Tweet</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tweets as $tweet)
                        @if($tweet->filtered !== 1)
                            <tr @if($tweet->promoted == 1 ) class="promoted" @endif>
                                <td width="7%" id="{{ $tweet->tweet_user_id }}"><img class="img-responsive" src="{{ $tweet->tweet_avatar }}">
                                </td>
                                <td width="10%">
                                    <a href="https://twitter.com/{{ $tweet->tweet_userscreenname }}" target="_blank">
                                        {{ $tweet->tweet_username }}
                                        <br>
                                        <em>{{ '@'.$tweet->tweet_userscreenname }}</em></a>
                                </td>
                                <td width="15%">
                                    <button class="btn btn-sm btn-danger btn-cust" name="user_action"
                                            data-url="/block_user"
                                            data-userid="{{ $tweet->tweet_user_id }}"
                                            data-userscreenname="{{ $tweet->tweet_userscreenname }}">
                                        Block
                                    </button>

                                    <button class="btn btn-sm btn-success btn-cust" name="user_action"
                                            data-url="/promote_user"
                                            data-userid="{{ $tweet->tweet_user_id }}"
                                            data-userscreenname="{{ $tweet->tweet_userscreenname }}">
                                        Promote
                                    </button>
                                </td>
                                <td class="linkified">{{ $tweet->tweet_time }}
                                    <br />
                                    {{ $tweet->tweet_message }} <a href="https://twitter.com/{{ $tweet->tweet_userscreenname }}/status/{{ $tweet->tweet_id }}"
                                    target="_blank">(more)</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {{ $tweets->links() }}
            </div>
        </div>
    </div>
@endsection