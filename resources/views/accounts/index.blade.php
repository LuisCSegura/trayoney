@extends('layouts.sidebar')
@section('stylesfluid')
<link href="{{ asset('css/accounts.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
  
     <h1>ACCOUNTS</h1>
     <div class="content-section">
       <div class="content-section-header">
          <h2>Your Bank Accounts</h2>
          <button class="btn-main create" data-toggle="modal" data-target="#create">
            ✚ NEW
          </button>
       </div>
      <hr>
      @if($accounts->count() > 0)
        <table class="index-table">
          <tr>
            <th>
             ABBREVIATION
           </th>
           <th>
             NAME
           </th>
           <th>
             BALANCE
           </th>
           <th>
            CURRENCY
          </th>
          <th>
            TYPE
          </th>
           <th>
             ACTIONS
           </th>
          </tr>
          @foreach ($accounts as $account)
          <tr class="spacer"><td></td></tr>
          <tr class="item-row">
            <td class="item-cell first">
             {{$account->abbreviation}}
            </td>
            <td class="item-cell">
                {{$account->name}}
            </td>
            <td class="item-cell">
                {{$account->balance}}
            </td>
            <td class="item-cell">
                {{$account->currency->abbreviation}}
            </td>
            <td class="item-cell">
                @if($account->is_debit)
                    Debit
                @else
                    Credit
                @endif
            </td>
            <td class="item-cell last">
             <button data-toggle="modal" data-target="#upd{{$account->id}}" class="btn-main update">✎</button>
             {{-- UPDATE FORM --}}
          <div class="modal fade" id="upd{{$account->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">UPDATE {{$account->abbreviation}}</h1>
                      <form method="POST" action="/accounts/{{$account->id}}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row m-2">
                            <label for="currency_id" class="col-md-4 col-form-label text-md-right">Currency</label>
                            <div class="col-md-8 m-0 p-0">
                                <select name="currency_id" id="currency_id" class="custom-select">
                                    @foreach(Auth::user()->currencies as $currency)
                                    <option value="{{$currency->id}}" 
                                        @if($account->currency->id == $currency->id)
                                        selected
                                        @endif>
                                        {{$currency->abbreviation}}({{$currency->simbol}})</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
    
                          <div class="form-group row m-2">
                            <label for="is_debit" class="col-md-4 col-form-label text-md-right">Type</label>
                            <div class="col-md-8 m-0 p-0">
                                <select name="is_debit" id="is_debit" class="custom-select">
                                    <option value="true"
                                    @if($account->is_debit)
                                        selected
                                    @endif>
                                    Debit</option>
                                    <option value="false"
                                    @if(!($account->is_debit))
                                        selected
                                    @endif>
                                        Credit</option>
                                </select>
                            </div>
                          </div>
    
                          <div class="form-group row m-1">
                            <label for="abbreviation" class="col-md-4 col-form-label text-md-right">Abbreviation</label>
                            <div class="col-md-8 m-0 p-0">
                                <input id="abbreviation" type="text" class="form-control input-trn @error('abbreviation') is-invalid @enderror" name="abbreviation" value="{{ $account->abbreviation }}" required>
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
                                <input id="name" type="text" class="form-control input-trn @error('name') is-invalid @enderror" name="name" value="{{ $account->name }}" required>
    
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                          <div class="form-group row m-2">
                            <label for="balance" class="col-md-4 col-form-label text-md-right">Balance</label>
    
                            <div class="col-md-8 m-0 p-0">
                                <input id="balance" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn @error('balance') is-invalid @enderror" name="balance" value="{{ $account->balance }}" required>
    
                                @error('balance')
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
             <button data-toggle="modal" data-target="#del{{$account->id}}" class="btn-main delete">▬</button>
             {{-- DELETE FORM --}}
          <div class="modal fade" id="del{{$account->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">DELETE {{$account->abbreviation}}?</h1>
                      <p style="margin: 20px">Deleting the account "{{$account->name}}" removes all transactions related to it</p>
                      <form method="POST" action="/accounts/{{$account->id}}">
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
          @endforeach
        </table>
        @else
          <h3>Your accounts will appear here</h3>
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
                    <h1 class="form-title">NEW ACCOUNT</h1>
                    <form method="POST" action="/accounts">
                      @csrf

                      <div class="form-group row m-2">
                        <label for="currency_id" class="col-md-4 col-form-label text-md-right">Currency</label>
                        <div class="col-md-8 m-0 p-0">
                            <select name="currency_id" id="currency_id" class="custom-select">
                                @foreach(Auth::user()->currencies as $currency)
                                <option value="{{$currency->id}}">{{$currency->abbreviation}}({{$currency->simbol}})</option>
                                @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="form-group row m-2">
                        <label for="is_debit" class="col-md-4 col-form-label text-md-right">Type</label>
                        <div class="col-md-8 m-0 p-0">
                            <select name="is_debit" id="is_debit" class="custom-select">
                                <option value="true">Debit</option>
                                <option value="false">Credit</option>
                            </select>
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
                        <label for="balance" class="col-md-4 col-form-label text-md-right">Balance</label>

                        <div class="col-md-8 m-0 p-0">
                            <input id="balance" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn @error('balance') is-invalid @enderror" name="balance" value="{{ old('balance') }}" required>

                            @error('balance')
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