
<style>
    /* CSS styles */
    * {
        box-sizing: border-box;
    }
    

    #mota-wrapper {
        max-height: 140px;
        overflow-y: auto;
    }

    #mota {
        text-align: justify;
        max-width: 800px;
    }

    .top-table {
        display: flex;
        justify-content: space-between;
        padding: 5px 60px 10px 20px;
        align-items: center;
    }

    #search-container input[type="text"] {
        width: 350px;
        min-height: 30px;
        padding: 10px 20px;
        outline: none;
        border: none;
        border-bottom: thin solid #222;
        background: none;
    }

    #search-container button {
        height: 36px;
        width: 90px;
        border: thin solid #222;
        border-radius: 16px 0;
        font-size: 14px;
        font-weight: bold;
        margin-left: -4px;
        background: none;
        transition: 0.3s;
    }

    #search-container button:hover {
        background-color: #254753;
        color: #fff;
        transition: 0.3s;
    }

    #filter-container {
        display: flex;
        text-align: center;
        align-items: center;
    }

    #filter-container select {
        margin: 0 4px;
        font-size: 16px;
        width: max-content;
        padding: 2px 10px;
        background: none;
        min-height: 24px;
        outline: none;
    }

    #filter-container button {
        padding: 2px 5px;
        color: #fff;
        background-color: #254753;
        border: thin solid #254753;
        cursor: pointer;
        min-height: 24px;
    }

    #filter-container button:hover {
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
    .toast{
        position: fixed;
        bottom: 20px;
        right: 40px;
        z-index: 1000;
        align-items: center;
        color: #fff;
        border: none;
        padding: 12px 30px;
    }
    .bg-success{
        background-color: green;
    }
    .bg-danger{
        background-color: red;
    }
    .toast.hide {
    opacity: 0;
    pointer-events: none;
}
</style>
<?php
if(isset($_GET['success'])){
    echo '<div class="toast  bg-success" data-timeout="3">
              <div class="d-flex">
                  <div class="toast-body">
                      ' . $_GET['success'] . '<span class="countdown"> (3s)</span>
                  </div>
              </div>
          </div>';
}
elseif(isset($_GET['error'])){
    echo '<div class="toast bg-danger" data-timeout="3">
              <div class="d-flex">
                  <div class="toast-body">
                      ' . $_GET['error'] . '<span class="countdown"> (3s)</span>
                  </div>
              </div>
          </div>';
}
?>


<div class="top-table">
    <form id="form-container" method="post">
        <button id="themSP" name="submit" type="submit"><a href="?page=themsp">Thêm Sản Phẩm</a></button>
    </form>
    <div id="search-container">
        <input type="text" id="keyword" name="keyword" placeholder="Nhập tên, mã sản phẩm hoặc mô tả...">
        <button onclick="searchProducts()">Tìm kiếm</button>
    </div>

    <div id="filter-container">
        <label for="loai">Lọc theo loại:</label>
        <select id="loai" name="loai">
            <option value="">Tất cả</option>
            <?php
            $result_loai = mysqli_query($conn, "SELECT * FROM loai");
            while ($row_loai = mysqli_fetch_array($result_loai)) {
                echo '<option value="' . $row_loai['maloai'] . '">' . $row_loai['tenloai'] . '</option>';
            }
            ?>
        </select>
        <button onclick="filterProducts()">Lọc</button>
    </div>
</div>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "banphimco");

// số sp trêm mỗi trang
$items_per_page = 4;

// Lấy số trang hiện tại mặc định là 1 
$tpage = isset($_GET['tpage']) && $_GET['tpage'] > 0 ? (int)$_GET['tpage'] : 1;

$offset = max(0, ($tpage - 1) * $items_per_page);

// Đếm tổng sản phẩm
$total_query = "SELECT COUNT(*) as total FROM sanpham";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_products = $total_row['total'];

// tính tổng trang
$total_pages = ceil($total_products / $items_per_page);

$sql = "SELECT * FROM sanpham sp, loai l WHERE sp.loai = l.maloai";

$isFilteringOrSearching = false;

// thêm bộ lọc
if (isset($_GET['loai']) && !empty($_GET['loai'])) {
    $selectedLoai = $_GET['loai'];
    $sql .= " AND l.maloai = $selectedLoai";
    $isFilteringOrSearching = true;
}

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $sql .= " AND (sp.tensanpham LIKE '%$keyword%' OR sp.masanpham LIKE '%$keyword%' OR sp.mota LIKE '%$keyword%')";
    $isFilteringOrSearching = true;
}

// Sắp xếp theo masanpham giảm dần
$sql .= " ORDER BY sp.masanpham DESC";
// Chỉ thêm phân trang vào truy vấn nếu không lọc hoặc tìm kiếm
if (!$isFilteringOrSearching) {
    $sql .= " LIMIT $items_per_page OFFSET $offset";
}

// chạy sql
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

$i = $isFilteringOrSearching ? 1 : $offset + 1;
?>

<table class="main-table">
    <thead>
        <tr>
            <td>STT</td>
            <td>Mã SP</td>
            <td>Tên</td>
            <td>Giá</td>
            <td>Ảnh</td>
            <td>Mô Tả</td>
            <td>Loại</td>
            <td>Chức Năng</td>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_array($result)) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['masanpham']; ?></td>
                <td><?php echo $row['tensanpham']; ?></td>
                <td><?php echo number_format($row['gia']); ?></td>
                <td><img width="100px" height="100px" src="../ASSETS/img/IMG-Product/<?php echo $row['hinhanh']; ?>"></td>
                <td>
                    <div id="mota-wrapper">
                        <div id="mota">
                            <?php
                            $mota = $row['mota'];
                            $lim = 50;
                            if (mb_strlen($mota, 'UTF-8') > $lim) {
                                $mota = mb_substr($mota, 0, $lim, 'UTF-8') . '<span id="more' . $i . '" style="display:none;">' . mb_substr($mota, $lim, null, 'UTF-8') . '</span><a href="javascript:void(0);" onclick="toggleDescription(' . $i . ')" id="myBtn' . $i . '">Xem Thêm</a>';
                            }
                            echo $mota;
                            ?>
                        </div>
                    </div>
                </td>
                <td><?php echo $row['tenloai']; ?></td>
                <td>
                    <div class="my_button">
                        <a href="?page=capnhatsp&masanpham=<?php echo $row['masanpham']; ?>" class="fa-solid fa-screwdriver-wrench"></a>
                        <form method="post" action="blocks/deleteproduct.php?id=<?php echo $row['masanpham']; ?>">
                            <input type="hidden" name="masanpham" value="<?php echo $row['masanpham']; ?>">
                            <button type="submit" name="del"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php if (!$isFilteringOrSearching) : ?>
    <div class="btn-pagination">
        <?php if ($tpage > 1) : ?>
            <a href="?page=dssanpham&tpage=1"><i class="fa-solid fa-angles-left"></i></a>
            <a href="?page=dssanpham&tpage=<?php echo $tpage - 1; ?>"><i class="fa-solid fa-angle-left"></i></a>
        <?php endif; ?>

        <?php for ($p = 1; $p <= $total_pages; $p++) : ?>
            <a href="?page=dssanpham&tpage=<?php echo $p; ?>" class="<?php if ($p == $tpage) echo 'active'; ?>"><?php echo $p; ?></a>
        <?php endfor; ?>

        <?php if ($tpage < $total_pages) : ?>
            <a href="?page=dssanpham&tpage=<?php echo $tpage + 1; ?>"><i class="fa-solid fa-angle-right"></i></a>
            <a href="?page=dssanpham&tpage=<?php echo $total_pages; ?>"><i class="fa-solid fa-angles-right"></i></a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
    
    function filterProducts() {
        var selectedLoai = document.getElementById("loai").value;
        var url = 'index.php?page=dssanpham';

        if (selectedLoai) {
            url += '&loai=' + selectedLoai;
        }
        window.location.href = url;
    }

    function searchProducts() {
        var keyword = document.getElementById("keyword").value;
        var url = 'index.php?page=dssanpham';

        if (keyword) {
            url += '&keyword=' + keyword;
        }
        window.location.href = url;
    }
    

    function toggleDescription(id) {
        var moreText = document.getElementById("more" + id);
        var btnText = document.getElementById("myBtn" + id);

        if (moreText.style.display === "none") {
            moreText.style.display = "inline";
            btnText.innerHTML = "Ẩn";
        } else {
            moreText.style.display = "none";
            btnText.innerHTML = "Xem Thêm";
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast');
        
        toasts.forEach(toast => {
            let timeout = parseInt(toast.getAttribute('data-timeout'));
            const countdownElement = toast.querySelector('.countdown');
            const interval = setInterval(() => {
                if (timeout > 1) {
                    timeout -= 1;
                    countdownElement.textContent = ` (${timeout}s)`;
                } else {
                    clearInterval(interval);
                }
            }, 1000);
            
            setTimeout(() => {
                toast.classList.add('hide');
            }, timeout * 1000);
        });
    });

</script>
