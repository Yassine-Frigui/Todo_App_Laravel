

@extends('layouts.app') 
@section('content') 
<div class="container"> 
<div class="d-flex justify-content-between align-items-center mb-4"> 
<h1>Mes Taches</h1> 
<div> 
{{-- Afficher l'utilisateur connecte --}} 
<span class="badge bg-primary"> 
{{ auth()->user()->name }} 
</span> 
{{-- Lien de deconnexion --}} 
<form method="POST" action="{{ route('logout') }}" class="d-inline"> 
@csrf 
<button type="submit" class="btn btn-sm btn-outline-danger"> 
Deconnexion 
</button> 
</form> 
</div> 
</div> 
{{-- ... reste de la vue ... --}} 
</div> 
@endsection 