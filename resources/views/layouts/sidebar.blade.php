@extends('layouts.app')
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.1.0/dist/chart.min.js"></script>
@endsection
@section('styles')
  <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
@yield('stylesfluid')
@endsection
@section('content')
<div class="nav-content">
  <div class="sidebar-container">
    <div class="sidebar-logo" style="margin-top: 40px">
      Track Your Money
    </div>
    <ul class="sidebar-navigation">
      <li class="header">Records</li>
      <li>
        <a href="/home">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/DashboardIcon.png")}}" alt="">
            DASHBOARD
        </a>
      </li>
      <li>
        <a href="/transactions">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/TransactionsIcon.png")}}" alt="">
           TRANSACTIONS
        </a>
      </li>
      <li class="header">base Information</li>
      <li>
        <a href="/currencies">
          
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/CurrenciesIcon.png")}}" alt="">
           CURRENCIES
        </a>
      </li>
      <li>
        <a href="/accounts">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/AccountsIcon.png")}}" alt="">
           ACCOUNTS
        </a>
      </li>
      <li>
        <a href="/categories">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/CategoriesIcon.png")}}" alt="">
           CATEGORIES
        </a>
      </li>
    </ul>
  </div>
  @yield('fluid')
</div>
@endsection
@section('chart')
  @yield('chartfluid')
@endsection