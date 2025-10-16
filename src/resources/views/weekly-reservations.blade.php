<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Food Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .food-item {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            margin-bottom: 8px;
        }
        .food-item:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }
        .food-item.selected {
            border-color: #28a745;
            background-color: #d4edda;
        }
        .reservation-card {
            border-left: 4px solid #007bff;
        }
        .no-foods-message {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-style: italic;
        }
        .badge.bg-outline-primary {
            background-color: transparent;
            border: 1px solid #007bff;
            color: #007bff;
        }
        .navbar-nav .nav-item {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('user.weekly-reservations') }}">Food Reservation System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-light me-3">
                            {{ Auth::user()->name ?? Auth::user()->username }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-warning btn-sm" href="{{ route('change-password') }}">
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1>Weekly Food Reservations</h1>
                <p class="lead">Click on any food to reserve it for that day</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <a href="{{ route('user.weekly-reservations', ['date' => $previousWeek]) }}" 
                           class="btn btn-outline-primary">
                            ← Previous Week
                        </a>
                    </div>
                    
                    <div class="col-md-4 text-center">
                        <form method="GET" action="{{ route('user.weekly-reservations') }}" class="mb-0">
                            <input type="week" 
                                   name="date" 
                                   class="form-control text-center" 
                                   value="{{ date('Y-\WW', strtotime($currentWeek)) }}"
                                   onchange="this.form.submit()">
                        </form>
                        <small class="text-muted">Week of {{ \Carbon\Carbon::parse($currentWeek)->startOfWeek()->format('M d') }} - {{ \Carbon\Carbon::parse($currentWeek)->endOfWeek()->format('M d, Y') }}</small>
                    </div>
                    
                    <div class="col-md-4 text-end">
                        <a href="{{ route('user.weekly-reservations', ['date' => $nextWeek]) }}" 
                           class="btn btn-outline-primary">
                            Next Week →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="15%">Day</th>
                                <th width="15%">Date</th>
                                <th width="35%">Available Foods</th>
                                <th width="35%">Your Reservation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weekDays as $day)
                            <tr class="{{ $day['is_today'] ? 'table-info' : '' }}">
                                <td>
                                    <strong>{{ $day['name'] }}</strong>
                                    @if($day['is_today'])
                                        <span class="badge bg-primary">Today</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $day['display_date'] }}
                                </td>
                                <td>
                                    @if(isset($day['available_foods']) && count($day['available_foods']) > 0)
                                        <div class="foods-container">
                                            @foreach($day['available_foods'] as $food)
                                            <div class="food-item card p-2 {{ $day['reserved_food_id'] == $food->id ? 'selected' : '' }}"
                                                 onclick="reserveFood('{{ $day['date'] }}', {{ $food->id }}, this)">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $food->name }}</h6>
                                                        @if($food->description)
                                                            <small class="text-muted d-block">{{ $food->description }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="ms-2">
                                                        @if($day['reserved_food_id'] == $food->id)
                                                            <span class="badge bg-success">✓ Reserved</span>
                                                        @else
                                                            <span class="badge bg-outline-primary">Click to Reserve</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="no-foods-message">
                                            <small>No foods defined for this day</small>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if(count($day['reservations']) > 0)
                                        @foreach($day['reservations'] as $reservation)
                                        <div class="card reservation-card bg-light mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-2">{{ $reservation->food_name }}</h6>
                                                        @if($reservation->description)
                                                            <p class="text-muted mb-2 small">{{ $reservation->description }}</p>
                                                        @endif
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="badge {{ $reservation->eaten ? 'bg-success' : 'bg-warning' }}">
                                                                {{ $reservation->eaten ? '✓ Eaten' : 'Pending' }}
                                                            </span>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($reservation->created_at)->format('M d, H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="ms-3">
                                                        <form action="{{ route('user.delete-reservation') }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="reservation_date" value="{{ $day['date'] }}">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                    onclick="return confirm('Are you sure you want to delete your reservation for {{ $day['display_date'] }}?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-3">
                                            <span class="text-muted">No reservation yet</span>
                                            <br>
                                            <small class="text-muted">Click on a food to reserve it</small>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>{{ array_sum(array_map(function($day) { return count($day['reservations']); }, $weekDays)) }}</h4>
                        <p>Total Reservations</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ count(array_filter($weekDays, function($day) { return count($day['reservations']) > 0; })) }}/7</h4>
                        <p>Days with Reservation</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4>{{ array_sum(array_map(function($day) { 
                            return count(array_filter($day['reservations'], function($res) { 
                                return $res->eaten; 
                            })); 
                        }, $weekDays)) }}</h4>
                        <p>Meals Eaten</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function reserveFood(date, foodId, element) {
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("user.store-reservation") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            const dateInput = document.createElement('input');
            dateInput.type = 'hidden';
            dateInput.name = 'reservation_date';
            dateInput.value = date;
            form.appendChild(dateInput);
            
            const foodInput = document.createElement('input');
            foodInput.type = 'hidden';
            foodInput.name = 'food_id';
            foodInput.value = foodId;
            form.appendChild(foodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>