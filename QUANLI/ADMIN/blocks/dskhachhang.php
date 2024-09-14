<div id="filterDate-container">
    <label for="ngaytao">Ngày tạo:</label>
    <input type="date" id="ngaytao" name="ngaytao">
    <button onclick="filterCustomersByDate()">Lọc</button>
</div>

<style>
    #filterDate-container {
        float: right;
        padding: 0 50px 10px 0;
    }

    #filterDate-container input[type='date'] {
        margin: 0 4px;
        height: 24px;
        line-height: 24px;
    }

    #filterDate-container button {
        padding: 2px 5px;
        color: #fff;
        background-color: #254753;
        border: thin solid #254753;
        cursor: pointer;
        min-height: 24px;
    }

    #filterDate-container button:hover {
        color: #254753;
        background-color: #fff;
        border: thin solid #254753;
    }

    .btn-pagination {
        margin-top: 10px;
    }

    .btn-pagination a {
        display: inline-block;
        padding: 8px 12px;
        background-color: #f2f2f2;
        color: #333;
        text-decoration: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-right: 5px;
    }

    .btn-pagination a.active {
        background-color: var(--main_color);
        color: white;
    }
</style>

<table class="main-table">
    <thead>
        <tr>
            <td>STT</td>
            <td>Mã Khách Hàng</td>
            <td>Tên Đăng Nhập</td>
            <td>Họ Tên</td>
            <td>Ngày Sinh</td>
            <td>Giới Tính</td>
            <td>Địa Chỉ</td>
            <td>Số Điện Thoại</td>
            <td>Email</td>
            <td>Ngày Tạo</td>
        </tr>
    </thead>
    <tbody>
        <?php
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "banphimco");

        // Số lượng khách hàng mỗi trang
        $items_per_page = 3;

        // Lấy số trang hiện tại, mặc định là 1
        $npage = isset($_GET['npage']) && $_GET['npage'] > 0 ? (int)$_GET['npage'] : 1;

        $offset = max(0, ($npage - 1) * $items_per_page);

        // Add filters if set
        $date_filter = "";
        if (isset($_GET['ngaytao']) && !empty($_GET['ngaytao'])) {
            $selectedDate = $_GET['ngaytao'];
            $date_filter = " WHERE DATE(ngaytao) = '$selectedDate'";
        }

        // Đếm tổng số khách hàng
        $total_query = "SELECT COUNT(*) as total FROM khachhang" . $date_filter;
        $total_result = mysqli_query($conn, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total_customers = $total_row['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_customers / $items_per_page);

        // Fetch the data with the applied filter and pagination
        $sql = "SELECT * FROM khachhang" . $date_filter . " ORDER BY ngaytao DESC LIMIT $items_per_page OFFSET $offset";
        $result = mysqli_query($conn, $sql);

        $i = $offset + 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>
                    <td>{$i}</td>
                    <td>{$row['makhachhang']}</td>
                    <td>{$row['tendangnhap']}</td>
                    <td>{$row['hoten']}</td>
                    <td>{$row['ngaysinh']}</td>
                    <td>{$row['gioitinh']}</td>
                    <td>{$row['diachi']}</td>
                    <td>{$row['sodienthoai']}</td>
                    <td>{$row['email']}</td>
                    <td>" . date('d/m/Y', strtotime($row['ngaytao'])) . "</td>
                </tr>";
            $i++;
        }
        ?>
    </tbody>
</table>

<div class="btn-pagination">
    <?php if ($npage > 1) : ?>
        <a href="?page=dskhachhang&npage=1<?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?>"><i class="fa-solid fa-angles-left"></i></a>
        <a href="?page=dskhachhang&npage=<?php echo $npage - 1; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?>"><i class="fa-solid fa-angle-left"></i></a>
    <?php endif; ?>

    <?php for ($p = 1; $p <= $total_pages; $p++) : ?>
        <a href="?page=dskhachhang&npage=<?php echo $p; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?>" class="<?php if ($p == $npage) echo 'active'; ?>"><?php echo $p; ?></a>
    <?php endfor; ?>

    <?php if ($npage < $total_pages) : ?>
        <a href="?page=dskhachhang&npage=<?php echo $npage + 1; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?>"><i class="fa-solid fa-angle-right"></i></a>
        <a href="?page=dskhachhang&npage=<?php echo $total_pages; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?>"><i class="fa-solid fa-angles-right"></i></a>
    <?php endif; ?>
</div>

<script>
    function filterCustomersByDate() {
        var selectedDate = document.getElementById("ngaytao").value;
        var url = 'index.php?page=dskhachhang';

        if (selectedDate) {
            url += '&ngaytao=' + selectedDate;
        }
        window.location.href = url;
    }
</script>
