@csrf
<div class="mb-3">
  <label class="form-label">Başlıq</label>
  <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}" class="form-control" required>
  @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
  <label class="form-label">Açıqlama</label>
  <textarea name="description" rows="4" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
  @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
</div>
<div class="form-check mb-3">
  <input class="form-check-input" type="checkbox" name="is_done" id="is_done"
         {{ old('is_done', $task->is_done ?? false) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_done">Tamamlandı</label>
</div>
<button class="btn btn-success">Yadda saxla</button>
<a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Geri</a>
