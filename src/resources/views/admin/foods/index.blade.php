@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1>Weekly Foods</h1>
        </div>
    </div>
    
<div class="mb-4 text-end">
    <a href="http://localhost:8888/admin/" class="btn btn-secondary">← Back to Admin Page</a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <!-- Week Navigation -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="{{ route('admin.foods.edit', ['date' => $previousWeek]) }}" 
                       class="btn btn-outline-primary">
                        ← Previous Week
                    </a>
                </div>
                
                <div class="col-md-4 text-center">
                    <form method="GET" action="{{ route('admin.foods.edit') }}" class="mb-0">
                        <input type="week" 
                               name="date" 
                               class="form-control text-center" 
                               value="{{ date('Y-\WW', strtotime($currentWeek)) }}"
                               onchange="this.form.submit()">
                    </form>
                    <small class="text-muted">Current Week: {{ Carbon\Carbon::parse($currentWeek)->format('d F Y') }}</small>
                </div>
                
                <div class="col-md-4 text-end">
                    <a href="{{ route('admin.foods.edit', ['date' => $nextWeek]) }}" 
                       class="btn btn-outline-primary">
                        Next Week →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Foods Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="15%">Day</th>
                            <th width="20%">Date</th>
                            <th>Foods</th>
                            <th width="15%">Add Food</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weekDays as $day)
                        <tr>
                            <td>
                                <strong>{{ $day['name'] }}</strong>
                            </td>
                            <td>
                                {{ $day['display_date'] }}
                            </td>
                            <td>
                                @if($day['foods']->count() > 0)
                                    <div class="row">
                                        @foreach($day['foods'] as $food)
                                        <div class="col-md-6 mb-2">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $food->name }}</h6>
                                                            <small class="text-muted">Food ID: {{ $food->food_id }}</small>
                                                        </div>
                                                        <div class="btn-group btn-group-sm">
                                                            <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this food?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    @if($food->description)
                                                    <small class="text-muted mt-1 d-block">{{ $food->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">No food registered for this day</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.foods.create') }}?date={{ $day['date'] }}" 
                                   class="btn btn-success btn-sm">
                                    Add Food
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4>{{ $weekDays->sum(function($day) { return $day['foods']->count(); }) }}</h4>
                    <p>Total Weekly Foods</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4>{{ $weekDays->where('foods.count', '>', 0)->count() }}/5</h4>
                    <p>Days with Food</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        text-align: center;
    }
    .card.bg-light {
        border: 1px solid #dee2e6;
    }
</style>
@endsection