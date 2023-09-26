@vite('resources/js/forum.js')
@extends('layouts.main')
@section('page-title')
  Форум
@endsection
@section('page-container')
  <style>
  ul a:hover{
    color:rgba(150,20,20,1);
  }
  </style>
  <div id="cat_container" class="text-white flex flex-row pt-5 w-5/6 ml-[7%] items-stretch">

  <div class="flex flex-col w-1/3">
  @include('categories.other')
  @include('categories.tech')
  </div>

  <div class="flex flex-col w-1/3">
  @include('categories.games')
  @include('categories.creativity')
  </div>

  <div class="flex flex-col w-1/3">
  @include('categories.subject')
  </div>

  </div>
@endsection
