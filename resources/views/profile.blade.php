@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>
                        <div class="container profile-block">
                            <div class="row">
                                <div class="col-md-6 profile-photo">
                                    <img src="https://ludirosta.ru/img/default_profile.jpg" class="profile-img">
                                </div>
                                <div class="col-md-6 profile-description">
                                    <h3>{{$user->name}} {{$user->surname}}</h3>
                                    <p class="h5 text-primary mt-2 d-block font-weight-light">
                                        {{ $user->email }}
                                    </p>
                                    <dl class="row mt-4 mb-4 pb-3">
                                        <dt class="col-sm-3">Gender</dt>
                                        <dd class="col-sm-9">{{ now()->year - $user->year }}</dd>

                                        <dt class="col-sm-3">Gender</dt>
                                        <dd class="col-sm-9">{{ $user->gender === 1 ? "Male" : "Female" }}</dd>

                                        <dt class="col-sm-3">City</dt>
                                        <dd class="col-sm-9">{{ $user->city }}</dd>

                                        <dt class="col-sm-3">Interests</dt>
                                        <dd class="col-sm-9">{{ $user->interests }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
