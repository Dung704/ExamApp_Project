<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container-404 {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
        }

        .error-code {
            font-size: 10rem;
            font-weight: bold;
            color: #6c757d;
            line-height: 1;
            margin-bottom: 1rem;
        }

        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 1rem;
        }

        .error-description {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .btn-home {
            background: #007bff;
            color: white;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-home:hover {
            background: #0056b3;
            color: white;
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-description {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-404">
        <div class="error-code">404</div>

        <h1 class="error-title">Không tìm thấy trang</h1>

        <p class="error-description">
            Trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.
        </p>

        <a href="/" class="btn-home">Về trang chủ</a>
    </div>
</body>

</html>