<?php

/**
 * API Phổ Điểm Theo Danh Mục (Tính theo % thang điểm)
 * File: admin/dashboard_manager/api_pho_diem.php
 */

// Bật error reporting để debug (tắt trong production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Không hiển thị lỗi ra màn hình
ini_set('log_errors', 1);

// Bắt đầu output buffering để tránh lỗi header
ob_start();

// Include file kết nối database
// File api_pho_diem.php đang ở: admin/dashboard_manager/
// File config.php đang ở: admin/_includes/
require_once '../_includes/config.php';

/**
 * CẤU HÌNH PHÂN LOẠI THEO % THANG ĐIỂM
 * Áp dụng cho tất cả các danh mục đề thi
 */
$phan_loai_theo_phan_tram = [
    'gioi' => [
        'min_percent' => 80,  // >= 80% tổng điểm
        'max_percent' => 100,
        'label' => 'Giỏi'
    ],
    'kha' => [
        'min_percent' => 60,  // >= 60% và < 80%
        'max_percent' => 79.99,
        'label' => 'Khá'
    ],
    'trung_binh' => [
        'min_percent' => 40,  // >= 40% và < 60%
        'max_percent' => 59.99,
        'label' => 'Trung bình'
    ],
    'yeu' => [
        'min_percent' => 0,   // < 40%
        'max_percent' => 39.99,
        'label' => 'Yếu'
    ]
];

/**
 * HÀM TÍNH % ĐIỂM DỰA TRÊN THANG ĐIỂM CỦA ĐỀ THI
 */
function tinhPhanTramDiem($diem_so, $thang_diem)
{
    if ($thang_diem <= 0) return 0;
    return ($diem_so / $thang_diem) * 100;
}

/**
 * HÀM PHÂN LOẠI DỰA TRÊN % ĐIỂM
 */
function phanLoaiTheoPhanTram($phan_tram, $phan_loai_config)
{
    foreach ($phan_loai_config as $xep_loai => $config) {
        if ($phan_tram >= $config['min_percent'] && $phan_tram <= $config['max_percent']) {
            return $xep_loai;
        }
    }
    return 'yeu'; // Mặc định
}

try {
    // Lấy tham số danh mục từ GET request
    $danh_muc = isset($_GET['danh_muc']) ? trim($_GET['danh_muc']) : 'all';

    // Khởi tạo mảng data mặc định
    $data = [
        'gioi' => 0,
        'kha' => 0,
        'trung_binh' => 0,
        'yeu' => 0
    ];

    $labels = [];

    if ($danh_muc === 'all') {
        // ====== TRƯỜNG HỢP 1: Lấy tổng hợp tất cả danh mục ======

        // Query lấy điểm và thang điểm của tất cả đề thi
        $sql = "SELECT 
                    kq.diem_so,
                    dt.thang_diem,
                    dm.ten_danh_muc
                FROM ket_qua_thi kq
                JOIN de_thi dt ON kq.id_de_thi = dt.id
                LEFT JOIN danh_muc_de_thi dm ON dt.id_danh_muc = dm.id";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $diem_so = (float)$row['diem_so'];
                $thang_diem = (float)$row['thang_diem'];

                // Tính % điểm
                $phan_tram = tinhPhanTramDiem($diem_so, $thang_diem);

                // Phân loại
                $xep_loai = phanLoaiTheoPhanTram($phan_tram, $phan_loai_theo_phan_tram);
                $data[$xep_loai]++;
            }
        }

        // Labels đơn giản cho "Tất cả" (không hiện % hay điểm)
        $labels = [
            'Giỏi',
            'Khá',
            'Trung bình',
            'Yếu'
        ];
    } else {
        // ====== TRƯỜNG HỢP 2: Lấy theo danh mục cụ thể ======

        // Bước 1: Lấy thang điểm của danh mục này (lấy từ đề thi đầu tiên)
        $sql_thang_diem = "SELECT dt.thang_diem
                           FROM de_thi dt
                           JOIN danh_muc_de_thi dm ON dt.id_danh_muc = dm.id
                           WHERE dm.ten_danh_muc = ?
                           LIMIT 1";

        $stmt_thang = mysqli_prepare($conn, $sql_thang_diem);
        $thang_diem_danh_muc = 10; // Mặc định

        if ($stmt_thang) {
            mysqli_stmt_bind_param($stmt_thang, 's', $danh_muc);
            mysqli_stmt_execute($stmt_thang);
            $result_thang = mysqli_stmt_get_result($stmt_thang);
            if ($row_thang = mysqli_fetch_assoc($result_thang)) {
                $thang_diem_danh_muc = (float)$row_thang['thang_diem'];
            }
            mysqli_stmt_close($stmt_thang);
        }

        // Bước 2: Query lấy điểm và thang điểm của danh mục cụ thể
        $sql = "SELECT 
                    kq.diem_so,
                    dt.thang_diem
                FROM ket_qua_thi kq
                JOIN de_thi dt ON kq.id_de_thi = dt.id
                JOIN danh_muc_de_thi dm ON dt.id_danh_muc = dm.id
                WHERE dm.ten_danh_muc = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $danh_muc);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Phân loại từng điểm số
            while ($row = mysqli_fetch_assoc($result)) {
                $diem_so = (float)$row['diem_so'];
                $thang_diem = (float)$row['thang_diem'];

                // Tính % điểm
                $phan_tram = tinhPhanTramDiem($diem_so, $thang_diem);

                // Phân loại theo %
                $xep_loai = phanLoaiTheoPhanTram($phan_tram, $phan_loai_theo_phan_tram);
                $data[$xep_loai]++;
            }

            mysqli_stmt_close($stmt);
        }

        // Bước 3: Tính mức điểm tương ứng với % cho danh mục này
        $diem_gioi_min = round($thang_diem_danh_muc * 0.8);        // 80%
        $diem_kha_min = round($thang_diem_danh_muc * 0.6);         // 60%
        $diem_kha_max = round($thang_diem_danh_muc * 0.7999);      // 79.99%
        $diem_tb_min = round($thang_diem_danh_muc * 0.4);          // 40%
        $diem_tb_max = round($thang_diem_danh_muc * 0.5999);       // 59.99%
        $diem_yeu_max = round($thang_diem_danh_muc * 0.3999);      // 39.99%

        // Tạo labels với mức điểm thực tế
        $labels = [
            'Giỏi (' . $diem_gioi_min . '-' . $thang_diem_danh_muc . ' điểm)',
            'Khá (' . $diem_kha_min . '-' . $diem_kha_max . ' điểm)',
            'Trung bình (' . $diem_tb_min . '-' . $diem_tb_max . ' điểm)',
            'Yếu (0-' . $diem_yeu_max . ' điểm)'
        ];
    }

    // Tính tổng số bài thi
    $tong = array_sum($data);

    // Tính phần trăm cho từng xếp loại (số lượng bài thi)
    $percentages = [0, 0, 0, 0];
    if ($tong > 0) {
        $percentages = array_map(function ($val) use ($tong) {
            return round(($val / $tong) * 100, 2);
        }, array_values($data));
    }

    // Chuẩn bị response
    $response = [
        'success' => true,
        'labels' => $labels,
        'data' => array_values($data),
        'total' => $tong,
        'percentages' => $percentages,
        'category' => $danh_muc,
        'classification_info' => [
            'type' => 'percentage_based',
            'description' => 'Phân loại dựa trên % thang điểm của đề thi',
            'ranges' => [
                'gioi' => '≥80% thang điểm',
                'kha' => '60-79% thang điểm',
                'trung_binh' => '40-59% thang điểm',
                'yeu' => '<40% thang điểm'
            ]
        ]
    ];

    // Debug log (có thể bỏ sau khi hoạt động tốt)
    error_log("API Response: " . json_encode($response));
} catch (Exception $e) {
    // Xử lý lỗi
    $response = [
        'success' => false,
        'error' => $e->getMessage(),
        'labels' => [],
        'data' => [0, 0, 0, 0],
        'total' => 0,
        'percentages' => [0, 0, 0, 0]
    ];
}

// Xóa output buffer và gửi response JSON
ob_end_clean();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit;
