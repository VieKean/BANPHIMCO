<!-- Bảng hiển thị thông tin chung -->
<table class="main-table">
    <thead>
        <tr>
            <th>Mã Đơn Hàng</th>
            <th>Khách Hàng</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Phương Thức Thanh Toán</th>
            <th>Trạng Thái Đơn</th>
            <th>Tổng Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['madonhang'])) {
            $madon = $_GET['madonhang'];
            $result = layCTDH($conn, $madon);
            $row = mysqli_fetch_array($result);
        ?>
            <tr>
                <td><?php echo $row['madonhang'] ?></td>
                <td><?php echo $row['hoten'] ?></td>
                <td><?php echo $row['sodienthoai'] ?></td>
                <td><?php echo $row['diachi'] ?></td>
                <td><?php echo $row['phuongthucthanhtoan'] ?></td>
                <td><?php echo $row['trangthai'] ?></td>
                <td><?php echo number_format($row['tonggia']). " vnd" ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<!-- Bảng hiển thị chi tiết sản phẩm -->
<table class="detail-table">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên Sản Phẩm</th>
            <th>Loại Hàng</th>
            <th>Số Lượng</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($_GET['madonhang'])) {
            $madon = $_GET['madonhang'];
            $result = layCTDH($conn, $madon);
            $i = 1;
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row['tensanpham'] ?></td>
                    <td><?php echo $row['tenloai'] ?></td>
                    <td><?php echo $row['soluong'] ?></td>
                    <td><?php echo number_format($row['gia'] * $row['soluong'] ). " vnd"?></td>
                </tr>
        <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>