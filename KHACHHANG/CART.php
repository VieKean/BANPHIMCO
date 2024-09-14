<?php
session_start();
require_once 'CONN.php';


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    //SELECT
    function select_KH($conn, $username)
    {
        $select_KH = "SELECT * FROM khachhang WHERE tendangnhap = '$username'";
        $result_KH = mysqli_query($conn, $select_KH);
        return $result_KH;
    }


    function select_GH($conn, $id_user)
    {
        $select_GH = "SELECT * FROM giohang WHERE makhachhang = '$id_user' ORDER BY magiohang DESC ";
        $result_GH = mysqli_query($conn, $select_GH);
        return $result_GH;
    }
    // Handle
    $select_KH = select_KH($conn, $username);
    $row_KH = mysqli_fetch_assoc($select_KH);
    $id_user = $row_KH['makhachhang']; //lay ma khach hang
    $select_GH = select_GH($conn, $id_user);  //lay thong tin san pham trong gio hang



?>
<!-- css -->
<link rel="stylesheet" href="./ASSETS/css/CART.css">;

    <header>
        <a href="home-login.php?page=content.php" class="btn-home">Trang chủ</a>
        <a href="home-login.php?page=product.php" class="btn-product">Sản Phẩm</a>



    </header>
    <form class="form-CART" action="CART-FUNC.php" method="post" enctype="multipart/form-data">
        <table class="table-product">
            <thead class="table-product-header">
                <tr>
                    <th>Hình ảnh</th>
                    <th>Mã sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody class="table-product-body">
                <?php
                while ($row_GH = mysqli_fetch_assoc($select_GH)) {
                    $totalprice = $row_GH['gia'] * $row_GH['soluong'];
                ?>
                    <tr>
                        <input style="display: none;" type="text" class="id_cart" name="id_cart[]" value="<?php echo $row_GH['magiohang'];?>">
                        <td><img src="../QUANLI/ASSETS/img/IMG-Product/<?php echo $row_GH['hinhanh']; ?>" alt=""></td>
                        <td><?php echo $row_GH['masanpham']; ?></td>
                        <td>
                            <input type="number" name="quantify[]" class="quantity-input" min="1" step="1" value="<?php echo $row_GH['soluong']; ?>" data-price="<?php echo $row_GH['gia']; ?>">
                        </td>
                        <td class="price"><?php echo number_format($totalprice); ?></td>
                        <td><a id="btn-delete" href="CARTDELETE.php?delete_id=<?php echo $row_GH['masanpham']; ?>&id_cart=<?php echo $row_GH['magiohang'] ?>"><i class="fa-solid fa-trash-can" style="color: #000000;"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="buyprd">
            <button type="submit" style="display:none;" id="update-quantify" name="update-quantify">Cập nhật số lượng</button>
            <div id="total-price">Tổng giá: <span id="total-price-value">0</span></div>
            <div id="quantity-count">Tổng số lượng: <span id="total-quantity-value">0</span></div>
            <button type="submit" name="btn-buycart" id="btn-buycart">Thanh toán</button>

            <!-- dùng để lấy dữ liệu bằng post -->
            <input type="number" style="display: none;" name="input-total-price" id="input-total-price" value=0>
            <input type="number" style="display: none;" name="input-total-quantify" id="input-total-quantify" value=0>



        </div>
        
    </form>







    <!-- icon script -->
    <script src="https://kit.fontawesome.com/c161c9d1d4.js" crossorigin="anonymous"></script>


    <!-- Update Product_price -->
    <script>
        // Lấy tất cả các phần tử input có class là 'quantity-input'
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let initialTotalPrice = 0;
        let initialTotalQuantity = 0;

        // Lặp qua từng phần tử input để tính tổng giá và số lượng ban đầu
        quantityInputs.forEach(input => {
            const quantity = parseInt(input.value);
            const price = parseFloat(input.dataset.price);

            if (!isNaN(quantity) && !isNaN(price)) {
                initialTotalPrice += quantity * price;
                initialTotalQuantity += quantity;
            }
        });

        // Cập nhật giá trị tổng giá và số lượng ban đầu vào các phần tử HTML tương ứng
        document.getElementById('total-price-value').textContent = initialTotalPrice.toLocaleString('en-US');
        document.getElementById('total-quantity-value').textContent = initialTotalQuantity;
        document.getElementById('input-total-quantify').value = initialTotalQuantity;
        document.getElementById('input-total-price').value = initialTotalPrice;

        // Lặp qua từng phần tử input và thêm sự kiện 'input' để tính toán tổng giá và số lượng sau khi thay đổi
        quantityInputs.forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        // Hàm tính toán tổng giá và số lượng sau khi thay đổi
        function updateTotal() {
            let totalPrice = 0;
            let totalQuantity = 0;

            // Lặp qua từng phần tử input
            quantityInputs.forEach(input => {
                const quantity = parseInt(input.value);
                const price = parseFloat(input.dataset.price);
                
                

                if (!isNaN(quantity) && !isNaN(price)) {
                    
                    totalPrice += quantity * price;
                    totalQuantity += quantity;

                    // Tăng giá từng sản phẩm sau khi tăng số lượng
                    const row = input.parentNode.parentNode;
                    const priceCell = row.querySelector('.price');
                    const updatedPrice = quantity * price;
                    priceCell.textContent = updatedPrice.toLocaleString('en-US');
                }
            });

            // Cập nhật giá trị tổng giá và số lượng sau khi thay đổi vào các phần tử HTML tương ứng
            document.getElementById('total-price-value').textContent = totalPrice.toLocaleString('en-US');
            document.getElementById('total-quantity-value').textContent = totalQuantity;
            document.getElementById('input-total-quantify').value = totalQuantity;
            document.getElementById('input-total-price').value = totalPrice;
        }
    </script>






















<?php } else {
    header("Location:home.php?page=./LOGIN/form-login.php");
} ?>