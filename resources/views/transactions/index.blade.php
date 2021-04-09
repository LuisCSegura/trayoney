@extends('layouts.sidebar')
@section('stylesfluid')
<link href="{{ asset('css/transactions.css') }}" rel="stylesheet">
@endsection
@section('fluid')
  <div class="content-container">
  
    <div class="container-fluid">
  
     <h1>TRANSACTIONS</h1>
        <div class="content-section">
            <div class="content-section-header">
                <h2>Your Transactions</h2>
                <button class="btn-main create" data-toggle="modal" data-target="#create-income">✚ NEW INCOME</button>
                <button class="btn-main create" data-toggle="modal" data-target="#create-expense">✚ NEW EXPENSE</button>
                <button class="btn-main create" data-toggle="modal" data-target="#create-transfer">✚ NEW TRANSFER</button>
            </div>
            <hr>
        </div>
    </div>
  </div>
@endsection