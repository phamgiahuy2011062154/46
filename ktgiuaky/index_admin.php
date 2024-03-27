<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THÔNG TIN NHÂN VIÊN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            padding-top: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .pagination {
            margin-bottom: 20px;
        }

        .pagination a {
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        .action-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 5px;
        }

        .action-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>THÔNG TIN NHÂN VIÊN</h1>

        <!-- Thêm các nút chức năng -->
        <div style="margin-bottom: 10px;">
            <a href="themnhanvien.php" class="action-btn">Thêm nhân viên</a>
            <a href="xoanhanvien.php" class="action-btn">Xóa nhân viên</a>
            <a href="suanhanvien.php" class="action-btn">Sửa thông tin nhân viên</a>
        </div>

        <table>
            <tr>
                <th>Mã Nhân Viên</th>
                <th>Tên Nhân Viên</th>
                <th>Giới tính</th>
                <th>Nơi Sinh</th>
                <th>Tên Phòng</th>
                <th>Lương</th>
            </tr>
            <?php
            include ('nhanvien.php');
            $soNhanVienTrenTrang = 5; // Số nhân viên trên mỗi trang
            $page = isset ($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại, mặc định là trang 1
            
            // Tính vị trí bắt đầu của kết quả (dòng bắt đầu)
            $start = ($page - 1) * $soNhanVienTrenTrang;

            // Truy vấn SQL sẽ chỉ lấy ra số nhân viên cần hiển thị trên trang hiện tại
            $sql = "SELECT * FROM nhanvien LIMIT $start, $soNhanVienTrenTrang";

            // Thực thi truy vấn SQL
            $nhanvien = $conn->query($sql);

            while ($row = $nhanvien->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <?php echo $row['Ma_NV']; ?>
                    </td>
                    <td>
                        <?php echo $row['Ten_NV']; ?>
                    </td>
                    <td>
                        <?php if ($row['Phai'] === 'NAM'): ?>
                            <img src="man.jpg" alt="Nam" width="20" height="20">
                        <?php else: ?>
                            <img src="woman.jpg" alt="Nu" width="20" height="20">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $row['Noi_Sinh']; ?>
                    </td>
                    <td>
                        <?php echo $row['Ma_Phong']; ?>
                    </td>
                    <td>
                        <?php echo number_format($row['Luong'], 0, ',', '.'); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div class="pagination">
            <?php
            // Truy vấn SQL để tính tổng số nhân viên
            $totalNhanVien = $conn->query("SELECT COUNT(*) AS total FROM nhanvien")->fetch_assoc()['total'];
            // Tính tổng số trang
            $totalPages = ceil($totalNhanVien / $soNhanVienTrenTrang);

            // Hiển thị các liên kết phân trang
            for ($i = 1; $i <= $totalPages; $i++) {
                $activeClass = ($i == $page) ? "active" : "";
                echo "<a href='?page=$i' class='$activeClass'>$i</a> ";
            }
            ?>
        </div>
    </div>
</body>

</html>