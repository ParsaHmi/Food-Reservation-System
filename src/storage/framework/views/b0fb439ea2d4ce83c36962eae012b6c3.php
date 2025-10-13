<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login to System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Vazir', sans-serif;
            direction: ltr;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 40px 30px;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        .logo h2 {
            margin-top: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ffcdd2;
            font-size: 14px;
        }

        label {
            display: block;
            margin-top: 20px;
            margin-bottom: 6px;
            font-weight: 500;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #15ff00;
            outline: none;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background-color: #15ff00;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0ecc00;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            display: block;
            color: #0056ff;
            text-decoration: none;
            font-size: 14px;
            margin: 8px 0;
        }

        .links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                margin: 30px 20px;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="logo">
            <h2>FOOD RESERVATION SYSTEM</h2>
        </div>

        <!-- نمایش خطا -->
        <?php if($errors->has('login_error')): ?>
            <div class="error-message">
                <?php echo e($errors->first('login_error')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo e(old('username')); ?>" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            <a href="<?php echo e(route('resetPassword')); ?>">Forgot Password?</a>
            <a href="<?php echo e(route('admin.dashboard')); ?>">Admin Panel</a>
        </div>
    </div>
</body>
</html><?php /**PATH /var/www/html/resources/views/login.blade.php ENDPATH**/ ?>