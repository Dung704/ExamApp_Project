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
<div class="row">
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_sanPham">
                    5 sản phẩm có trong kho nhiều nhất
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink_sanPham"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink_sanPham">
                        <div class="dropdown-header">Thay đổi sắp xếp:</div>
                        <a class="dropdown-item" href="#" onclick="toggleChartSanPham('nhieu'); return false;">
                            <i class="fas fa-sort-amount-down"></i> Nhiều nhất
                        </a>
                        <a class="dropdown-item" href="#" onclick="toggleChartSanPham('it'); return false;">
                            <i class="fas fa-sort-amount-up"></i> Ít nhất
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="myChart_sanPham" width="600" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_sanPhamSeller">
                    5 sản phẩm bán nhiều nhất
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink_sanPhamSeller"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink_sanPhamSeller">
                        <div class="dropdown-header">Thay đổi sắp xếp:</div>
                        <a class="dropdown-item" href="#" onclick="toggleChartSeller('nhieu'); return false;">
                            <i class="fas fa-sort-amount-down"></i> Nhiều nhất
                        </a>
                        <a class="dropdown-item" href="#" onclick="toggleChartSeller('it'); return false;">
                            <i class="fas fa-sort-amount-up"></i> Ít nhất
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="myChart_sanPhamSeller" width="600" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_loaiSanPhamSeller">
                    5 loại sản phẩm bán nhiều nhất
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink_loaiSanPhamSeller"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink_loaiSanPhamSeller">
                        <div class="dropdown-header">Thay đổi sắp xếp:</div>
                        <a class="dropdown-item" href="#" onclick="toggleChartLoaiSanPhamSeller('nhieu'); return false;">
                            <i class="fas fa-sort-amount-down"></i> Nhiều nhất
                        </a>
                        <a class="dropdown-item" href="#" onclick="toggleChartLoaiSanPhamSeller('it'); return false;">
                            <i class="fas fa-sort-amount-up"></i> Ít nhất
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="myChart_loaiSanPhamSeller" width="600" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_nhaCungCapSeller">
                    5 nhà cung cấp bán nhiều nhất
                </h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink_nhaCungCapSeller"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink_nhaCungCapSeller">
                        <div class="dropdown-header">Thay đổi sắp xếp:</div>
                        <a class="dropdown-item" href="#" onclick="toggleChartnhaCungCapSeller('nhieu'); return false;">
                            <i class="fas fa-sort-amount-down"></i> Nhiều nhất
                        </a>
                        <a class="dropdown-item" href="#" onclick="toggleChartnhaCungCapSeller('it'); return false;">
                            <i class="fas fa-sort-amount-up"></i> Ít nhất
                        </a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="myChart_nhaCungCapSeller" width="600" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_sanphamOnOff_Tien">
                    Tổng Tiền theo nền tảng
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="myChart_sanphamOnOff_Tien" width="600" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary" id="chartTitle_sanphamOnOff_hoaDon_Tien">
                    Tổng hoá đơn theo nền tảng
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <canvas id="myChart_sanphamOnOff_hoaDon" width="600" height="200"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- Top 5 sản phẩm tồn kho ít/nhiều nhất (start) -->
<script>
    // Dữ liệu từ PHP - Chart Tồn Kho
    const dataSource_sanPham = {
        nhieu: {
            labels: <?php echo json_encode($labels_topNhieu_sanPham); ?>,
            data: <?php echo json_encode($data_topNhieu_sanPham); ?>,
            title: '5 sản phẩm có trong kho nhiều nhất'
        },
        it: {
            labels: <?php echo json_encode($labels_topIt_sanPham); ?>,
            data: <?php echo json_encode($data_topIt_sanPham); ?>,
            title: '5 sản phẩm có trong kho ít nhất'
        }
    };

    // Khởi tạo chart Tồn Kho
    const ctx_sanPham = document.getElementById('myChart_sanPham').getContext('2d');
    const myChart_sanPham = new Chart(ctx_sanPham, {
        type: 'bar',
        data: {
            labels: dataSource_sanPham.nhieu.labels,
            datasets: [{
                label: 'Số lượng tồn kho',
                data: dataSource_sanPham.nhieu.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            animation: {
                duration: 750
            }
        }
    });

    // Hàm toggle chart Tồn Kho
    function toggleChartSanPham(type) {
        const source = dataSource_sanPham[type];

        // Update dữ liệu chart
        myChart_sanPham.data.labels = source.labels;
        myChart_sanPham.data.datasets[0].data = source.data;

        // Update tiêu đề
        document.getElementById('chartTitle_sanPham').textContent = source.title;

        // Đổi màu theo loại
        if (type === 'it') {
            myChart_sanPham.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0.2)';
            myChart_sanPham.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
        } else {
            myChart_sanPham.data.datasets[0].backgroundColor = 'rgba(75, 192, 192, 0.2)';
            myChart_sanPham.data.datasets[0].borderColor = 'rgba(75, 192, 192, 1)';
        }
        myChart_sanPham.update();
    }
</script>
<!-- Top 5 sản phẩm tồn kho ít/nhiều nhất (end) -->

<!-- Top 5 sản phẩm bán ít/nhiều nhất (start) -->
<script>
    // Dữ liệu từ PHP - Chart Bán Hàng
    const dataSource_sanPhamSeller = {
        nhieu: {
            labels: <?php echo json_encode($labels_topNhieu_sanPhamSeller); ?>,
            data: <?php echo json_encode($data_topNhieu_sanPhamSeller); ?>,
            title: '5 sản phẩm bán nhiều nhất'
        },
        it: {
            labels: <?php echo json_encode($labels_topIt_sanPhamSeller); ?>,
            data: <?php echo json_encode($data_topIt_sanPhamSeller); ?>,
            title: '5 sản phẩm bán ít nhất'
        }
    };

    // Khởi tạo chart Bán Hàng
    const ctx_sanPhamSeller = document.getElementById('myChart_sanPhamSeller').getContext('2d');
    const myChart_sanPhamSeller = new Chart(ctx_sanPhamSeller, {
        type: 'bar',
        data: {
            labels: dataSource_sanPhamSeller.nhieu.labels,
            datasets: [{
                label: 'Số lượng đã bán',
                data: dataSource_sanPhamSeller.nhieu.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            animation: {
                duration: 750
            }
        }
    });

    // Hàm toggle chart Bán Hàng
    function toggleChartSeller(type) {
        const source = dataSource_sanPhamSeller[type];

        // Update dữ liệu chart
        myChart_sanPhamSeller.data.labels = source.labels;
        myChart_sanPhamSeller.data.datasets[0].data = source.data;

        // Update tiêu đề
        document.getElementById('chartTitle_sanPhamSeller').textContent = source.title;

        // Đổi màu theo loại
        if (type === 'it') {
            myChart_sanPhamSeller.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0.2)';
            myChart_sanPhamSeller.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
        } else {
            myChart_sanPhamSeller.data.datasets[0].backgroundColor = 'rgba(75, 192, 192, 0.2)';
            myChart_sanPhamSeller.data.datasets[0].borderColor = 'rgba(75, 192, 192, 1)';
        }
        myChart_sanPhamSeller.update();
    }
</script>
<!-- Top 5 sản phẩm bán ít/nhiều nhất (end) -->

<!-- Tổng tiền theo nền tảng (start) -->
<script>
    const labels_sanphamOnOff_Tien = <?php echo json_encode($labels_sanphamOnOff_Tien); ?>;
    const data_sanphamOnOff_Tien = <?php echo json_encode($data_sanphamOnOff_Tien); ?>;
    const ctx_sanphamOnOff_Tien = document.getElementById('myChart_sanphamOnOff_Tien').getContext('2d');
    const myChart_sanphamOnOff_Tien = new Chart(ctx_sanphamOnOff_Tien, {
        type: 'bar',
        data: {
            labels: labels_sanphamOnOff_Tien,
            datasets: [{
                label: 'Tổng tiền',
                data: data_sanphamOnOff_Tien,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true

                }
            },
            animation: {
                duration: 750
            }
        }
    });
</script>
<!-- Tổng tiền theo nền tảng (end) -->

<!-- Tổng hoá đơn theo nền tảng (start) -->
<script>
    const labels_sanphamOnOff_hoaDon = <?php echo json_encode($labels_sanphamOnOff_hoaDon); ?>;
    const data_sanphamOnOff_hoaDon = <?php echo json_encode($data_sanphamOnOff_hoaDon); ?>;

    const ctx_sanphamOnOff_hoaDon = document.getElementById('myChart_sanphamOnOff_hoaDon').getContext('2d');
    const myChart_sanphamOnOff_hoaDon = new Chart(ctx_sanphamOnOff_hoaDon, {
        type: 'bar',
        data: {
            labels: labels_sanphamOnOff_hoaDon,
            datasets: [{
                label: 'Số lượng hóa đơn',
                data: data_sanphamOnOff_hoaDon,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // bắt trục Y nhảy 1 đơn vị
                    }
                }
            },
            animation: {
                duration: 750
            }
        }
    });
</script>
<!-- Tổng hoá đơn theo nền tảng (end) -->

<!-- Top 5 loại sản phẩm bán ít/nhiều nhất (start) -->
<script>
    // Dữ liệu từ PHP - Chart Bán Hàng
    const dataSource_loaiSanPhamSeller = {
        nhieu: {
            labels: <?php echo json_encode($labels_topNhieu_loaiSanPhamSeller); ?>,
            data: <?php echo json_encode($data_topNhieu_loaiSanPhamSeller); ?>,
            title: '5 loại sản phẩm bán nhiều nhất'
        },
        it: {
            labels: <?php echo json_encode($labels_topIt_loaiSanPhamSeller); ?>,
            data: <?php echo json_encode($data_topIt_loaiSanPhamSeller); ?>,
            title: '5 loại sản phẩm bán ít nhất'
        }
    };

    // Khởi tạo chart Bán Hàng
    const ctx_loaiSanPhamSeller = document.getElementById('myChart_loaiSanPhamSeller').getContext('2d');
    const myChart_loaiSanPhamSeller = new Chart(ctx_loaiSanPhamSeller, {
        type: 'bar',
        data: {
            labels: dataSource_loaiSanPhamSeller.nhieu.labels,
            datasets: [{
                label: 'Số lượng đã bán',
                data: dataSource_loaiSanPhamSeller.nhieu.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            animation: {
                duration: 750
            }
        }
    });

    // Hàm toggle chart Bán Hàng
    function toggleChartLoaiSanPhamSeller(type) {
        const source = dataSource_loaiSanPhamSeller[type];

        // Update dữ liệu chart
        myChart_loaiSanPhamSeller.data.labels = source.labels;
        myChart_loaiSanPhamSeller.data.datasets[0].data = source.data;

        // Update tiêu đề
        document.getElementById('chartTitle_loaiSanPhamSeller').textContent = source.title;

        // Đổi màu theo loại
        if (type === 'it') {
            myChart_loaiSanPhamSeller.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0.2)';
            myChart_loaiSanPhamSeller.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
        } else {
            myChart_loaiSanPhamSeller.data.datasets[0].backgroundColor = 'rgba(75, 192, 192, 0.2)';
            myChart_loaiSanPhamSeller.data.datasets[0].borderColor = 'rgba(75, 192, 192, 1)';
        }
        myChart_loaiSanPhamSeller.update();
    }
</script>
<!-- Top 5 loại sản phẩm bán ít/nhiều nhất (end) -->

<!-- Top 5 nhà cung cấp bán ít/nhiều nhất (start) -->
<script>
    // Dữ liệu từ PHP - Chart Bán Hàng
    const dataSource_nhaCungCapSeller = {
        nhieu: {
            labels: <?php echo json_encode($labels_topNhieu_nhaCungCapSeller); ?>,
            data: <?php echo json_encode($data_topNhieu_nhaCungCapSeller); ?>,
            title: '5 nhà cung cấp bán nhiều nhất'
        },
        it: {
            labels: <?php echo json_encode($labels_topIt_nhaCungCapSeller); ?>,
            data: <?php echo json_encode($data_topIt_nhaCungCapSeller); ?>,
            title: '5 nhà cung cấp bán ít nhất'
        }
    };

    // Khởi tạo chart Bán Hàng
    const ctx_nhaCungCapSeller = document.getElementById('myChart_nhaCungCapSeller').getContext('2d');
    const myChart_nhaCungCapSeller = new Chart(ctx_nhaCungCapSeller, {
        type: 'bar',
        data: {
            labels: dataSource_nhaCungCapSeller.nhieu.labels,
            datasets: [{
                label: 'Số lượng đã bán',
                data: dataSource_nhaCungCapSeller.nhieu.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            animation: {
                duration: 750
            }
        }
    });

    // Hàm toggle chart Bán Hàng
    function toggleChartnhaCungCapSeller(type) {
        const source = dataSource_nhaCungCapSeller[type];

        // Update dữ liệu chart
        myChart_nhaCungCapSeller.data.labels = source.labels;
        myChart_nhaCungCapSeller.data.datasets[0].data = source.data;

        // Update tiêu đề
        document.getElementById('chartTitle_nhaCungCapSeller').textContent = source.title;

        // Đổi màu theo loại
        if (type === 'it') {
            myChart_nhaCungCapSeller.data.datasets[0].backgroundColor = 'rgba(255, 99, 132, 0.2)';
            myChart_nhaCungCapSeller.data.datasets[0].borderColor = 'rgba(255, 99, 132, 1)';
        } else {
            myChart_nhaCungCapSeller.data.datasets[0].backgroundColor = 'rgba(75, 192, 192, 0.2)';
            myChart_nhaCungCapSeller.data.datasets[0].borderColor = 'rgba(75, 192, 192, 1)';
        }
        myChart_nhaCungCapSeller.update();
    }
</script>
<!-- Top 5 nhà cung cấp bán ít/nhiều nhất (end) -->
<!-- Doanh thu theo giờ/ngày/tháng (start) -->
<script>
    // Dữ liệu từ PHP - Doanh thu theo thời gian
    const dataSource_doanhThu = {
        gio: {
            labels: <?php echo json_encode($labels_doanhThu_gio); ?>,
            data: <?php echo json_encode($data_doanhThu_gio); ?>,
            title: 'Doanh thu theo giờ (Hôm nay)',
            labelText: 'Theo giờ',
            xAxisLabel: 'Giờ'
        },
        ngay: {
            labels: <?php echo json_encode($labels_doanhThu_ngay); ?>,
            data: <?php echo json_encode($data_doanhThu_ngay); ?>,
            title: 'Doanh thu theo ngày (Tháng <?php echo date("m/Y"); ?>)',
            labelText: 'Theo ngày',
            xAxisLabel: 'Ngày'
        },
        thang: {
            labels: <?php echo json_encode($labels_doanhThu_thang); ?>,
            data: <?php echo json_encode($data_doanhThu_thang); ?>,
            title: 'Doanh thu theo tháng (Năm <?php echo date("Y"); ?>)',
            labelText: 'Theo tháng',
            xAxisLabel: 'Tháng'
        }
    };

    // Biến lưu trạng thái hiện tại
    let currentTimeFilter_doanhThu = 'gio';

    // Khởi tạo chart
    const ctx_doanhThu = document.getElementById('myChart_doanhThu').getContext('2d');
    const myChart_doanhThu = new Chart(ctx_doanhThu, {
        type: 'line',
        data: {
            labels: dataSource_doanhThu.gio.labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: dataSource_doanhThu.gio.data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: dataSource_doanhThu.gio.xAxisLabel
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + context.parsed.y.toLocaleString('vi-VN') + ' đ';
                        }
                    }
                },
                legend: {
                    display: true
                }
            },
            animation: {
                duration: 750
            }
        }
    });

    // Hàm thay đổi bộ lọc thời gian
    function changeTimeFilter_doanhThu(timeType) {
        currentTimeFilter_doanhThu = timeType;

        const source = dataSource_doanhThu[timeType];

        // Update dữ liệu chart
        myChart_doanhThu.data.labels = source.labels;
        myChart_doanhThu.data.datasets[0].data = source.data;

        // Update tiêu đề
        document.getElementById('chartTitle_doanhThu').textContent = source.title;

        // Update label thời gian
        document.getElementById('timeLabel_doanhThu').textContent = source.labelText;

        // Update label trục X
        myChart_doanhThu.options.scales.x.title.text = source.xAxisLabel;

        myChart_doanhThu.update();
    }
</script>
<!-- Doanh thu theo giờ/ngày/tháng (end) -->