@extends('layouts.admin')

@section('title', 'Editar Plan')

@section('content')
<div class="container-fluid mt-4">
    <h4 class="mb-4">Editar Plan: {{ $plan->name }}</h4>

    <div class="card shadow-sm">
        <div class="card-body">
           @include('plans.partials._form', [
                'plan' => $plan,
                'activities' => $activities,
                'currentPrice' => $currentPrice,
                'details' => $plan->details
            ])
        </div>
    </div>
</div>
@endsection