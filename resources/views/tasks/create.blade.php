@extends('layouts.app')

@section('title', 'Nouvelle tache')

@section('content')
<div class="surface-card p-3 p-md-4">
    <div class="mb-4">
        <h2 class="h3 mb-1">Nouvelle tache</h2>
        <p class="mb-0 text-muted-soft">Renseigne les details de ta prochaine action.</p>
    </div>

    <form action="{{ route('tasks.store') }}" method="POST" class="row g-3">
        @csrf

        <div class="col-12">
            <label for="title" class="form-label fw-semibold">Titre *</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title') }}"
                placeholder="Ex: Finaliser le rapport"
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
                placeholder="Ajoute un contexte utile"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 d-flex gap-2 pt-2">
            <button type="submit" class="btn btn-brand px-4">Enregistrer</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
