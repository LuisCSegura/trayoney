@extends('layouts.sidebar')
@section('scriptsfluid')
@endsection
@section('stylesfluid')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
      <div class="content-section" style="display:flex; justify-content:center; padding: 5px">
        <button data-toggle="modal" data-target="#opt0" class="btn-main" style="margin: 10px;">BETWEEN TWO DATES</button>
        {{-- 0 --}}
        <div class="modal fade" id="opt0">
          <div class="modal-dialog">
              <div class="modal-content card center">
                  <div class="modal-header" style="border:none;">
                      <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                      </button>
                  </div>
                  <div class="modal-body">
                  <h1 class="form-title">CONSULT BETWEEN DATES</h1>
                  <form method="GET" action="/charStats/0">
                    @csrf
                    <div class="form-group row m-2">
                      <label for="date1" class="col-md-4 col-form-label text-md-right">Since</label>
                      <div class="col-md-8 m-0 p-0">
                          <input id="date1" type="date" class="form-control input-trn" name="date1" value="{{old('date1')}}" required>
                      </div>
                    </div>
                    <div class="form-group row m-2">
                      <label for="date2" class="col-md-4 col-form-label text-md-right">Until</label>
                      <div class="col-md-8 m-0 p-0">
                          <input id="date2" type="date" class="form-control input-trn" name="date2" value="{{old('date2')}}" required>
                      </div>
                    </div>
                    <button type="submit" class="btn-main exe">CONSULT</button>
                  </form>
                  </div>
              </div>
          </div>
      </div>
      {{-- 0 --}}
        <form method="GET" action="/charStats/1" style="margin: 10px;">
          @csrf
          <button type="submit" class="btn-main">LAST MONTH</button>
        </form>
        <form method="GET" action="/charStats/2" style="margin: 10px;">
          @csrf
          <button type="submit" class="btn-main">LAST YEAR</button>
        </form>
        <button data-toggle="modal" data-target="#opt3" class="btn-main" style="margin: 10px;">CALENDAR MONTH</button>
        {{-- 3 --}}
        <div class="modal fade" id="opt3">
          <div class="modal-dialog">
              <div class="modal-content card center">
                  <div class="modal-header" style="border:none;">
                      <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                      </button>
                  </div>
                  <div class="modal-body">
                  <h1 class="form-title">CONSULT BY MONTH</h1>
                  <form method="GET" action="/charStats/3">
                    @csrf
                    <div class="form-group row m-2">
                      <label for="month" class="col-md-4 col-form-label text-md-right">Month</label>
                      <div class="col-md-8 m-0 p-0">
                          <input id="month" type="month" class="form-control input-trn" name="month" value="{{old('month')}}" required>
                      </div>
                    </div>
                    <button type="submit" class="btn-main exe">CONSULT</button>
                  </form>
                  </div>
              </div>
          </div>
      </div>
      {{-- 3 --}}
      <button data-toggle="modal" data-target="#opt4" class="btn-main" style="margin: 10px;">CALENDAR YEAR</button>
        {{-- 4 --}}
        <div class="modal fade" id="opt4">
          <div class="modal-dialog">
              <div class="modal-content card center">
                  <div class="modal-header" style="border:none;">
                      <button type="button" class="close" data-dismiss="modal" style="color: white;">✖
                      </button>
                  </div>
                  <div class="modal-body">
                  <h1 class="form-title">CONSULT BY YEAR</h1>
                  <form method="GET" action="/charStats/4">
                    @csrf
                    <div class="form-group row m-2">
                      <label for="year" class="col-md-4 col-form-label text-md-right">Year</label>
                      <div class="col-md-8 m-0 p-0">
                          <input id="year" name="year" class="form-control input-trn" type="number" min="1900" max="2099" step="1" value="2021" required />
                      </div>
                    </div>
                    <button type="submit" class="btn-main exe">CONSULT</button>
                  </form>
                  </div>
              </div>
          </div>
      </div>
      {{-- 4 --}}
      </div>
      <h1>{{$title}}</h1>
      <div class="stats-content">
        <div class="chart-container content-section" style="width: 32%;">
          @foreach($stats as $stat)
            @if($stat[4])
            <div class="header-info" style="background-color:#1E90FF;">
                {{$stat[0]}}: @if(Auth::user()->base_currency) {{Auth::user()->base_currency->simbol}}@endif{{$stat[1]}}
                @if(count($stat[6])>0)
                <form method="GET" action="/showstats/{{$stat[3]}}" style="display: inline;">
                  @csrf
                    <input id="transactions" name="transactions" type="hidden" value="{{$stat[6]}}"/>
                    <button type="submit" class="btn-main small blue">TRANSACTIONS</button>
                </form>
                @endif
              </div>
              @if(count($stat[5])>0)
              <div style="height: 200px; display:flex; justify-content:center;">
                <div style="width: 200px;">
                  <canvas id="chart{{$stat[3]}}" width="400" height="400"></canvas>
                </div>
              </div>
              
              @else
                <p style="text-align: center;">This category do not have sub-categories</p>
              @endif
            @endif
          @endforeach
        </div>
        <div class="chart-container content-section">
          <div class="content-section-header" style="display: flex; justify-content:center;">
            <p class="header-info" style="background-color:#1E90FF;">
              INCOMES: @if(Auth::user()->base_currency) {{Auth::user()->base_currency->simbol}}@endif{{$ie[0]}}
            </p>
            <p class="header-info" style="background-color:#DC143C">
              EXPENSES: @if(Auth::user()->base_currency) {{Auth::user()->base_currency->simbol}}@endif{{$ie[1]}}
            </p>
          </div>
          <canvas id="myChart" width="400" height="400"></canvas>
        </div>
        <div class="chart-container content-section" style="width: 32%;">
          @foreach($stats as $stat)
            @if(!$stat[4])
            <div class="header-info" style="background-color:#dc143c;">
              {{$stat[0]}}: @if(Auth::user()->base_currency) {{Auth::user()->base_currency->simbol}}@endif{{$stat[1]}}
              @if(count($stat[6])>0)
              <form method="GET" action="/showstats/{{$stat[3]}}" style="display: inline;">
                @csrf
                  <input id="transactions" name="transactions" type="hidden" value="{{$stat[6]}}"/>
                  <button type="submit" class="btn-main small red">TRANSACTIONS</button>
              </form>
              @endif
            </div>
              @if(count($stat[5])>0)
              <div style="height: 200px; display:flex; justify-content:center;">
                <div style="width: 200px;">
                  <canvas id="chart{{$stat[3]}}" width="400" height="400"></canvas>
                </div>
              </div>
              
              @else
                <p style="text-align: center;">This category do not have sub-categories</p>
              @endif

            @endif
          @endforeach
        </div>
      </div>
      
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
                    <input id="simbol" type="text" maxlength="1" class="form-control input-trn" name="simbol" value="{{ old('simbol') }}" required>
  
                </div>
              </div>
              <div class="form-group row m-1">
                <label for="abbreviation" class="col-md-4 col-form-label text-md-right">Abbreviation</label>
  
                <div class="col-md-8 m-0 p-0">
                    <input id="abbreviation" type="text" class="form-control input-trn" name="abbreviation" value="{{ old('abbreviation') }}" required>

                </div>
              </div>
              <div class="form-group row m-2">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
  
                <div class="col-md-8 m-0 p-0">
                    <input id="name" type="text" class="form-control input-trn" name="name" value="{{ old('name') }}" required>

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
@section('chartfluid')
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [ 
          @foreach($stats as $stat)
              '{{$stat[0]}}',
          @endforeach
        ],
        datasets: [{
          label: 'My First Dataset',
          data: [
            @foreach($stats as $stat)
              {{$stat[1]}},
            @endforeach
          ],
          backgroundColor: [
            @foreach($stats as $stat)
              'rgb({{$stat[2][0]}},{{$stat[2][1]}},{{$stat[2][2]}})',
            @endforeach
            
          ],
          borderWidth: 2,
          borderColor: '#2F3642',
          hoverOffset: 10,
          weight: 1000,
        }]
      },
      options:{
        radius: '90%',
      }
  });
  @foreach($stats as $stat)
  @if(count($stat[5])>0)
  var ctxSon{{$stat[3]}} = document.getElementById('chart{{$stat[3]}}').getContext('2d');
  var chartSon{{$stat[3]}} = new Chart(ctxSon{{$stat[3]}}, {
      type: 'pie',
      data: {
        labels: [ 
          @foreach($stat[5] as $son)
              '{{$son[0]}}',
          @endforeach
        ],
        datasets: [{
          label: 'My First Dataset',
          data: [
            @foreach($stat[5] as $son)
              {{$son[1]}},
            @endforeach
          ],
          backgroundColor: [
            @foreach($stat[5] as $son)
              'rgb({{$son[2][0]}},{{$son[2][1]}},{{$son[2][2]}})',
            @endforeach
            
          ],
          borderWidth: 2,
          borderColor: '#2F3642',
          hoverOffset: 10,
        }]
      },
      options:{
        radius: '90%',
      }
  });
  @endif
  @endforeach
  </script>
@endsection
