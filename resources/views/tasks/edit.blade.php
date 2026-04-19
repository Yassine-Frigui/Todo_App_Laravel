@extends('layouts.app')
@section('content')
<div class="card">
 <form action="{{ route('tasks.update', $task) }}" method="POST">
 @csrf
 @method('PUT')
 <input type="text" name="title"
 value="{{ old('title', $task->title) }}">
 @error('title') <div>{{ $message }}</div> @enderror
 <textarea name="description">{{ old('description', $task->description)
}}</textarea>
 <input type="checkbox" name="completed" {{ $task->completed ? 'checked' : ''
}}>
 <label>Marquer comme terminée</label>
 <button type="submit">� Mettre à jour</button>
 <a href="{{ route('tasks.index') }}">Annuler</a>
 </form>
</div>
@endsection
