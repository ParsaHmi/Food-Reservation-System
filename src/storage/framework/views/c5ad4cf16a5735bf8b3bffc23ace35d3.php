<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1>Weekly Foods</h1>
        </div>
    </div>
    
<div class="mb-4 text-end">
    <a href="http://localhost:8888/admin/" class="btn btn-secondary">← Back to Admin Page</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
    <!-- Week Navigation -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="<?php echo e(route('admin.foods.edit', ['date' => $previousWeek])); ?>" 
                       class="btn btn-outline-primary">
                        ← Previous Week
                    </a>
                </div>
                
                <div class="col-md-4 text-center">
                    <form method="GET" action="<?php echo e(route('admin.foods.edit')); ?>" class="mb-0">
                        <input type="week" 
                               name="date" 
                               class="form-control text-center" 
                               value="<?php echo e(date('Y-\WW', strtotime($currentWeek))); ?>"
                               onchange="this.form.submit()">
                    </form>
                    <small class="text-muted">Current Week: <?php echo e(Carbon\Carbon::parse($currentWeek)->format('d F Y')); ?></small>
                </div>
                
                <div class="col-md-4 text-end">
                    <a href="<?php echo e(route('admin.foods.edit', ['date' => $nextWeek])); ?>" 
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
                        <?php $__currentLoopData = $weekDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <strong><?php echo e($day['name']); ?></strong>
                            </td>
                            <td>
                                <?php echo e($day['display_date']); ?>

                            </td>
                            <td>
                                <?php if($day['foods']->count() > 0): ?>
                                    <div class="row">
                                        <?php $__currentLoopData = $day['foods']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $food): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="card bg-light">
                                                <div class="card-body py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-0"><?php echo e($food->name); ?></h6>
                                                            <small class="text-muted">Food ID: <?php echo e($food->food_id); ?></small>
                                                        </div>
                                                        <div class="btn-group btn-group-sm">
                                                            <form action="<?php echo e(route('admin.foods.destroy', $food->id)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this food?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php if($food->description): ?>
                                                    <small class="text-muted mt-1 d-block"><?php echo e($food->description); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">No food registered for this day</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?php echo e(route('admin.foods.create')); ?>?date=<?php echo e($day['date']); ?>" 
                                   class="btn btn-success btn-sm">
                                    Add Food
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <h4><?php echo e($weekDays->sum(function($day) { return $day['foods']->count(); })); ?></h4>
                    <p>Total Weekly Foods</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4><?php echo e($weekDays->where('foods.count', '>', 0)->count()); ?>/5</h4>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/foods/index.blade.php ENDPATH**/ ?>