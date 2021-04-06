@extends('layouts.app')
@section('styles')
    <style>
        body{
            background-image: url({{asset('images/mix.jpg')}});
            background-repeat: no-repeat;
            background-size: 100%;
            background-attachment: fixed;
        }
        .btn-image{
            width: 100px;
        }
        .card{
            backdrop-filter: blur(20px);
            background-color: rgba(38, 42, 48, 0.4);
            color: rgba(205, 225, 255, 0.3);
            border-radius: 10px;
            border: solid 2px rgba(145, 185, 255, 0.1);
            padding: 10px;
            box-shadow: 0px 0px 7px rgba(0, 0, 0, 0.3);
        }
        h1{
            margin: 20px;
            font-size: 50px;
            width: auto;
            color: rgba(205, 225, 255, 0.3);
            border-bottom:solid 3px rgba(145, 185, 255, 0.1);
        }
        .btn-main{
            padding:15px 20px 15px 20px;
            border:none;
            background-color: #4B0082;
            border-radius: 50px;
            color: #fff;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        }
        .btn-main:hover{
            text-decoration: none;
            color: #fff;
            background-color: #5B1092;
        }
        .login{
            padding: 10px 20px 10px 20px;
            margin-right: 10px;
            background-color: #008CD4;
        }
        .login:hover{
            background-color: #009Ce4;
        }
        .input-trn{
            background-color:  rgba(145, 185, 255, 0.1);
            color: white;
            border-radius: 50px;
            border: none;
        }
        .input-trn:focus{
            background-color:  rgba(145, 185, 255, 0.1);
            color: white;
            border-radius: 50px;
            border: none;
            box-shadow: none;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="m0 vh-100 row justify-content-center align-items-center" >
        <div class="col-md-8">
            <div class="card">
                <h1>REGISTER</h1>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control input-trn @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control input-trn @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control input-trn @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control input-trn" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="form-control btn-main login">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
