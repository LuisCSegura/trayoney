@extends('layouts.sidebar')

@section('stylesfluid')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
      <div class="content-section" style="height: 100px;">

      </div>
      <div class="stats-content">
        <div class="chart-container content-section">
          <canvas id="myChart" width="400" height="400"></canvas>
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
              '{{$stat[2]}}',
            @endforeach
            
          ],
          borderWidth: 0,
          hoverOffset: 10,
          weight: 1000,
        }]
      },
      options:{
        radius: '100%',
      }
  });
  </script>
@endsection
