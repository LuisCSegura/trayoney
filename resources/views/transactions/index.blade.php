@extends('layouts.sidebar')
@section('stylesfluid')
<link href="{{ asset('css/transactions.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
    @if($error!=null)
    <div class="error-container">
        <p class="error-message">✖ ERROR: {{$error}}</p>
    </div>
    @endif  
    
    <div class="container-fluid">
     <h1>TRANSACTIONS</h1>
        <div class="content-section">
            <div class="content-section-header">
                <h2>{{$title}}</h2>
                @if($create)
                <button class="btn-main create" data-toggle="modal" data-target="#create-income">✚ NEW INCOME</button>
                {{-- CREATE INCOM FORM--}}
                <div class="modal fade" id="create-income">
                    <div class="modal-dialog">
                        <div class="modal-content card">
                            <div class="modal-header" style="border:none;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                                </button>
                            </div>
                            <div class="modal-body">
                            <h1 class="form-title">NEW INCOME TRANSACTION</h1>
                            <form method="POST" action="/transactions">
                                @csrf
                                <input id="type" type="hidden" name="type" value="INCOME">
                                <input id="destination_account_id" type="hidden" name="destination_account_id" value="">
                                
                                <div class="form-group row m-2">
                                    <label for="account_id" class="col-md-4 col-form-label text-md-right">Dest. Account</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="account_id" id="account_id" class="custom-select" required>
                                            @foreach(Auth::user()->accounts as $account)
                                                    <option value="{{$account->id}}">
                                                        {{$account->name}} ({{$account->balance}})
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row m-2">
                                    <label for="category_id" class="col-md-4 col-form-label text-md-right">Category</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="category_id" id="category_id" class="custom-select" required>
                                            @foreach(Auth::user()->categories as $category)
                                            @if($category->category==null)
                                                @if($category->is_income)
                                                    <option value="{{$category->id}}">
                                                        {{$category->name}}
                                                    </option>
                                                    @foreach ($category->categories as $son)
                                                        <option value="{{$son->id}}">
                                                            @if($son->id==$category->categories->last()->id)
                                                            └─
                                                            @else
                                                            ├─
                                                            @endif
                                                            {{$son->name}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="detail" class="col-md-4 col-form-label text-md-right">Detail</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="detail" type="text" class="form-control input-trn" name="detail" value="{{old('detail')}}" required>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount @if(Auth::user()->base_currency) ({{Auth::user()->base_currency->simbol}}) @endif</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{old('amount')}}" required>
                                    </div>
                                </div>

                                <input type="submit" class="btn-main exe" value="SAVE">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- CREATE INCOM FORM --}}
                <button class="btn-main create" data-toggle="modal" data-target="#create-expense">✚ NEW EXPENSE</button>
                {{-- CREATE EXPENSE FORM--}}
                <div class="modal fade" id="create-expense">
                    <div class="modal-dialog">
                        <div class="modal-content card">
                            <div class="modal-header" style="border:none;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                                </button>
                            </div>
                            <div class="modal-body">
                            <h1 class="form-title">NEW EXPENSE TRANSACTION</h1>
                            <form method="POST" action="/transactions">
                                @csrf
                                <input id="type" type="hidden" name="type" value="EXPENSE">
                                <input id="destination_account_id" type="hidden" name="destination_account_id" value="">
                                
                                <div class="form-group row m-2">
                                    <label for="account_id" class="col-md-4 col-form-label text-md-right">Origin Account</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="account_id" id="account_id" class="custom-select" required>
                                            @foreach(Auth::user()->accounts as $account)
                                                    <option value="{{$account->id}}">
                                                        {{$account->name}} ({{$account->balance}})
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row m-2">
                                    <label for="category_id" class="col-md-4 col-form-label text-md-right">Category</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="category_id" id="category_id" class="custom-select" required>
                                            @foreach(Auth::user()->categories as $category)
                                            @if($category->category==null)
                                                @if(!($category->is_income))
                                                    <option value="{{$category->id}}">
                                                        {{$category->name}}
                                                    </option>
                                                    @foreach ($category->categories as $son)
                                                        <option value="{{$son->id}}">
                                                            @if($son->id==$category->categories->last()->id)
                                                            └─
                                                            @else
                                                            ├─
                                                            @endif
                                                            {{$son->name}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="detail" class="col-md-4 col-form-label text-md-right">Detail</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="detail" type="text" class="form-control input-trn" name="detail" value="{{old('detail')}}" required>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount @if(Auth::user()->base_currency) ({{Auth::user()->base_currency->simbol}}) @endif</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{old('amount')}}" required>
                                    </div>
                                </div>

                                <input type="submit" class="btn-main exe" value="SAVE">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- CREATE EXPENSE FORM --}}
                <button class="btn-main create" data-toggle="modal" data-target="#create-transfer">✚ NEW TRANSFER</button>
                {{-- CREATE TRANSFER FORM--}}
                <div class="modal fade" id="create-transfer">
                    <div class="modal-dialog">
                        <div class="modal-content card">
                            <div class="modal-header" style="border:none;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                                </button>
                            </div>
                            <div class="modal-body">
                            <h1 class="form-title">NEW TRANSFER TRANSACTION</h1>
                            <form method="POST" action="/transactions">
                                @csrf
                                <input id="type" type="hidden" name="type" value="TRANSFER">
                                <input id="category_id" type="hidden" name="category_id" value="">
                                
                                <div class="form-group row m-2">
                                    <label for="account_id" class="col-md-4 col-form-label text-md-right">Origin Account</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="account_id" id="account_id" class="custom-select" required>
                                            @foreach(Auth::user()->accounts as $account)
                                                    <option value="{{$account->id}}">
                                                        {{$account->name}} ({{$account->balance}})
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="destination_account_id" class="col-md-4 col-form-label text-md-right">Dest. Account</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="destination_account_id" id="destination_account_id" class="custom-select" required>
                                            @foreach(Auth::user()->accounts as $account)
                                                    <option value="{{$account->id}}">
                                                        {{$account->name}} ({{$account->balance}})
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row m-2">
                                    <label for="detail" class="col-md-4 col-form-label text-md-right">Detail</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="detail" type="text" class="form-control input-trn" name="detail" value="{{old('detail')}}" required>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount @if(Auth::user()->base_currency) ({{Auth::user()->base_currency->simbol}}) @endif</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{old('amount')}}" required>
                                    </div>
                                </div>

                                <input type="submit" class="btn-main exe" value="SAVE">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- CREATE TRANSFER FORM --}}
                @endif
            </div>
            <hr>
        @if($transactions->count()>0)
        <table class="index-table">
            <tr>
                <th>
                  TYPE
                </th>
                <th>
                  DATE
                </th>
                <th>
                  DETAIL
                </th>
                <th>
                  CATEGORY
                </th>
                <th>
                  AMOUNT ({{Auth::user()->base_currency->simbol}})
                </th>
                <th>
                  ORIGIN
                </th>
                <th>
                  DESTINATION
                </th>
                <th>
                  ACTIONS
                </th>
            </tr>
            @foreach ($transactions as $transaction)
            <tr class="spacer"><td></td></tr>
            <tr class="item-row">
              <td class="item-cell first">
               {{$transaction->type}}
              </td>
              <td class="item-cell">
                {{$transaction->updated_at}}
              </td>
              <td class="item-cell">
                {{$transaction->detail}}
              </td>
              <td class="item-cell">
                @if($transaction->type=="TRANSFER")
                    Transfer
                @else
                    {{$transaction->category->name}}
                @endif
              </td>
              <td class="item-cell">
                {{$transaction->amount}}
              </td>
              <td class="item-cell">
                  @if($transaction->type=="INCOME")
                    Unknown
                  @else
                    {{$transaction->account->abbreviation}}
                  @endif
              </td>
              <td class="item-cell">
                @if($transaction->type=="INCOME")
                    {{$transaction->account->abbreviation}}
                @elseif($transaction->type=="EXPENSE")
                    Unknown
                @elseif($transaction->type=="TRANSFER")
                    {{$transaction->destination_account->abbreviation}}
                @endif
              </td>
              <td class="item-cell last">
                <button data-toggle="modal" data-target="#upd{{$transaction->id}}" class="btn-main update">✎</button>
                {{-- UPDATE FORM--}}
                <div class="modal fade" id="upd{{$transaction->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content card">
                            <div class="modal-header" style="border:none;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                                </button>
                            </div>
                            <div class="modal-body">
                            <h1 class="form-title">UPDATE {{$transaction->type}}</h1>
                            <form method="POST" action="/transactions/{{$transaction->id}}">
                                @csrf
                                @method('PUT')
                                <input id="type" type="hidden" name="type" value="{{$transaction->type}}">
                                <input id="account_id" type="hidden" name="account_id" value="{{$transaction->account->id}}">
                                <input id="destination_account_id" type="hidden" name="destination_account_id" value="{{$transaction->destination_account_id}}">
                                @if($transaction->type!="TRANSFER")
                                <div class="form-group row m-2">
                                    <label for="category_id" class="col-md-4 col-form-label text-md-right">Category</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <select name="category_id" id="category_id" class="custom-select">
                                            @foreach(Auth::user()->categories as $category)
                                            @if($category->category==null)
                                            @if($category->is_income && $transaction->type=="INCOME")
                                                <option value="{{$category->id}}" 
                                                    @if($transaction->category->id == $category->id)
                                                    selected
                                                    @endif>
                                                    {{$category->name}}
                                                </option>
                                            @foreach ($category->categories as $son)
                                                <option value="{{$son->id}}" 
                                                    @if($transaction->category->id == $son->id)
                                                    selected
                                                    @endif>
                                                    @if($son->id==$category->categories->last()->id)
                                                    └─
                                                    @else
                                                    ├─
                                                    @endif
                                                    {{$son->name}}
                                                </option>
                                            @endforeach
                                            @elseif(!($category->is_income) && $transaction->type=="EXPENSE")
                                                <option value="{{$category->id}}" 
                                                    @if($transaction->category->id == $category->id)
                                                    selected
                                                    @endif>
                                                    {{$category->name}}
                                                </option>
                                            @foreach ($category->categories as $son)
                                                <option value="{{$son->id}}" 
                                                    @if($transaction->category->id == $son->id)
                                                    selected
                                                    @endif>
                                                    @if($son->id==$category->categories->last()->id)
                                                    └─
                                                    @else
                                                    ├─
                                                    @endif
                                                    {{$son->name}}
                                                </option>
                                            @endforeach
                                            @endif
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                

                                <div class="form-group row m-2">
                                    <label for="detail" class="col-md-4 col-form-label text-md-right">Detail</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="detail" type="text" class="form-control input-trn" name="detail" value="{{$transaction->detail}}" required>
                                    </div>
                                </div>

                                <div class="form-group row m-2">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount ({{Auth::user()->base_currency->simbol}})</label>
                                    <div class="col-md-8 m-0 p-0">
                                        <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{$transaction->amount}}" required>
                                    </div>
                                </div>

                                <input type="submit" class="btn-main exe" value="SAVE">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- UPDATE FORM --}}
                <button data-toggle="modal" data-target="#del{{$transaction->id}}" class="btn-main delete">↺</button>
                {{-- DELETE FORM --}}
                <div class="modal fade" id="del{{$transaction->id}}">
                    <div class="modal-dialog">
                        <div class="modal-content card">
                            <div class="modal-header" style="border:none;">
                                <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                                </button>
                            </div>
                            <div class="modal-body">
                            <h1 class="form-title">UNDO THIS {{$transaction->type}}?</h1>
                            <p style="margin: 20px">Undoing this transaction will reestablish the values of the account(s) involved</p>
                            <form method="POST" action="/transactions/{{$transaction->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-main exe">UNDO</button>
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
            <h3>Your transactions will appear here</h3>
        @endif
        </div>
    </div>
  </div>
@endsection