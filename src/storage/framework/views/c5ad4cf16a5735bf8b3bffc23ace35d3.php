<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>غذاهای هفته</h1>
    </div>

    <!-- ناوبری هفته -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <a href="<?php echo e(route('admin.foods.edit', ['date' => $previousWeek])); ?>" 
                       class="btn btn-outline-primary">
                        ← هفته قبل
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
                    <small class="text-muted">هفته جاری: <?php echo e(Carbon\Carbon::parse($currentWeek)->format('d F Y')); ?></small>
                </div>
                
                <div class="col-md-4 text-end">
                    <a href="<?php echo e(route('admin.foods.edit', ['date' => $nextWeek])); ?>" 
                       class="btn btn-outline-primary">
                        هفته بعد →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول غذاهای هفته -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="15%">روز</th>
                            <th width="20%">تاریخ</th>
                            <th>غذاها</th>
                            <th width="15%">تعداد غذاها</th>
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
                                                            <small class="text-muted"><?php echo e(number_format($food->price)); ?> تومان</small>
                                                        </div>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?php echo e(route('admin.foods.edit', $food->id)); ?>" 
                                                               class="btn btn-outline-warning">ویرایش</a>
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
                                    <span class="text-muted">هیچ غذایی برای این روز ثبت نشده است</span>
                                    <br>
                                    <a href="<?php echo e(route('admin.foods.create')); ?>?date=<?php echo e($day['date']); ?>" 
                                       class="btn btn-sm btn-outline-success mt-2">
                                        افزودن غذا
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-<?php echo e($day['foods']->count() > 0 ? 'success' : 'secondary'); ?>">
                                    <?php echo e($day['foods']->count()); ?> غذا
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- آمار کلی -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4><?php echo e($weekDays->sum(function($day) { return $day['foods']->count(); })); ?></h4>
                    <p>کل غذاهای هفته</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4><?php echo e($weekDays->where('foods.count', '>', 0)->count()); ?>/5</h4>
                    <p>روزهای دارای غذا</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <h4><?php echo e(number_format($weekDays->sum(function($day) { 
                        return $day['foods']->sum('price'); 
                    }))); ?></h4>
                    <p>مجموع قیمت‌ها (تومان)</p>
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