<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 15px 0;
        }

        a {
            display: inline-block;
            width: 100%;
            padding: 12px 20px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        @media (max-width: 480px) {
            .container {
                margin: 30px 15px;
                padding: 20px;
            }

            a {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>

        <ul>
            <li><a href="{{ route('admin.foods.edit') }}">Update Foods</a></li>
            <li><a href="{{ route('admin.users.loginByUsernameForm') }}">Login By Username</a></li>
            <li><a href="{{ route('admin.users.create') }}">Add / Delete User</a></li>
        </ul>
    </div>
</body>
</html>
