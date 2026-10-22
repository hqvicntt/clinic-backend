<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Phòng Khám - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">CLINIC WEB SYSTEM</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger fw-semibold">Đăng Xuất</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success shadow-sm border-0 mb-4 fw-semibold">
                {{ session('success') }}
            </div>
        @endif
        <div class="row text-center mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-white text-dark p-3">
                    <h6 class="text-secondary fw-bold text-uppercase fs-7">Tổng số Bác sĩ</h6>
                    <h2 class="text-primary fw-bold mb-0">{{ $totalDoctors }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-white text-dark p-3">
                    <h6 class="text-secondary fw-bold text-uppercase fs-7">Lịch hẹn Chờ duyệt</h6>
                    <h2 class="text-warning fw-bold mb-0">{{ $totalPending }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-white text-dark p-3">
                    <h6 class="text-secondary fw-bold text-uppercase fs-7">Lịch hẹn Đã duyệt</h6>
                    <h2 class="text-success fw-bold mb-0">{{ $totalApproved }}</h2>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="card-title fw-bold text-dark mb-0">5 Lịch Hẹn Đặt Gần Đây Nhất</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã lịch</th>
                                <th>Bệnh nhân</th>
                                <th>Bác sĩ khám</th>
                                <th>Ngày hẹn</th>
                                <th>Giờ hẹn</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                                <tr>
                                    <td class="fw-semibold">#{{ $appointment->id }}</td>
                                    <td>{{ $appointment->user->name }}</td>
                                    <td>{{ $appointment->doctor->name }}</td>
                                    <td>{{ $appointment->appointment_date }}</td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                    <td>
                                        @if($appointment->status === 'pending')
                                            <span class="badge bg-warning text-dark p-2">Chờ Duyệt</span>
                                        @elseif($appointment->status === 'approved')
                                            <span class="badge bg-success p-2">Đã Duyệt</span>
                                        @elseif($appointment->status === 'completed')
                                            <span class="badge bg-secondary p-2">Đã Khám</span>
                                        @else
                                            <span class="badge bg-danger p-2">Đã Hủy</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($appointment->status === 'pending')
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-sm btn-success fw-semibold px-3">Duyệt</button>
                                                </form>

                                                <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <input type="hidden" name="cancellation_reason" value="Phòng khám bận ca cấp cứu đột xuất.">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold px-3">Hủy</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted fs-7">Không có thao tác</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Hiện tại chưa có yêu cầu đặt lịch hẹn nào từ ứng dụng di động.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
