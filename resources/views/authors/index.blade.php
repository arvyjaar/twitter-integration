@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table id="DataTable" class="display">
                    <thead>
                    <tr>
                        <th>User name</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($authors as $author)
                        <tr>
                            <td>
                                <a href="https://twitter.com/{{ $author->screen_name }}"
                                   target="_blank" title="Link to user">{{ $author->screen_name }}</a>
                            </td>
                            <td>
                                {{ $author->created_at }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection