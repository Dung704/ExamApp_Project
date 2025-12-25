<?php

/**
 * API Phổ Điểm Theo Danh Mục
 * File: admin/api/api_pho_diem.php
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

// Định nghĩa mức điểm cho từng danh mục chứng chỉ
$muc_diem = [
    'HSK' => [
        'gioi' => ['min' => 180, 'max' => 300, 'label' => 'Giỏi (180-300)'],
        'kha' => ['min' => 120, 'max' => 179, 'label' => 'Khá (120-179)'],
        'trung_binh' => ['min' => 60, 'max' => 119, 'label' => 'Trung bình (60-119)'],
        'yeu' => ['min' => 0, 'max' => 59, 'label' => 'Yếu (0-59)']
    ],
    'TOPIK' => [
        'gioi' => ['min' => 240, 'max' => 300, 'label' => 'Giỏi (240-300)'],
        'kha' => ['min' => 150, 'max' => 239, 'label' => 'Khá (150-239)'],
        'trung_binh' => ['min' => 80, 'max' => 149, 'label' => 'Trung bình (80-149)'],
        'yeu' => ['min' => 0, 'max' => 79, 'label' => 'Yếu (0-79)']
    ],
    'TOEIC' => [
        'gioi' => ['min' => 800, 'max' => 990, 'label' => 'Giỏi (800-990)'],
        'kha' => ['min' => 600, 'max' => 799, 'label' => 'Khá (600-799)'],
        'trung_binh' => ['min' => 400, 'max' => 599, 'label' => 'Trung bình (400-599)'],
        'yeu' => ['min' => 0, 'max' => 399, 'label' => 'Yếu (0-399)']
    ],
    'JPN' => [
        'gioi' => ['min' => 8, 'max' => 10, 'label' => 'Giỏi (8-10)'],
        'kha' => ['min' => 6.5, 'max' => 7.9, 'label' => 'Khá (6.5-7.9)'],
        'trung_binh' => ['min' => 5, 'max' => 6.4, 'label' => 'Trung bình (5-6.4)'],
        'yeu' => ['min' => 0, 'max' => 4.9, 'label' => 'Yếu (0-4.9)']
    ]
];

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
        // Sử dụng thang điểm 10 (chuẩn)

        $sql = "SELECT 
                    CASE 
                        WHEN kq.diem_so >= 8 THEN 'gioi'
                        WHEN kq.diem_so >= 6.5 THEN 'kha'
                        WHEN kq.diem_so >= 5 THEN 'trung_binh'
                        ELSE 'yeu'
                    END as xep_loai,
                    COUNT(*) as so_luong
                FROM ket_qua_thi kq
                GROUP BY xep_loai";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[$row['xep_loai']] = (int)$row['so_luong'];
            }
        }

        $labels = ['Giỏi (8-10)', 'Khá (6.5-7.9)', 'Trung bình (5-6.4)', 'Yếu (0-4.9)'];
    } else {
        // ====== TRƯỜNG HỢP 2: Lấy theo danh mục cụ thể ======

        // Kiểm tra danh mục có hợp lệ không
        if (!isset($muc_diem[$danh_muc])) {
            throw new Exception('Danh mục không hợp lệ');
        }

        // Query lấy tất cả điểm số của danh mục
        $sql = "SELECT kq.diem_so
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
                $diem = (float)$row['diem_so'];

                // Kiểm tra điểm thuộc xếp loại nào
                foreach ($muc_diem[$danh_muc] as $xep_loai => $thong_tin) {
                    if ($diem >= $thong_tin['min'] && $diem <= $thong_tin['max']) {
                        $data[$xep_loai]++;
                        break;
                    }
                }
            }

            mysqli_stmt_close($stmt);
        }

        // Lấy labels từ cấu hình mức điểm
        $labels = array_column($muc_diem[$danh_muc], 'label');
    }

    // Tính tổng số bài thi
    $tong = array_sum($data);

    // Tính phần trăm cho từng xếp loại
    $percentages = [0, 0, 0, 0];
    if ($tong > 0) {
        $percentages = array_map(function ($val) use ($tong) {
            return round(($val / $tong) * 100, 2);
        }, array_values($data));
    }

    // Chuẩn bị response - LUÔN LUÔN có field success
    $response = [
        'success' => true,
        'labels' => $labels,
        'data' => array_values($data),
        'total' => $tong,
        'percentages' => $percentages,
        'category' => $danh_muc
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
