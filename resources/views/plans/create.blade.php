@extends('layouts.admin')

@section('title', 'Crear Nuevo Plan')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Crear Nuevo Plan</h4>

    <div class="card shadow-sm">
        <div class="card-body">
           @include('plans.partials._form', [
			    'plan' => new \App\Models\Plan(),
			    'activities' => $activities,
			    'currentPrice' => (object)['price' => 0],
			    'details' => []
			])
        </div>
    </div>
</div>
@endsection