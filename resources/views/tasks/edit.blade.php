@extends('layouts.app')

@section('title', 'Modifier la tache')

@section('content')
<div class="surface-card p-3 p-md-4">
    <div class="mb-4">
        <h2 class="h3 mb-1">Modifier la tache</h2>
        <p class="mb-0 text-muted-soft">Mets a jour les details puis enregistre.</p>
    </div>

    <form action="{{ route('tasks.update', $task) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-12">
            <label for="title" class="form-label fw-semibold">Titre *</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $task->title) }}"
                required
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="form-control @error('description') is-invalid @enderror"
            >{{ old('description', $task->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="completed" name="completed" {{ old('completed', $task->completed) ? 'checked' : '' }}>
                <label class="form-check-label" for="completed">Marquer comme terminee</label>
            </div>
        </div>

        <div class="col-12 d-flex gap-2 pt-2">
            <button type="submit" class="btn btn-brand px-4">Mettre a jour</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection

