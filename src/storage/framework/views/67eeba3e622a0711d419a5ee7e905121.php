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
            <a class="navbar-brand" href="<?php echo e(route('user.weekly-reservations')); ?>">Food Reservation System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-light me-3">
                            <?php echo e(Auth::user()->name ?? Auth::user()->username); ?>

                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-warning btn-sm" href="<?php echo e(route('change-password')); ?>">
                            Change Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
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

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <a href="<?php echo e(route('user.weekly-reservations', ['date' => $previousWeek])); ?>" 
                           class="btn btn-outline-primary">
                            ← Previous Week
                        </a>
                    </div>
                    
                    <div class="col-md-4 text-center">
                        <form method="GET" action="<?php echo e(route('user.weekly-reservations')); ?>" class="mb-0">
                            <input type="week" 
                                   name="date" 
                                   class="form-control text-center" 
                                   value="<?php echo e(date('Y-\WW', strtotime($currentWeek))); ?>"
                                   onchange="this.form.submit()">
                        </form>
                        <small class="text-muted">Week of <?php echo e(\Carbon\Carbon::parse($currentWeek)->startOfWeek()->format('M d')); ?> - <?php echo e(\Carbon\Carbon::parse($currentWeek)->endOfWeek()->format('M d, Y')); ?></small>
                    </div>
                    
                    <div class="col-md-4 text-end">
                        <a href="<?php echo e(route('user.weekly-reservations', ['date' => $nextWeek])); ?>" 
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
                            <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($day['is_today'] ? 'table-info' : ''); ?>">
                                <td>
                                    <strong><?php echo e($day['name']); ?></strong>
                                    <?php if($day['is_today']): ?>
                                        <span class="badge bg-primary">Today</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($day['display_date']); ?>

                                </td>
                                <td>
                                    <?php if(isset($day['available_foods']) && count($day['available_foods']) > 0): ?>
                                        <div class="foods-container">
                                            <?php $__currentLoopData = $day['available_foods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $food): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="food-item card p-2 <?php echo e($day['reserved_food_id'] == $food->id ? 'selected' : ''); ?>"
                                                 onclick="reserveFood('<?php echo e($day['date']); ?>', <?php echo e($food->id); ?>, this)">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1"><?php echo e($food->name); ?></h6>
                                                        <?php if($food->description): ?>
                                                            <small class="text-muted d-block"><?php echo e($food->description); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="ms-2">
                                                        <?php if($day['reserved_food_id'] == $food->id): ?>
                                                            <span class="badge bg-success">✓ Reserved</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-outline-primary">Click to Reserve</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-foods-message">
                                            <small>No foods defined for this day</small>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if(count($day['reservations']) > 0): ?>
                                        <?php $__currentLoopData = $day['reservations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card reservation-card bg-light mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-2"><?php echo e($reservation->food_name); ?></h6>
                                                        <?php if($reservation->description): ?>
                                                            <p class="text-muted mb-2 small"><?php echo e($reservation->description); ?></p>
                                                        <?php endif; ?>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <span class="badge <?php echo e($reservation->eaten ? 'bg-success' : 'bg-warning'); ?>">
                                                                <?php echo e($reservation->eaten ? '✓ Eaten' : 'Pending'); ?>

                                                            </span>
                                                            <small class="text-muted">
                                                                <?php echo e(\Carbon\Carbon::parse($reservation->created_at)->format('M d, H:i')); ?>

                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="ms-3">
                                                        <form action="<?php echo e(route('user.delete-reservation')); ?>" method="POST" class="d-inline">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="reservation_date" value="<?php echo e($day['date']); ?>">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                                    onclick="return confirm('Are you sure you want to delete your reservation for <?php echo e($day['display_date']); ?>?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="text-center py-3">
                                            <span class="text-muted">No reservation yet</span>
                                            <br>
                                            <small class="text-muted">Click on a food to reserve it</small>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4><?php echo e(array_sum(array_map(function($day) { return count($day['reservations']); }, $weekDays))); ?></h4>
                        <p>Total Reservations</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4><?php echo e(count(array_filter($weekDays, function($day) { return count($day['reservations']) > 0; }))); ?>/7</h4>
                        <p>Days with Reservation</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4><?php echo e(array_sum(array_map(function($day) { 
                            return count(array_filter($day['reservations'], function($res) { 
                                return $res->eaten; 
                            })); 
                        }, $weekDays))); ?></h4>
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
            form.action = '<?php echo e(route("user.store-reservation")); ?>';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '<?php echo e(csrf_token()); ?>';
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
</html><?php /**PATH /var/www/html/resources/views/weekly-reservations.blade.php ENDPATH**/ ?>