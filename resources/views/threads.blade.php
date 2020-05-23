@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Messages</div>

                    <div class="card-body">
                        @if (count($threads) > 0)
                            @foreach ($threads as $key => $user)
                                <a href="{{ route('messages', ['userId' => $user->getId()]) }}">
                                    <div class="jumbotron" >
                                        <h2>{{ $user->getEmail() }}</h2>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <p>No dialogs)</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
