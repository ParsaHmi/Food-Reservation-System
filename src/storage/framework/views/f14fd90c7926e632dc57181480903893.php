<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weekly Food Calendar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* استایل‌ها مانند قبل */
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container { max-width: 1400px; margin: 0 auto; }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
        }
        .week-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .day-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 2px solid #e9ecef;
            min-height: 300px;
        }
        .day-card.today { border-color: #007bff; background-color: #f8f9ff; }
        .day-header {
            text-align: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        .food-item {
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }
        .food-item:hover { background: #e9ecef; transform: translateX(5px); }
        .food-item.selected { background: #007bff; color: white; border-color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Weekly Food Calendar</h1>
            <p class="lead">Reserve your meals for the week</p>
            <div class="mt-3">
                <a href="<?php echo e(route('user.reservations')); ?>" class="btn btn-light btn-lg">
                    View All Reservations
                </a>
                    Logout
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->has('reservation_error')): ?>
            <div class="alert alert-danger">
                <?php echo e($errors->first('reservation_error')); ?>

            </div>
        <?php endif; ?>

        
        <?php if(isset($weekDays) && count($weekDays) > 0): ?>
            <div class="week-navigation">
                <button class="btn btn-outline-primary" onclick="changeWeek(-1)">← Previous Week</button>
                <h4 class="mb-0">
                    Week of <?php echo e(\Carbon\Carbon::parse($weekDays[0]['date'])->format('F j, Y')); ?> - 
                    <?php echo e(\Carbon\Carbon::parse($weekDays[6]['date'])->format('F j, Y')); ?>

                </h4>
                <button class="btn btn-outline-primary" onclick="changeWeek(1)">Next Week →</button>
            </div>

            <div class="calendar-grid">
                <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $isToday = $day['date'] == \Carbon\Carbon::now()->format('Y-m-d');
                        $dayReservations = isset($weekReservations[$day['date']]) ? $weekReservations[$day['date']] : [];
                    ?>
                    
                    <div class="day-card <?php echo e($isToday ? 'today' : ''); ?>">
                        <div class="day-header">
                            <div class="day-name"><?php echo e($day['day_name']); ?></div>
                            <div class="day-date"><?php echo e($day['display_date']); ?></div>
                            <?php if($isToday): ?>
                                <span class="badge bg-primary mt-1">Today</span>
                            <?php endif; ?>
                        </div>

                        <?php if(count($dayReservations) > 0): ?>
                            <?php $__currentLoopData = $dayReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="reservation-info reserved p-2 mb-2 bg-light rounded">
                                    <h6 class="mb-1"><?php echo e($reservation->food_name ?? 'Unknown Food'); ?></h6>
                                    <p class="mb-1 text-muted">$<?php echo e(number_format($reservation->price ?? 0, 2)); ?></p>
                                    <span class="badge <?php echo e($reservation->eaten ? 'bg-success' : 'bg-warning'); ?>">
                                        <?php echo e($reservation->eaten ? 'Eaten' : 'Pending'); ?>

                                    </span>
                                    
                                    <div class="action-buttons mt-2">
                                        <form method="POST" action="<?php echo e(route('user.toggle-eaten')); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="reservation_id" value="<?php echo e($reservation->id); ?>">
                                            <button type="submit" class="btn btn-sm <?php echo e($reservation->eaten ? 'btn-warning' : 'btn-success'); ?>">
                                                <?php echo e($reservation->eaten ? 'Not Eaten' : 'Eaten'); ?>

                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="<?php echo e(route('user.delete-reservation')); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="reservation_id" value="<?php echo e($reservation->id); ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this reservation?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('user.store-reservation')); ?>" class="reservation-form">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="reservation_date" value="<?php echo e($day['date']); ?>">
                                
                                <h6>Select a food:</h6>
                                <div class="food-list">
                                    <?php if(isset($foods) && count($foods) > 0): ?>
                                        <?php $__currentLoopData = $foods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $food): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="food-item" onclick="selectFood(this, <?php echo e($food->id); ?>)">
                                                <div class="fw-bold"><?php echo e($food->name); ?></div>
                                                <small class="text-muted">$<?php echo e(number_format($food->price, 2)); ?></small>
                                                <input type="radio" name="food_id" value="<?php echo e($food->id); ?>" 
                                                       style="display: none;" required>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            No foods available for reservation.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if(isset($foods) && count($foods) > 0): ?>
                                    <button type="submit" class="btn btn-success w-100 mt-2" disabled>
                                        Reserve This Meal
                                    </button>
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <h4>Error Loading Calendar</h4>
                <p>Unable to load week data. Please try again later.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectFood(element, foodId) {
            // Remove selection from all food items in this day card
            const dayCard = element.closest('.day-card');
            dayCard.querySelectorAll('.food-item').forEach(item => {
                item.classList.remove('selected');
                item.querySelector('input[type="radio"]').checked = false;
            });
            
            // Select current food item
            element.classList.add('selected');
            element.querySelector('input[type="radio"]').checked = true;
            
            // Enable reserve button
            const reserveButton = dayCard.querySelector('button[type="submit"]');
            if (reserveButton) {
                reserveButton.disabled = false;
            }
        }
        
        function changeWeek(weeks) {
            // برای سادگی، صفحه را رفرش می‌کنیم
            window.location.reload();
        }
    </script>
</body>
</html><?php /**PATH /var/www/html/resources/views/reservations.blade.php ENDPATH**/ ?>