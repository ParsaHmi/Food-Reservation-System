<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .reset-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .form-control:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="javascript:history.back()" class="btn btn-secondary">← Back</a>
                </div>
                
                <div class="card reset-card">
                    <div class="card-header text-white text-center py-4">
                        <h3 class="mb-0">Password Reset</h3>
                        <p class="mb-0 mt-2 opacity-75">Reset your password</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Success/Error Messages -->
                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo session('success'); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Password Reset Form -->
                        <form action="/password/reset" method="POST">
                            <?php echo csrf_field(); ?>
                            
                            <div class="mb-4">
                                <label for="username" class="form-label fw-bold">👤 Username</label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="username" 
                                       name="username" 
                                       value="<?php echo e(old('username')); ?>" 
                                       required
                                       placeholder="Enter your username">
                            </div>

                            <div class="mb-4">
                                <label for="user_id" class="form-label fw-bold">🆔 User ID</label>
                                <input type="number" 
                                       class="form-control form-control-lg" 
                                       id="user_id" 
                                       name="user_id" 
                                       value="<?php echo e(old('user_id')); ?>" 
                                       required
                                       placeholder="Enter your user ID">
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                                Reset Password
                            </button>
                        </form>

                        <!-- Help Information -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="fw-bold">💡 How it works:</h6>
                            <ul class="list-unstyled mb-0 small">
                                <li>• Enter your username and user ID</li>
                                <li>• Your new password will be: <strong>first_name + last_name</strong></li>
                                <li>• After reset, you can login with the new password</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH /var/www/html/resources/views/resetpassword.blade.php ENDPATH**/ ?>