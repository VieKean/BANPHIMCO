<link rel="stylesheet" href="css/captaikhoan.css">
<div class="filterRole-container">
    <div>
        <a id="captk" href="?page=captaikhoan">Cấp Tài Khoản</a>
    </div>
    <div>
        <div id='left-fl'>
            <label for="ngaytao">Ngày tạo:</label>
            <input type="date" id="ngaytao" name="ngaytao"> <br>
            <label for="quyen">Quyền:</label>
            <select id="quyen" name="quyen">
                <option value="">Tất cả</option>
                <option value="1">Admin</option>
                <option value="0">User</option>
            </select>
            <button onclick="filterAccounts()">Lọc</button>
        </div>
    </div>
</div>

<table class="main-table">
    <thead>
        <tr>
            <td>STT</td>
            <td class="matk">Mã TK</td>
            <td class="tendangnhap">Tài Khoản</td>
            <td class="hoten">Họ Tên</td>
            <td class="diachi">Địa Chỉ</td>
            <td class="sdt">SĐT</td>
            <td class="email">Email</td>
            <td class="quyen">Quyền</td>
            <td class="ngaytao">Ngày Tạo</td>
        </tr>
    </thead>
    <tbody>
    <?php
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "banphimco");

    // Số lượng tài khoản mỗi trang
    $items_per_page = 3;

    // Lấy số trang hiện tại, mặc định là 1
    $npage = isset($_GET['npage']) && $_GET['npage'] > 0 ? (int)$_GET['npage'] : 1;

    $offset = max(0, ($npage - 1) * $items_per_page);

    // Base SQL query
    $sql = "SELECT * FROM taikhoan";

    // Add filters if set
    $conditions = [];
    if (isset($_GET['ngaytao']) && !empty($_GET['ngaytao'])) {
        $selectedDate = $_GET['ngaytao'];
        $conditions[] = "DATE(ngaytao) = '$selectedDate'";
    }

    if (isset($_GET['quyen']) && !empty($_GET['quyen'])) {
        $selectedRole = $_GET['quyen'];
        $conditions[] = "quyen = '$selectedRole'";
    }
    
    // Add condition for the "User" role
    if (isset($_GET['quyen']) && $_GET['quyen'] === '0') {
        $conditions[] = "quyen = '0'";
    }

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Count total records
    $count_sql = "SELECT COUNT(*) as total FROM taikhoan" . (count($conditions) > 0 ? " WHERE " . implode(" AND ", $conditions) : "");
    $total_result = mysqli_query($conn, $count_sql);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_accounts = $total_row['total'];

    // Add ordering and pagination to SQL query
    $sql .= " ORDER BY mataikhoan DESC LIMIT $items_per_page OFFSET $offset";
    $result = mysqli_query($conn, $sql);

    $i = $offset + 1;
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>
                <td>{$i}</td>
                <td class='matk'>{$row['mataikhoan']}</td>
                <td class='tendangnhap'>{$row['tendangnhap']}</td>
                <td class='hoten'>{$row['hoten']}</td>
                <td class='diachi'>{$row['diachi']}</td>
                <td class='sdt'>{$row['sodienthoai']}</td>
                <td class='email'>{$row['email']}</td>
                <td class='quyen'>" . ($row['quyen'] == 1 ? 'Admin' : 'User') . "</td>
                <td class='ngaytao'>" . date('d/m/Y', strtotime($row['ngaytao'])) . "</td>
              </tr>";
        $i++;
    }
    ?>
    </tbody>
</table>

<div class="btn-pagination">
    <?php if ($npage > 1): ?>
        <a href="?page=dstaikhoan&npage=1<?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?><?php echo isset($selectedRole) ? '&quyen=' . $selectedRole : ''; ?>"><i class="fa-solid fa-angles-left"></i></a>
        <a href="?page=dstaikhoan&npage=<?php echo $npage - 1; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?><?php echo isset($selectedRole) ? '&quyen=' . $selectedRole : ''; ?>"><i class="fa-solid fa-angle-left"></i></a>
    <?php endif; ?>

    <?php for ($p = 1; $p <= ceil($total_accounts / $items_per_page); $p++): ?>
        <a href="?page=dstaikhoan&npage=<?php echo $p; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?><?php echo isset($selectedRole) ? '&quyen=' . $selectedRole : ''; ?>" class="<?php if ($p == $npage) echo 'active'; ?>"><?php echo $p; ?></a>
    <?php endfor; ?>

    <?php if ($npage < ceil($total_accounts / $items_per_page)): ?>
        <a href="?page=dstaikhoan&npage=<?php echo $npage + 1; ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?><?php echo isset($selectedRole) ? '&quyen=' . $selectedRole : ''; ?>"><i class="fa-solid fa-angle-right"></i></a>
        <a href="?page=dstaikhoan&npage=<?php echo ceil($total_accounts / $items_per_page); ?><?php echo isset($selectedDate) ? '&ngaytao=' . $selectedDate : ''; ?><?php echo isset($selectedRole) ? '&quyen=' . $selectedRole : ''; ?>"><i class="fa-solid fa-angles-right"></i></a>
    <?php endif; ?>
</div>

<script>
    function filterAccounts() {
        var selectedDate = document.getElementById("ngaytao").value;
        var selectedRole = document.getElementById("quyen").value;

        // Chuyển hướng đến trang với tham số ngaytao và quyen được chọn
        var url = 'index.php?page=dstaikhoan';

        if (selectedDate) {
            url += '&ngaytao=' + selectedDate;
        }

        if (selectedRole) {
            url += '&quyen=' + selectedRole;
        }

        window.location.href = url;
    }
</script>
