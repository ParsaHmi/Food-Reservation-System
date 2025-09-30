<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #e1bee7);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
            height: auto;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            text-align: left;
            color: #555;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #7c4dff;
            box-shadow: 0 0 5px rgba(124, 77, 255, 0.2);
            outline: none;
        }

        .btn {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #7c4dff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #651fff;
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #c7c7c7;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="<?php echo e(asset('images/adminlogo.png')); ?>" alt="Admin Logo" height="360" width="360">
        </div>

        <h2>Admin Panel Login</h2>

        <?php if(session('error')): ?>
            <div class="error"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>">
            <?php echo csrf_field(); ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn btn-primary">Login as Admin</button>
        </form>

        <a href="<?php echo e(route('login')); ?>">
            <button class="btn btn-secondary" style="margin-top: 10px;">Back</button>
        </a>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/admin/admin-login.blade.php ENDPATH**/ ?>