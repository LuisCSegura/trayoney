@extends('layouts.sidebar')

@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
  
     <h1>Welcome {{Auth::user()->name}}!!!</h1>
  
    </div>
  </div>
@endsection
