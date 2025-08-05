<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت کاربران</title>
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .border-right {
            border-right: 1px solid #dee2e6;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h2 class="mb-4">مدیریت کاربران</h2>
        
        <div class="row">
            <!-- بخش چپ (حذف کاربر) -->
            <div class="col-md-6 border-right">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        حذف کاربر
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group">
                                <label for="user_id">آیدی کاربر:</label>
                                <input type="number" class="form-control" id="user_id" name="user_id" required>
                            </div>
                            
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> حذف کاربر
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- بخش راست (ایجاد کاربر جدید) -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        ایجاد کاربر جدید
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name">نام:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="lastname">نام خانوادگی:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="username">نام کاربری:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">رمز عبور:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> ایجاد کاربر
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>