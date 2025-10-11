@extends('layouts.app')
@section('title',$task->title)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4 m-0">{{ $task->title }}</h1>
  <div>
    <a href="{{ route('tasks.edit',$task) }}" class="btn btn-outline-primary">Redaktə</a>
    <form action="{{ route('tasks.destroy',$task) }}" method="post" class="d-inline"
          onsubmit="return confirm('Silmək istəyirsən?')">
      @csrf @method('DELETE')
      <button class="btn btn-outline-danger">Sil</button>
    </form>
  </div>
</div>
<p class="mb-2">{{ $task->description }}</p>
<span class="badge {{ $task->is_done ? 'bg-success' : 'bg-secondary' }}">
  {{ $task->is_done ? 'Tamam' : 'Gözləyir' }}
</span>
@endsection
