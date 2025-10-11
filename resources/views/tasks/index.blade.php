@extends('layouts.app')
@section('title','Tapşırıqlar')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">Tapşırıqlar</h1>
  <a href="{{ route('tasks.create') }}" class="btn btn-primary">Yeni Tapşırıq</a>
</div>

@if($tasks->count())
  <div class="list-group mb-3">
    @foreach($tasks as $task)
      <a href="{{ route('tasks.show',$task) }}" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>
          <div class="fw-semibold">{{ $task->title }}</div>
          <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
        </div>
        <span class="badge {{ $task->is_done ? 'bg-success' : 'bg-secondary' }}">
          {{ $task->is_done ? 'Tamam' : 'Gözləyir' }}
        </span>
      </a>
    @endforeach
  </div>
  {{ $tasks->links() }}
@else
  <div class="alert alert-info">Hələ tapşırıq yoxdur.</div>
@endif
@endsection
