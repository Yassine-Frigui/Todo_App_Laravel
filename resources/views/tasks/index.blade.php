@extends('layouts.app')

@section('title', 'Mes taches')

@section('content')
<div class="surface-card p-3 p-md-4">
	<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
		<div>
			<h2 class="h3 mb-1">Mes taches</h2>
			<p class="mb-0 text-muted-soft">{{ $tasks->count() }} element(s) au total</p>
		</div>
		<a href="{{ route('tasks.create') }}" class="btn btn-brand px-4">+ Nouvelle tache</a>
	</div>

	@forelse($tasks as $task)
		<article class="card border-0 shadow-sm mb-3 {{ $task->completed ? 'bg-success-subtle' : '' }}">
			<div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
				<div class="flex-grow-1">
					<div class="d-flex align-items-center gap-2 mb-2">
						<h3 class="h5 mb-0 {{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">{{ $task->title }}</h3>
						@if($task->completed)
							<span class="badge text-bg-success">Terminee</span>
						@else
							<span class="badge text-bg-warning">En cours</span>
						@endif
					</div>

					@if($task->description)
						<p class="mb-0 text-muted-soft">{{ $task->description }}</p>
					@else
						<p class="mb-0 text-muted-soft fst-italic">Aucune description</p>
					@endif
				</div>

				<div class="d-flex align-items-center gap-2">
					<a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary btn-sm">Modifier</a>
					<form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette tache ?')">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-outline-danger btn-sm">Supprimer</button>
					</form>
				</div>
			</div>
		</article>
	@empty
		<div class="text-center py-5">
			<h3 class="h5 mb-2">Aucune tache pour le moment</h3>
			<p class="text-muted-soft mb-3">Commence par ajouter ta premiere tache.</p>
			<a href="{{ route('tasks.create') }}" class="btn btn-brand">Creer une tache</a>
		</div>
	@endforelse
</div>
@endsection