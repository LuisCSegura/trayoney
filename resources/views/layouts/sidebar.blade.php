@extends('layouts.app')

@section('content')
<div class="sidebar-container">
    <div class="sidebar-logo">
      NAVIGATION
    </div>
    <ul class="sidebar-navigation">
      <li class="header">Records</li>
      <li>
        <a href="#">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/DashboardIcon.png")}}" alt="">
            DASHBOARD
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/TransactionsIcon.png")}}" alt="">
           TRANSACTIONS
        </a>
      </li>
      <li class="header">base Information</li>
      <li>
        <a href="#">
          
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/CurrenciesIcon.png")}}" alt="">
           CURRENCIES
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/AccountsIcon.png")}}" alt="">
           ACCOUNTS
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fa" aria-hidden="true"></i>
          <img class="menu-icon" src="{{asset("images/CategoriesIcon.png")}}" alt="">
           CATEGORIES
        </a>
      </li>
    </ul>
  </div>
  
  @yield('fluid')
@endsection