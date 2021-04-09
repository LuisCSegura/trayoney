@extends('layouts.sidebar')
@section('stylesfluid')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
  
     <h1>Welcome {{Auth::user()->name}}!!!</h1>
  
    </div>
    @if(Auth::user()->base_currency == null)
    <div class="dark-background">
      <div class="float-container">
        <div class="modal-content card">
          <div class="modal-body">
            <h1 class="form-title">BASE CURRENCY</h1>
            <form method="POST" action="/currencies">
              @csrf
              <input id="base_currency_user_id" type="hidden" name="base_currency_user_id" value="{{Auth::user()->id}}">
              <input id="rate" type="hidden" name="rate" value="1">
              <div class="form-group row m-2">
                <label for="simbol" class="col-md-4 col-form-label text-md-right">Simbol</label>
  
                <div class="col-md-8 m-0 p-0">
                    <input id="simbol" type="text" maxlength="1" class="form-control input-trn @error('simbol') is-invalid @enderror" name="simbol" value="{{ old('simbol') }}" required>
  
                    @error('simbol')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
              <div class="form-group row m-1">
                <label for="abbreviation" class="col-md-4 col-form-label text-md-right">Abbreviation</label>
  
                <div class="col-md-8 m-0 p-0">
                    <input id="abbreviation" type="text" class="form-control input-trn @error('abbreviation') is-invalid @enderror" name="abbreviation" value="{{ old('abbreviation') }}" required>
  
                    @error('abbreviation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
              <div class="form-group row m-2">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
  
                <div class="col-md-8 m-0 p-0">
                    <input id="name" type="text" class="form-control input-trn @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
  
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
              </div>
              <input type="submit" class="btn-main exe" value="SAVE">
              </form>
          </div>
      </div>
      </div>
      
    </div>
    @endif
  </div>
@endsection
