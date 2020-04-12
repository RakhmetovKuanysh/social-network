@extends('layouts.app')

@php
    $sessionUser = \Illuminate\Support\Facades\Session::get('user');
@endphp
@section('content')
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="container d-flex justify-content-center">
            <div class="col-md-8">
                @if(session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="card card-bordered">
                    <div class="card-header">
                        <h4 class="card-title"><strong>Chat - {{ $user->getEmail() }}</strong></h4>
                    </div>
                    <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:470px !important;">
                        {{--<div class="media media-meta-day">Today</div>--}}
                        @foreach ($messages as $key => $message)
                            @if ($message->getSenderId() == $sessionUser->getId())
                                @php
                                    $isPreviousMy = isset($messages[$key - 1])
                                        && $messages[$key - 1]->getSenderId() == $sessionUser->getId();
                                    $isNextMy = isset($messages[$key + 1])
                                        && $messages[$key + 1]->getSenderId() == $sessionUser->getId();
                                @endphp
                                @if (!$isPreviousMy)
                                    <div class="media media-chat media-chat-reverse">
                                        <div class="media-body">
                                @endif
                                    <p>{{ $message->getText() }}</p>
                                @if (!$isNextMy)
                                        </div>
                                    </div>
                                @endif
                            @else
                                @php
                                    $isPreviousOther = isset($messages[$key - 1])
                                        && $messages[$key - 1]->getReceiverId() == $sessionUser->getId();
                                    $isNextOther = isset($messages[$key + 1])
                                        && $messages[$key + 1]->getReceiverId() == $sessionUser->getId();
                                @endphp
                                @if (!$isPreviousOther)
                                    <div class="media media-chat">
                                        <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                                        <div class="media-body">
                                @endif
                                    <p>{{ $message->getText() }}</p>
                                @if (!$isNextOther)
                                            <p class="meta">{{ $message->getCreatedAt() }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                            <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                            <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                        </div>
                    </div>
                    <div class="publisher bt-1 border-light">
                        <form action="{{ route('sendMessage') }}" method="POST">
                            @csrf
                            <img class="avatar avatar-xs" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                            <input class="publisher-input" type="text" placeholder="Write something" name="text">
                            <input type="text" name="userId" placeholder="userId" value="{{ $user->getId() }}" hidden>
                            <input type="submit" hidden />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
