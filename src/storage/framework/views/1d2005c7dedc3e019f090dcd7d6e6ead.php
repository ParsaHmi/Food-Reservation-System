<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Foods Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            height: calc(100vh - 200px);
            overflow-y: auto;
        }
        .day-item {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .day-item:hover {
            background: #e9ecef;
        }
        .day-item.active {
            background: #007bff;
            color: white;
        }
        .content-area {
            height: calc(100vh - 200px);
            overflow-y: auto;
        }
        .food-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .week-navigation {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .no-foods {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        .selected-day-header {
            background: #28a745;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- دکمه برگشت -->
        <div class="mb-3">
            <button onclick="window.history.back()" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> BACK
            </button>
        </div>

        <!-- ناوبری هفته -->
        <div class="week-navigation">
            <div class="row align-items-center">
                <div class="col-md-3">
                        <i class="fas fa-chevron-left"></i> Previous Week
                    </a>
                </div>
                <div class="col-md-6 text-center">
                    <h4 class="mb-2">Week Schedule</h4>
                    <div class="current-week mb-2">
                    </div>
                    <div class="date-selector">
                        <form action="" method="GET" class="d-flex justify-content-center">
                            <input type="date" class="form-control me-2" 
                                   style="max-width: 200px;">
                            <button type="submit" class="btn btn-light">Go to Date</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                        Next Week <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- پیام‌ها -->
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

        <div class="row">
            <!-- سایدبار روزهای هفته -->
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="p-3 border-bottom">
                        <h5 class="mb-0">Week Days</h5>
                    </div>
                    <?php
                        $days = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
                    ?>
                    
                    <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $currentDate = $weekDates[$index];
                        $dayFoods = collect($foods)->where('date', $currentDate);
                        $isActive = $index == 0 ? 'active' : ''; // اولین روز به صورت پیش‌فرض فعال
                    ?>
                    <div class="day-item <?php echo e($isActive); ?>" onclick="selectDay('<?php echo e($day); ?>', '<?php echo e($currentDate); ?>', this)">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo e($day); ?></strong>
                                <br>
                                <small><?php echo e(\Carbon\Carbon::parse($currentDate)->format('M d')); ?></small>
                            </div>
                            <span class="badge bg-<?php echo e($dayFoods->count() > 0 ? 'success' : 'secondary'); ?>">
                                <?php echo e($dayFoods->count()); ?>

                            </span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- محتوای اصلی -->
            <div class="col-md-9">
                <div class="content-area">
                    <!-- هدر روز انتخاب شده -->
                    <div class="selected-day-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 id="selectedDayTitle">Saturday</h3>
                                <span id="selectedDateTitle"><?php echo e(\Carbon\Carbon::parse($weekDates[0])->format('l, M d, Y')); ?></span>
                            </div>
                            <a href="<?php echo e(route('admin.weekly-foods.create')); ?>?date=<?php echo e($weekDates[0]); ?>" 
                               class="btn btn-light">
                                <i class="fas fa-plus"></i> Add Food
                            </a>
                        </div>
                    </div>

                    <!-- محتوای روز انتخاب شده -->
                    <div id="dayContent">
                        <!-- محتوای روز اول به صورت پیش‌فرض -->
                        <?php
                            $firstDayFoods = collect($foods)->where('date', $weekDates[0]);
                        ?>
                        
                        <?php if($firstDayFoods->count() > 0): ?>
                            <?php $__currentLoopData = $firstDayFoods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $food): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="food-card">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="text-primary"><?php echo e($food->name); ?></h5>
                                        <p class="mb-1"><strong>Food ID:</strong> <?php echo e($food->food_id); ?></p>
                                        <p class="mb-0"><strong>Description:</strong> <?php echo e($food->description); ?></p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="btn-group">
                                            <a href="<?php echo e(route('admin.weekly-foods.edit', $food->id)); ?>" 
                                               class="btn btn-outline-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.weekly-foods.destroy', $food->id)); ?>" 
                                                  method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to delete this food?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="no-foods">
                                <i class="fas fa-utensils fa-3x mb-3"></i>
                                <h4>No Foods for This Day</h4>
                                <p class="text-muted">No foods have been added for this day yet.</p>
                                <a href="<?php echo e(route('admin.weekly-foods.create')); ?>?date=<?php echo e($weekDates[0]); ?>" 
                                   class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add First Food
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // داده‌های روزها از سرور
        const weekData = {
            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            '<?php echo e($day); ?>': {
                date: '<?php echo e($weekDates[$index]); ?>',
                foods: <?php echo json_encode(collect($foods)->where('date', $weekDates[$index])->values()); ?>

            },
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        };

        function selectDay(day, date, element) {
            // حذف کلاس active از همه روزها
            document.querySelectorAll('.day-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // اضافه کردن کلاس active به روز انتخاب شده
            element.classList.add('active');
            
            // به روز انتخاب شده اسکرول کنیم
            element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // آپدیت هدر
            document.getElementById('selectedDayTitle').textContent = day;
            document.getElementById('selectedDateTitle').textContent = new Date(date).toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            
            // آپدیت دکمه Add Food
            const addButton = document.querySelector('.selected-day-header a');
            addButton.href = "<?php echo e(route('admin.weekly-foods.create')); ?>?date=" + date;
            
            // آپدیت محتوا
            updateDayContent(day);
        }

        function updateDayContent(day) {
            const dayData = weekData[day];
            const contentDiv = document.getElementById('dayContent');
            
            if (dayData.foods.length > 0) {
                let foodsHTML = '';
                
                dayData.foods.forEach(food => {
                    foodsHTML += `
                    <div class="food-card">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="text-primary">${food.name}</h5>
                                <p class="mb-1"><strong>Food ID:</strong> ${food.food_id}</p>
                                <p class="mb-0"><strong>Description:</strong> ${food.description}</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="btn-group">
                                    <a href="/admin/weekly-foods/${food.id}/edit" 
                                       class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="/admin/weekly-foods/${food.id}" 
                                          method="POST" style="display: inline;">
                                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this food?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;
                });
                
                contentDiv.innerHTML = foodsHTML;
            } else {
                contentDiv.innerHTML = `
                    <div class="no-foods">
                        <i class="fas fa-utensils fa-3x mb-3"></i>
                        <h4>No Foods for This Day</h4>
                        <p class="text-muted">No foods have been added for this day yet.</p>
                        <a href="<?php echo e(route('admin.weekly-foods.create')); ?>?date=${dayData.date}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add First Food
                        </a>
                    </div>
                `;
            }
        }

        // مقداردهی اولیه
        document.addEventListener('DOMContentLoaded', function() {
            // اولین روز به صورت پیش‌فرض انتخاب شده است
            const firstDay = document.querySelector('.day-item');
            if (firstDay) {
                const dayName = firstDay.querySelector('strong').textContent;
                const date = weekData[dayName].date;
                selectDay(dayName, date, firstDay);
            }
        });
    </script>
</body>
</html><?php /**PATH /var/www/html/resources/views/admin/updatefood.blade.php ENDPATH**/ ?>