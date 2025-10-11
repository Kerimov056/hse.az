@extends('layouts.admin')
@section('content')
  <h1 class="mb-4">Admin Dashboard</h1>
  <div class="card"><div class="card-body">
    Xoş gəldin, {{ $who->name }} (role: {{ $who->role }})
  </div></div>
@endsection