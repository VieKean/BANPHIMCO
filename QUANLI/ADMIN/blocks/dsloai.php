<form method="post">
    <button name="submit" type="submit" id="themLoai"><a href="?page=themloai">Thêm Loại</a></button>
</form>
<table class="main-table">
    <thead>
        <tr>
            <td>STT</td>
            <td>Mã Loại</td>
            <td>Tên Loại</td>
            <td>Cập Nhật</td>
        </tr>
    </thead>
    <tbody>
    <?php
    $result = layLoai($conn);

    $num = mysqli_num_rows($result);
    // Số lượng sản phẩm 1 trang
    $numberPerPage = 5;
    $totalPages = ceil($num / $numberPerPage);
    
    // Xác định trang hiện tại
    $currentPage = isset($_GET['npage']) ? max(1, min($_GET['npage'], $totalPages)) : 1;
    $startingLimit = ($currentPage - 1) * $numberPerPage;

    // Query dữ liệu cho trang hiện tại và sắp xếp theo mã loại giảm dần
    $sql = "SELECT * FROM loai ORDER BY maloai DESC LIMIT $startingLimit, $numberPerPage";
    $result = mysqli_query($conn, $sql);

    // STT ban đầu
    $initialIndex = $startingLimit + 1;
    
    while ($row = mysqli_fetch_array($result)) {
    ?>
        <tr>
            <td><?php echo $initialIndex ?></td>
            <td><?php echo "L00" . $row['maloai'] ?></td>
            <td><?php echo $row['tenloai'] ?></td>
            <td><a href="?page=capnhatloai&maloai=<?php echo $row['maloai'] ?>" class="fa-solid fa-screwdriver-wrench"></a></td>
        </tr>
    <?php 
        $initialIndex++;
    }
    ?>
    </tbody>
</table>

<div class="btn-pagination">
    <?php if ($currentPage > 1): ?>
        <a href="?page=dsloai&npage=1"><i class="fa-solid fa-angles-left"></i></a>
        <a href="?page=dsloai&npage=<?php echo $currentPage - 1; ?>"><i class="fa-solid fa-angle-left"></i></a>
    <?php endif; ?>

    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
        <a href="?page=dsloai&npage=<?php echo $page; ?>" class="<?php echo ($page == $currentPage) ? 'active' : ''; ?>"><?php echo $page; ?></a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=dsloai&npage=<?php echo $currentPage + 1; ?>"><i class="fa-solid fa-angle-right"></i></a>
        <a href="?page=dsloai&npage=<?php echo $totalPages; ?>"><i class="fa-solid fa-angles-right"></i></a>
    <?php endif; ?>
</div>


<style>
    #themLoai {
        height: 50px;
        width: 140px;
        background-color: var(--main_color);
        border: none;
        border-radius: 30px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
    }

    #themLoai a {
        text-decoration: none;
        color: white;
        font-size: 15px;
        transition: 0.3s;
    }

    #themLoai:hover {
        background-color: #fff;
        border: 1px solid var(--main_color);
        transition: 0.3s;
    }

    #themLoai:hover a {
        color: var(--main_color);
        transition: 0.3s;
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
