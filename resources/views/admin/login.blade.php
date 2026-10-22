<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Hệ thống Phòng Khám</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4 text-primary fw-bold">CLINIC ADMIN</h3>
                        
                        @if($errors->any())
                            <div class="alert alert-danger p-2 fs-6">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ url('/admin/login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-secondary">Địa chỉ Email</label>
                                <input type="email" name="email" class="form-control" required placeholder="admin@email.com">
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-secondary">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" required placeholder="******">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Đăng Nhập Hệ Thống</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
