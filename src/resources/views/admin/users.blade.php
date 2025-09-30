@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS MANAGER</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .border-left {
            border-left: 1px solid #dee2e6;
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
            text-align: left;
        }
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        .users-table th {
            position: sticky;
            top: 0;
            background: #f8f9fa;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h2 class="mb-4 text-center">CHANGING USERS</h2>        
        <div class="row">
            <!-- بخش راست (ایجاد کاربر جدید) -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        New User 
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="id">ID : </label>
                                <input type="text" class="form-control" id="id" name="id" required>
                            </div>

                            <div class="form-group">
                                <label for="name">NAME :</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="lastname">LAST NAME :</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="username">USERNAME :</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">PASSWORD : </label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> CREATE USER 
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- بخش چپ (حذف کاربر) -->
            <div class="col-md-6 border-left">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        Delete existing User
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            
                            <div class="form-group">
                                <label for="user_id">USER ID :</label>
                                <input type="number" class="form-control" id="user_id" name="user_id" required>
                            </div>
                            
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> DELETE USER 
                            </button>
                        </form>

                        <!-- جدول کاربران موجود -->
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">Existing Users:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped table-hover users-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $user)
                                        <tr>
                                            <td><strong>{{ $user->id }}</strong></td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->username }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">
                                                No users found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-muted small mt-2">
                                Total: {{ count($users) }} users
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- اسکریپت برای پر کردن خودکار فیلد ID هنگام کلیک روی ردیف -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.users-table tbody tr');
            const userIdInput = document.getElementById('user_id');
            
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    const userId = this.cells[0].textContent.trim();
                    userIdInput.value = userId;
                    
                    // هایلایت کردن ردیف انتخاب شده
                    tableRows.forEach(r => r.classList.remove('table-active'));
                    this.classList.add('table-active');
                });
            });
        });
    </script>
</body>
</html>