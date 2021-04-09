@extends('layouts.sidebar')
@section('stylesfluid')
<link href="{{ asset('css/currencies.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
  
     <h1>CURRENCIES</h1>
     <div class="content-section">
      <div class="content-section-header">
        <h2>Base Currency</h2>
     </div>
    <hr>
        @if(Auth::user()->base_currency != null)
         <table class="index-table">
           <tr>
             <th>
               SIMBOL
             </th>
             <th>
              ABBREVIATION
            </th>
            <th>
              NAME
            </th>
            <th>
              RATE
            </th>
            <th>
              ACTIONS
            </th>
           </tr>
           <tr class="spacer"><td></td></tr>
           <tr class="item-row">
             <td class="item-cell first">
              {{Auth::user()->base_currency->simbol}}
             </td>
             <td class="item-cell">
              {{Auth::user()->base_currency->abbreviation}}
             </td>
             <td class="item-cell">
              {{Auth::user()->base_currency->name}}
             </td>
             <td class="item-cell">
              {{Auth::user()->base_currency->rate}}
             </td>
             <td class="item-cell last">
              <button data-toggle="modal" data-target="#bupd{{Auth::user()->base_currency->id}}" class="btn-main update">✎</button>
              {{-- BASE UPDATE FORM --}}
              <div class="modal fade" id="bupd{{Auth::user()->base_currency->id}}">
                <div class="modal-dialog">
                    <div class="modal-content card">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                            </button>
                        </div>
                        <div class="modal-body">
                          <h1 class="form-title">UPDATE {{Auth::user()->base_currency->abbreviation}}</h1>
                          <form method="POST" action="/currencies/{{Auth::user()->base_currency->id}}">
                            @csrf
                            @method('PUT')
                            <input id="base_currency_user_id" type="hidden" name="base_currency_user_id" value="{{Auth::user()->id}}">
                            <input id="rate" type="hidden" name="rate" value="1">
                            <div class="form-group row m-2">
                              <label for="simbol" class="col-md-4 col-form-label text-md-right">Simbol</label>
      
                              <div class="col-md-8 m-0 p-0">
                                  <input id="simbol" type="text" maxlength="1" class="form-control input-trn @error('simbol') is-invalid @enderror" name="simbol" value="{{Auth::user()->base_currency->simbol}}" required>
      
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
                                  <input id="abbreviation" type="text" class="form-control input-trn @error('abbreviation') is-invalid @enderror" name="abbreviation" value="{{Auth::user()->base_currency->abbreviation}}" required>
      
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
                                  <input id="name" type="text" class="form-control input-trn @error('name') is-invalid @enderror" name="name" value="{{Auth::user()->base_currency->name}}" required>
      
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
              {{-- BASE UPDATE FORM --}}
            </td>
           </tr>
         </table>
         @else
         <h3>You must define a base currency</h3>
         @endif
     </div>
     <div class="content-section">
       <div class="content-section-header">
          <h2>Other Currencies</h2>
          <button class="btn-main create" data-toggle="modal" data-target="#create">
            ✚ NEW
          </button>
       </div>
      <hr>
      @if($currencies->count() > 1)
        <table class="index-table">
          <tr>
            <th>
              SIMBOL
            </th>
            <th>
             ABBREVIATION
           </th>
           <th>
             NAME
           </th>
           <th>
             RATE
           </th>
           <th>
             ACTIONS
           </th>
          </tr>
          @foreach ($currencies as $currency)
          @if($currency->id!=Auth::user()->base_currency->id)
          <tr class="spacer"><td></td></tr>
          <tr class="item-row">
            <td class="item-cell first">
             {{$currency->simbol}}
            </td>
            <td class="item-cell">
             {{$currency->abbreviation}}
            </td>
            <td class="item-cell">
             {{$currency->name}}
            </td>
            <td class="item-cell">
             {{$currency->rate}}
            </td>
            <td class="item-cell last">
             <button data-toggle="modal" data-target="#upd{{$currency->id}}" class="btn-main update">✎</button>
             {{-- UPDATE FORM --}}
          <div class="modal fade" id="upd{{$currency->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">UPDATE {{$currency->abbreviation}}</h1>
                      <form method="POST" action="/currencies/{{$currency->id}}">
                        @csrf
                        @method('PUT')
                        <input id="base_currency_user_id" type="hidden" name="base_currency_user_id" value="">
                        <div class="form-group row m-2">
                          <label for="simbol" class="col-md-4 col-form-label text-md-right">Simbol</label>
  
                          <div class="col-md-8 m-0 p-0">
                              <input id="simbol" type="text" maxlength="1" class="form-control input-trn @error('simbol') is-invalid @enderror" name="simbol" value="{{$currency->simbol}}" required>
  
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
                              <input id="abbreviation" type="text" class="form-control input-trn @error('abbreviation') is-invalid @enderror" name="abbreviation" value="{{$currency->abbreviation}}" required>
  
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
                              <input id="name" type="text" class="form-control input-trn @error('name') is-invalid @enderror" name="name" value="{{$currency->name}}" required>
  
                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                        </div>
                        <div class="form-group row m-2">
                          <label for="rate" class="col-md-4 col-form-label text-md-right">Rate</label>
  
                          <div class="col-md-8 m-0 p-0">
                              <input id="rate" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn @error('rate') is-invalid @enderror" name="rate" value="{{$currency->rate}}" required>
  
                              @error('rate')
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
          {{-- UPDATE FORM --}}
             <button data-toggle="modal" data-target="#del{{$currency->id}}" class="btn-main delete">▬</button>
             {{-- DELETE FORM --}}
          <div class="modal fade" id="del{{$currency->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">DELETE {{$currency->abbreviation}}?</h1>
                      <p style="margin: 20px">Deleting the currency "{{$currency->name}}" removes all accounts and transactions related to it</p>
                      <form method="POST" action="/currencies/{{$currency->id}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-main exe">DELETE</button>
                       </form>
                    </div>
                </div>
            </div>
        </div>
          {{-- DELETE FORM --}}
            </td>
          </tr>
          
          @endif
          @endforeach
        </table>
        @else
          <h3>Your optional currencies will appear here</h3>
        @endif

       {{-- create --}}
        <div class="modal fade" id="create">
          <div class="modal-dialog">
              <div class="modal-content card">
                  <div class="modal-header" style="border:none;">
                      <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                      </button>
                  </div>
                  <div class="modal-body">
                    <h1 class="form-title">NEW CURRENCY</h1>
                    <form method="POST" action="/currencies">
                      @csrf
                      <input id="base_currency_user_id" type="hidden" name="base_currency_user_id" value="">
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
                      <div class="form-group row m-2">
                        <label for="rate" class="col-md-4 col-form-label text-md-right">Rate</label>

                        <div class="col-md-8 m-0 p-0">
                            <input id="rate" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" required>

                            @error('rate')
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
      {{-- create --}}
    </div>
    
     
  
    </div>
  </div>
@endsection