@extends('layouts.sidebar')
@section('stylesfluid')
<link href="{{ asset('css/categories.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
  
     <h1>CATEGORIES</h1>
     <div class="divide-content">
    {{-- INCOMES --}}
        <div class="content-section">
            <div class="content-section-header">
               <h2>Incomes</h2>
               <button class="btn-main create" data-toggle="modal" data-target="#create-income-parent">
                 ✚ NEW
               </button>
               {{-- create --}}
        <div class="modal fade" id="create-income-parent">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">NEW INCOME CATEGORY</h1>
                      <form method="POST" action="/categories">
                        @csrf
                        <input id="is_income" type="hidden" name="is_income" value="true">
                        <input id="category_id" type="hidden" name="category_id" value="">
                        <div class="form-group row m-2">
                          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="name" type="text" class="form-control input-trn" name="name" value="{{ old('name') }}" required>
                          </div>
                        </div>
                        <div class="form-group row m-2">
                          <label for="amount" class="col-md-4 col-form-label text-md-right">Expect ({{Auth::user()->base_currency->simbol}})</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{ old('amount') }}" required>
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
           <hr>
           @if($incomes->count() > 0)
           <table class="index-table">
             <tr>
              <th>
                NAME
              </th>
              <th>
                MONTHLY EXPECT
              </th>
              <th>
                ACTIONS
              </th>
             </tr>
             @foreach ($incomes as $income)
             @if($income->category==null)
             <tr class="spacer"><td></td></tr>
             <tr class="item-row @if($income->categories->count()>0) parent @endif ">
               <td class="item-cell first">
                {{$income->name}}
               </td>
               <td class="item-cell">
                {{$income->amount}}
               </td>
               <td class="item-cell last">
                <button data-toggle="modal" data-target="#add{{$income->id}}" class="btn-main add">✚</button>
                {{-- ADD FORM--}}
        <div class="modal fade" id="add{{$income->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">NEW {{$income->name}} CATEGORY</h1>
                      <form method="POST" action="/categories">
                        @csrf
                        <input id="is_income" type="hidden" name="is_income" value="true">
                        <input id="category_id" type="hidden" name="category_id" value="{{$income->id}}">

                        <div class="form-group row m-2">
                          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="name" type="text" class="form-control input-trn" name="name" value="{{ old('name') }}" required>
                          </div>
                        </div>

                        <div class="form-group row m-2">
                          <label for="amount" class="col-md-4 col-form-label text-md-right">Expect ({{Auth::user()->base_currency->simbol}})</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{ old('amount') }}" required>
                          </div>
                        </div>
                        <input type="submit" class="btn-main exe" value="SAVE">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- ADD FORM --}}
                <button data-toggle="modal" data-target="#upd{{$income->id}}" class="btn-main update">✎</button>
                {{-- UPDATE FORM--}}
        <div class="modal fade" id="upd{{$income->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">UPDATE {{$income->name}}</h1>
                      <form method="POST" action="/categories/{{$income->id}}">
                        @csrf
                        @method('PUT')
                        <input id="is_income" type="hidden" name="is_income" value="true">
                        <input id="category_id" type="hidden" name="category_id" value="">

                        <div class="form-group row m-2">
                          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="name" type="text" class="form-control input-trn" name="name" value="{{$income->name}}" required>
                          </div>
                        </div>

                        <div class="form-group row m-2">
                          <label for="amount" class="col-md-4 col-form-label text-md-right">Expect ({{Auth::user()->base_currency->simbol}})</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{$income->amount}}" required>
                          </div>
                        </div>
                        <input type="submit" class="btn-main exe" value="SAVE">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- UPDATE FORM --}}
                <button data-toggle="modal" data-target="#del{{$income->id}}" class="btn-main delete">▬</button>
                {{-- DELETE FORM --}}
          <div class="modal fade" id="del{{$income->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">DELETE {{$income->name}}?</h1>
                      <p style="margin: 20px">Deleting the category "{{$income->name}}" removes all son categories related to it</p>
                      <form method="POST" action="/categories/{{$income->id}}">
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
             @foreach ($income->categories as $son)
                 <tr class="son-row @if($son->id == $income->categories->last()->id) last-row @endif">
                    <td class="item-cell first">
                        {{$son->name}}
                    </td>
                    <td class="item-cell">
                        {{$son->amount}}
                    </td>
                    <td class="item-cell last">
                        <button data-toggle="modal" data-target="#upd{{$son->id}}" class="btn-main update">✎</button>
                        {{--SON UPDATE FORM--}}
        <div class="modal fade" id="upd{{$son->id}}">
            <div class="modal-dialog">
                <div class="modal-content card">
                    <div class="modal-header" style="border:none;">
                        <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                        </button>
                    </div>
                    <div class="modal-body">
                      <h1 class="form-title">UPDATE {{$son->name}}</h1>
                      <form method="POST" action="/categories/{{$son->id}}">
                        @csrf
                        @method('PUT')
                        <input id="is_income" type="hidden" name="is_income" value="true">
                        <input id="category_id" type="hidden" name="category_id" value="{{$income->id}}">

                        <div class="form-group row m-2">
                          <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="name" type="text" class="form-control input-trn" name="name" value="{{$son->name}}" required>
                          </div>
                        </div>

                        <div class="form-group row m-2">
                          <label for="amount" class="col-md-4 col-form-label text-md-right">Expect ({{Auth::user()->base_currency->simbol}})</label>
                          <div class="col-md-8 m-0 p-0">
                              <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{$son->amount}}" required>
                          </div>
                        </div>
                        <input type="submit" class="btn-main exe" value="SAVE">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- SON UPDATE FORM --}}
                        <form method="POST" action="/categories/{{$son->id}}" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-main delete">▬</button>
                           </form>
                    </td>
                 </tr>
             @endforeach
             @endif
             @endforeach
           </table>
           @else
             <h3>Your income categories will appear here</h3>
           @endif
         </div>
         {{-- INCOMES --}}
         
         {{-- EXPENSES --}}
            <div class="content-section">
                <div class="content-section-header">
                   <h2>Expenses</h2>
                   <button class="btn-main create" data-toggle="modal" data-target="#create-expense-parent">
                     ✚ NEW
                   </button>
                   {{-- create --}}
            <div class="modal fade" id="create-expense-parent">
                <div class="modal-dialog">
                    <div class="modal-content card">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                            </button>
                        </div>
                        <div class="modal-body">
                          <h1 class="form-title">NEW EXPENSE CATEGORY</h1>
                          <form method="POST" action="/categories">
                            @csrf
                            <input id="is_income" type="hidden" name="is_income" value="false">
                            <input id="category_id" type="hidden" name="category_id" value="">
                            <div class="form-group row m-2">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="name" type="text" class="form-control input-trn" name="name" value="{{ old('name') }}" required>
                              </div>
                            </div>
                            <div class="form-group row m-2">
                              <label for="amount" class="col-md-4 col-form-label text-md-right">Budget ({{Auth::user()->base_currency->simbol}})</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{ old('amount') }}" required>
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
               <hr>
               @if($expenses->count() > 0)
               <table class="index-table">
                 <tr>
                  <th>
                    NAME
                  </th>
                  <th>
                    MONTHLY BUDGET
                  </th>
                  <th>
                    ACTIONS
                  </th>
                 </tr>
                 @foreach ($expenses as $expense)
                 @if($expense->category==null)
                 <tr class="spacer"><td></td></tr>
                 <tr class="item-row @if($expense->categories->count()>0) parent @endif ">
                   <td class="item-cell first">
                    {{$expense->name}}
                   </td>
                   <td class="item-cell">
                    {{$expense->amount}}
                   </td>
                   <td class="item-cell last">
                    <button data-toggle="modal" data-target="#add{{$expense->id}}" class="btn-main add">✚</button>
                    {{-- ADD FORM--}}
            <div class="modal fade" id="add{{$expense->id}}">
                <div class="modal-dialog">
                    <div class="modal-content card">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                            </button>
                        </div>
                        <div class="modal-body">
                          <h1 class="form-title">NEW {{$expense->name}} CATEGORY</h1>
                          <form method="POST" action="/categories">
                            @csrf
                            <input id="is_income" type="hidden" name="is_income" value="false">
                            <input id="category_id" type="hidden" name="category_id" value="{{$expense->id}}">
    
                            <div class="form-group row m-2">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="name" type="text" class="form-control input-trn" name="name" value="{{ old('name') }}" required>
                              </div>
                            </div>
    
                            <div class="form-group row m-2">
                              <label for="amount" class="col-md-4 col-form-label text-md-right">Budget ({{Auth::user()->base_currency->simbol}})</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{ old('amount') }}" required>
                              </div>
                            </div>
                            <input type="submit" class="btn-main exe" value="SAVE">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ADD FORM --}}
                    <button data-toggle="modal" data-target="#upd{{$expense->id}}" class="btn-main update">✎</button>
                    {{-- UPDATE FORM--}}
            <div class="modal fade" id="upd{{$expense->id}}">
                <div class="modal-dialog">
                    <div class="modal-content card">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                            </button>
                        </div>
                        <div class="modal-body">
                          <h1 class="form-title">UPDATE {{$expense->name}}</h1>
                          <form method="POST" action="/categories/{{$expense->id}}">
                            @csrf
                            @method('PUT')
                            <input id="is_income" type="hidden" name="is_income" value="false">
                            <input id="category_id" type="hidden" name="category_id" value="">
    
                            <div class="form-group row m-2">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="name" type="text" class="form-control input-trn" name="name" value="{{$expense->name}}" required>
                              </div>
                            </div>
    
                            <div class="form-group row m-2">
                              <label for="amount" class="col-md-4 col-form-label text-md-right">Budget ({{Auth::user()->base_currency->simbol}})</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{$income->amount}}" required>
                              </div>
                            </div>
                            <input type="submit" class="btn-main exe" value="SAVE">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- UPDATE FORM --}}
                    <button data-toggle="modal" data-target="#del{{$expense->id}}" class="btn-main delete">▬</button>
                    {{-- DELETE FORM --}}
              <div class="modal fade" id="del{{$expense->id}}">
                <div class="modal-dialog">
                    <div class="modal-content card">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                            </button>
                        </div>
                        <div class="modal-body">
                          <h1 class="form-title">DELETE {{$expense->name}}?</h1>
                          <p style="margin: 20px">Deleting the category "{{$expense->name}}" removes all son categories related to it</p>
                          <form method="POST" action="/categories/{{$expense->id}}">
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
                 @foreach ($expense->categories as $son)
                     <tr class="son-row @if($son->id == $expense->categories->last()->id) last-row @endif">
                        <td class="item-cell first">
                            {{$son->name}}
                        </td>
                        <td class="item-cell">
                            {{$son->amount}}
                        </td>
                        <td class="item-cell last">
                            <button data-toggle="modal" data-target="#upd{{$son->id}}" class="btn-main update">✎</button>
                            {{--SON UPDATE FORM--}}
            <div class="modal fade" id="upd{{$son->id}}">
                <div class="modal-dialog">
                    <div class="modal-content card">
                        <div class="modal-header" style="border:none;">
                            <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                            </button>
                        </div>
                        <div class="modal-body">
                          <h1 class="form-title">UPDATE {{$son->name}}</h1>
                          <form method="POST" action="/categories/{{$son->id}}">
                            @csrf
                            @method('PUT')
                            <input id="is_income" type="hidden" name="is_income" value="false">
                            <input id="category_id" type="hidden" name="category_id" value="{{$expense->id}}">
    
                            <div class="form-group row m-2">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="name" type="text" class="form-control input-trn" name="name" value="{{$son->name}}" required>
                              </div>
                            </div>
    
                            <div class="form-group row m-2">
                              <label for="amount" class="col-md-4 col-form-label text-md-right">Budget ({{Auth::user()->base_currency->simbol}})</label>
                              <div class="col-md-8 m-0 p-0">
                                  <input id="amount" type="number" placeholder="0.00" min="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$" class="form-control input-trn" name="amount" value="{{$son->amount}}" required>
                              </div>
                            </div>
                            <input type="submit" class="btn-main exe" value="SAVE">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- SON UPDATE FORM --}}
                            <form method="POST" action="/categories/{{$son->id}}" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-main delete">▬</button>
                               </form>
                        </td>
                     </tr>
                 @endforeach
                 @endif
                 @endforeach
               </table>
               @else
                 <h3>Your expense categories will appear here</h3>
               @endif
        {{-- EXPENSES --}}
     
     </div>
     
    </div>
  </div>
@endsection