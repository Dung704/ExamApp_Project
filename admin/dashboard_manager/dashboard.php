<?php
//Tổng số người dùng
$sql = "SELECT COUNT(*) AS total FROM nguoi_dung";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$tong_nguoi_dung = $row['total'];

//Tổng số đề thi
$sql = "SELECT COUNT(*) AS total FROM de_thi";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$tong_de_thi = $row['total'];

//Tổng câu hỏi
$sql_tong_cau_hoi = "SELECT COUNT(*) AS tong_cau_hoi FROM cau_hoi";
$result_tong_cau_hoi = mysqli_query($conn, $sql_tong_cau_hoi);
$row_tong_cau_hoi = mysqli_fetch_assoc($result_tong_cau_hoi);
$tong_cau_hoi = $row_tong_cau_hoi['tong_cau_hoi'];

//Tổng bài học
$sql_tong_bai_hoc = "SELECT COUNT(*) AS tong_bai_hoc FROM bai_hoc";
$result_tong_bai_hoc = mysqli_query($conn, $sql_tong_bai_hoc);
$row_tong_bai_hoc = mysqli_fetch_assoc($result_tong_bai_hoc);
$tong_bai_hoc = $row_tong_bai_hoc['tong_bai_hoc'];

//Tổng số lượt thi
$sql_tong_luot_thi = "SELECT COUNT(*) AS tong_luot_thi FROM ket_qua_thi";
$result_tong_luot_thi = mysqli_query($conn, $sql_tong_luot_thi);
$row_tong_luot_thi = mysqli_fetch_assoc($result_tong_luot_thi);
$tong_luot_thi = $row_tong_luot_thi['tong_luot_thi'];

//Số câu hỏi đã đặt
$sql_so_cau_hoi_da_dat = "SELECT COUNT(*) AS so_cau_hoi_da_dat FROM cau_hoi_nguoi_dung";
$result_so_cau_hoi_da_dat = mysqli_query($conn, $sql_so_cau_hoi_da_dat);
$row_so_cau_hoi_da_dat = mysqli_fetch_assoc($result_so_cau_hoi_da_dat);
$so_cau_hoi_da_dat = $row_so_cau_hoi_da_dat['so_cau_hoi_da_dat'];

//Số câu trả lời 
$sql_so_cau_tra_loi = "SELECT COUNT(*) AS so_cau_tra_loi FROM cau_tra_loi_nguoi_dung";
$result_so_cau_tra_loi = mysqli_query($conn, $sql_so_cau_tra_loi);
$row_so_cau_tra_loi = mysqli_fetch_assoc($result_so_cau_tra_loi);
$so_cau_tra_loi = $row_so_cau_tra_loi['so_cau_tra_loi'];

//số câu hỏi cộng đồng chưa trả lời
$sql_chua_tra_loi = "
SELECT COUNT(*) AS so_cau_chua_tra_loi
FROM cau_hoi_nguoi_dung AS ch
LEFT JOIN cau_tra_loi_nguoi_dung AS ctl
    ON ch.id = ctl.id_cau_hoi
WHERE ctl.id IS NULL
";
$result_chua_tra_loi = mysqli_query($conn, $sql_chua_tra_loi);
$row_chua_tra_loi = mysqli_fetch_assoc($result_chua_tra_loi);
$so_cau_chua_tra_loi = $row_chua_tra_loi['so_cau_chua_tra_loi'];

//số người dùng mới trong tuần này
$sql_nguoi_dung_moi = "
SELECT COUNT(*) AS so_nguoi_dung_moi
FROM nguoi_dung
WHERE YEARWEEK(ngay_tao, 1) = YEARWEEK(CURDATE(), 1)
";
$result_nguoi_dung_moi = mysqli_query($conn, $sql_nguoi_dung_moi);
$row_nguoi_dung_moi = mysqli_fetch_assoc($result_nguoi_dung_moi);
$so_nguoi_dung_moi = $row_nguoi_dung_moi['so_nguoi_dung_moi'];


?>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary  shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Người dùng
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tong_nguoi_dung ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow  py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Đề thi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tong_de_thi ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Tổng số câu hỏi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tong_cau_hoi ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Bài học
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tong_bai_hoc ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Lượt thi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $tong_luot_thi ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-stopwatch fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Câu hỏi đã đặt
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $so_cau_hoi_da_dat ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-question fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Câu trả lời đóng góp
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $so_cau_tra_loi ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-reply fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Câu hỏi chưa trả lời
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $so_cau_chua_tra_loi ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Người dùng mới tuần này
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $so_nguoi_dung_moi ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php if (false): ?>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_doanhThu">
                        Doanh thu theo giờ (Hôm nay)
                    </h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle btn btn-sm btn-outline-primary" href="#" role="button"
                            id="dropdownTime_doanhThu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-calendar-alt"></i> <span id="timeLabel_doanhThu">Theo giờ</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownTime_doanhThu">
                            <div class="dropdown-header">Chọn thời gian:</div>
                            <a class="dropdown-item" href="#" onclick="changeTimeFilter_doanhThu('gio'); return false;">
                                <i class="fas fa-clock"></i> Theo giờ (Hôm nay)
                            </a>
                            <a class="dropdown-item" href="#" onclick="changeTimeFilter_doanhThu('ngay'); return false;">
                                <i class="fas fa-calendar-day"></i> Theo ngày (Tháng này)
                            </a>
                            <a class="dropdown-item" href="#" onclick="changeTimeFilter_doanhThu('thang'); return false;">
                                <i class="fas fa-calendar"></i> Theo tháng (Năm nay)
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <canvas id="myChart_doanhThu" width="1000" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Card Biểu Đồ Phổ Điểm -->
<div class="col-xl-12 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_phoDiem">
                <i class="fas fa-chart-pie mr-2"></i>Phổ điểm theo danh mục - Tất cả
            </h6>
            <div class="dropdown no-arrow">
                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuLink_phoDiem"
                    data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: inherit;">
                    <i class="fas fa-filter fa-sm fa-fw text-gray-400"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink_phoDiem">
                    <li>
                        <h6 class="dropdown-header">Chọn danh mục:</h6>
                    </li>
                    <li><a class="dropdown-item active" href="javascript:void(0);" onclick="changePhoDiemCategory('all', this); return false;">
                            <i class="fas fa-globe me-2"></i> Tất cả
                        </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="changePhoDiemCategory('HSK', this); return false;">
                            <i class="fas fa-language me-2"></i> HSK (Tiếng Trung)
                        </a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="changePhoDiemCategory('TOPIK', this); return false;">
                            <i class="fas fa-flag me-2"></i> TOPIK (Tiếng Hàn)
                        </a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="changePhoDiemCategory('TOEIC', this); return false;">
                            <i class="fas fa-book me-2"></i> TOEIC (Tiếng Anh)
                        </a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="changePhoDiemCategory('JPN', this); return false;">
                            <i class="fas fa-torii-gate me-2"></i> JPN (Tiếng Nhật)
                        </a></li>
                </ul>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="loading-spinner" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i>
                <p class="mt-2 text-muted">Đang tải dữ liệu...</p>
            </div>

            <!-- Chart Container -->
            <div class="chart-container" id="chartContainer" style="height: 300px;">
                <canvas id="myChart_phoDiem"></canvas>
            </div>

            <!-- Thông tin tổng số bài thi -->
            <div class="mt-3 text-center">
                <span class="badge badge-info" id="totalExams">
                    <i class="fas fa-file-alt mr-1"></i>Tổng: 0 bài thi
                </span>
            </div>

            <!-- Bảng thống kê chi tiết (tùy chọn) -->
            <div class="mt-3" id="detailStats" style="display: none;">
                <table class="table table-sm table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Xếp loại</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody id="statsTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
    // ==================== BIỂU ĐỒ PHỔ ĐIỂM ====================

    let chartPhoDiem = null;
    let currentCategory = 'all';

    // Màu sắc cho từng xếp loại
    const colors = {
        gioi: '#28a745', // Xanh lá - Giỏi
        kha: '#17a2b8', // Xanh dương - Khá
        trung_binh: '#ffc107', // Vàng - Trung bình
        yeu: '#dc3545' // Đỏ - Yếu
    };

    // Tên danh mục đầy đủ
    const categoryNames = {
        'all': 'Tất cả',
        'HSK': 'HSK (Tiếng Trung)',
        'TOPIK': 'TOPIK (Tiếng Hàn)',
        'TOEIC': 'TOEIC (Tiếng Anh)',
        'JPN': 'JPN (Tiếng Nhật)'
    };

    /**
     * Load dữ liệu phổ điểm từ API
     */
    function loadPhoDiemData(category) {
        // Hiển thị loading
        document.getElementById('loadingSpinner').style.display = 'block';
        document.getElementById('chartContainer').style.display = 'none';

        // Xác định đường dẫn API (điều chỉnh theo cấu trúc project)
        const apiPath = 'dashboard_manager/api_pho_diem.php'; // Đường dẫn từ thư mục admin/

        // Gọi API (file cùng thư mục với dashboard.php)
        fetch(`${apiPath}?danh_muc=${category}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Kiểm tra nếu có lỗi
                if (data.error || (data.success === false)) {
                    showError(data.error || 'Có lỗi xảy ra khi tải dữ liệu');
                } else {
                    // Có dữ liệu hợp lệ - cập nhật biểu đồ
                    updatePhoDiemChart(data);
                    updateDetailStats(data);
                }
            })
            .catch(error => {
                console.error('Lỗi khi tải dữ liệu:', error);
                showError('Không thể kết nối đến máy chủ. Vui lòng thử lại sau.');
            })
            .finally(() => {
                // Ẩn loading
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('chartContainer').style.display = 'block';
            });
    }

    /**
     * Cập nhật biểu đồ với dữ liệu mới
     */
    function updatePhoDiemChart(data) {
        const ctx = document.getElementById('myChart_phoDiem').getContext('2d');

        // Hủy chart cũ nếu có
        if (chartPhoDiem) {
            chartPhoDiem.destroy();
        }

        // Tạo chart mới
        chartPhoDiem = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: [
                        colors.gioi,
                        colors.kha,
                        colors.trung_binh,
                        colors.yeu
                    ],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12,
                                family: "'Nunito', sans-serif"
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed;
                                let percentage = data.percentages[context.dataIndex];
                                return `${label}: ${value} bài (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true
                }
            }
        });

        // Cập nhật tổng số bài thi
        document.getElementById('totalExams').innerHTML =
            `<i class="fas fa-file-alt mr-1"></i>Tổng: ${data.total} bài thi`;
    }

    /**
     * Cập nhật bảng thống kê chi tiết
     */
    function updateDetailStats(data) {
        const tbody = document.getElementById('statsTableBody');
        tbody.innerHTML = '';

        // Tạo các hàng cho bảng
        data.labels.forEach((label, index) => {
            const row = document.createElement('tr');
            const colorKeys = ['gioi', 'kha', 'trung_binh', 'yeu'];
            const color = colors[colorKeys[index]];

            row.innerHTML = `
            <td>
                <span class="badge" style="background-color: ${color}; color: white;">
                    ${label}
                </span>
            </td>
            <td class="text-center font-weight-bold">${data.data[index]}</td>
            <td class="text-center">${data.percentages[index]}%</td>
        `;
            tbody.appendChild(row);
        });

        // Hiển thị bảng nếu có dữ liệu
        if (data.total > 0) {
            document.getElementById('detailStats').style.display = 'block';
        }
    }

    /**
     * Hiển thị thông báo lỗi
     */
    function showError(message) {
        const container = document.getElementById('chartContainer');
        container.innerHTML = `
        <div class="alert alert-danger text-center" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            ${message}
        </div>
    `;
    }

    /**
     * Thay đổi danh mục
     */
    function changePhoDiemCategory(category, element) {
        currentCategory = category;

        // Cập nhật title
        document.getElementById('chartTitle_phoDiem').innerHTML =
            `<i class="fas fa-chart-pie mr-2"></i>Phổ điểm theo danh mục - ${categoryNames[category]}`;

        // Cập nhật active class cho dropdown
        const dropdownItems = document.querySelectorAll('#dropdownMenuLink_phoDiem + .dropdown-menu .dropdown-item');
        dropdownItems.forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        // Load dữ liệu mới
        loadPhoDiemData(category);
    }

    // ==================== EVENT LISTENERS ====================

    // Khởi tạo khi trang load xong
    document.addEventListener('DOMContentLoaded', function() {
        // Load dữ liệu ban đầu
        loadPhoDiemData('all');
    });

    // Tự động refresh dữ liệu mỗi 5 phút (tùy chọn)
    // setInterval(() => {
    //     loadPhoDiemData(currentCategory);
    // }, 300000); // 300000ms = 5 phút
</script>