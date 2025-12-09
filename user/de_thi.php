<?php
include("./header.php");
?>

<div class="container my-5">
    <div class="row">
        <!-- Phần trái: danh sách bài kiểm tra -->
        <div class="col-lg-8 mb-4">
            <h4 class="mb-3">📚 Danh sách bài kiểm tra</h4>

            <!-- Hàng 1 -->
            <div class="mb-4">
                <h5 class="mb-2">HSK 1</h5>
                <div class="d-flex flex-row overflow-auto gap-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="card shadow-sm" style="min-width: 250px;">
                        <div class="card-body">
                            <h5 class="card-title">Test <?= $i ?> 🐼</h5>
                            <p class="card-text mb-1">📝 Số câu: 40</p>
                            <p class="card-text mb-1">⏱️ Thời gian: 40 phút</p>
                            <p class="card-text mb-2">🎧 Kỹ năng: Nghe, Đọc</p>
                            <a href="#" class="btn btn-primary">Bắt đầu</a>
                            <?php if ($i >= 3): ?>
                            <i class="bi bi-award text-warning ms-2"></i>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Hàng 2 -->
            <div class="mb-4">
                <h5 class="mb-2">HSK 2</h5>
                <div class="d-flex flex-row overflow-auto gap-3">
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                    <div class="card shadow-sm" style="min-width: 250px;">
                        <div class="card-body">
                            <h5 class="card-title">Test <?= $i ?> 🐼</h5>
                            <p class="card-text mb-1">📝 Số câu: 40</p>
                            <p class="card-text mb-1">⏱️ Thời gian: 40 phút</p>
                            <p class="card-text mb-2">🎧 Kỹ năng: Nghe, Đọc</p>
                            <a href="#" class="btn btn-primary">Bắt đầu</a>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Hàng 3 -->
            <div class="mb-4">
                <h5 class="mb-2">TOCFL - Novice</h5>
                <div class="d-flex flex-row overflow-auto gap-3">
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                    <div class="card shadow-sm" style="min-width: 250px;">
                        <div class="card-body">
                            <h5 class="card-title">Test <?= $i ?> 🐼</h5>
                            <p class="card-text mb-1">📝 Số câu: 50</p>
                            <p class="card-text mb-1">⏱️ Thời gian: 50 phút</p>
                            <p class="card-text mb-2">🎧 Kỹ năng: Nghe, Đọc</p>
                            <a href="#" class="btn btn-success">Bắt đầu</a>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Hàng 4 -->
            <div class="mb-4">
                <h5 class="mb-2">TOCFL - Band A</h5>
                <div class="d-flex flex-row overflow-auto gap-3">
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                    <div class="card shadow-sm" style="min-width: 250px;">
                        <div class="card-body">
                            <h5 class="card-title">Test <?= $i ?> 🐼</h5>
                            <p class="card-text mb-1">📝 Số câu: 50</p>
                            <p class="card-text mb-1">⏱️ Thời gian: 50 phút</p>
                            <p class="card-text mb-2">🎧 Kỹ năng: Nghe, Đọc</p>
                            <a href="#" class="btn btn-success">Bắt đầu</a>
                            <i class="bi bi-award text-warning ms-2"></i>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- Phần phải: bảng xếp hạng -->
        <div class="col-lg-4 mb-4">
            <h4 class="mb-3">🏆 Bảng Xếp Hạng</h4>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Điểm</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td><i class="bi bi-award text-warning me-1"></i> Nguyễn Văn A</td>
                                <td>980</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Trần Thị B</td>
                                <td>920</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Phạm Minh C</td>
                                <td>890</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Lê Quốc D</td>
                                <td>860</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Hoàng Lan E</td>
                                <td>830</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
include("./footer.php");
?>