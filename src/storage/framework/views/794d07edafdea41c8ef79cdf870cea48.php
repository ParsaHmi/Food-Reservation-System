<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login as User - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            text-align: center;
            padding: 20px;
        }
        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: white;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Login as User</h4>
                <small class="opacity-75">Admin Access</small>
            </div>
            <div class="card-body p-4">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('admin.login-by-id')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-4">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" 
                               class="form-control form-control-lg" 
                               id="username" 
                               name="username" 
                               required
                               placeholder="Enter username"
                               value="<?php echo e(old('username')); ?>"
                               autofocus>
                        <div class="form-text">Enter the username of the user you want to login as</div>
                    </div>

                    <div class="alert alert-warning border-warning">
                        <div class="d-flex">
                            <div class="me-3"></div>
                            <div>
                                <strong>Admin Access</strong><br>
                                You will be logged in as this user and have full access to their account.
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Login as User</button>
                        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-back btn-lg">Back</a>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="text-center mt-4">
            <small class="text-muted">
                <?php if(auth()->guard()->check()): ?>
                    Logged in as: <strong><?php echo e(Auth::user()->username); ?></strong> 
                    <span class="badge bg-success ms-2">Admin</span>
                <?php else: ?>
                    <span class="text-warning">Not logged in</span>
                <?php endif; ?>
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });

        document.getElementById('username').addEventListener('input', function() {
            const alert = document.querySelector('.alert-danger');
            if (alert) {
                alert.style.display = 'none';
            }
        });
    </script>
</body>
</html><?php /**PATH /var/www/html/resources/views/admin/users/login-by-username.blade.php ENDPATH**/ ?>