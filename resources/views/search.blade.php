@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search results</div>

                    <div class="card-body">
                        @if (count($users) > 0)
                            @foreach ($users as $key => $user)
                                <a href="{{ route('profile', ['id' => $user->id]) }}">
                                    <p>{{ $key + 1 }} - {{ $user->email }}</p>
                                </a>
                            @endforeach
                        @else
                            <p>Sorry, no results.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
