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
              <button class="btn-main update">✎</button>
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
             <button class="btn-main update">✎</button>
             <button class="btn-main delete">▬</button>
            </td>
          </tr>
          @endif
          @endforeach
        </table>
        @else
          <h3>Your optional currencies will apear here</h3>
        @endif
       {{-- test --}}
        <div class="modal fade" id="create">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">
                          <span>×</span>
                      </button>
                      <h4>Crear</h4>
                  </div>
                  <div class="modal-body">
                      ….
                  </div>
                  <div class="modal-footer">
                      <input type="submit" class="btn btn-primary" value="Guardar">
                  </div>
              </div>
          </div>
      </div>
      {{-- test --}}
    </div>
    
     
  
    </div>
  </div>
@endsection