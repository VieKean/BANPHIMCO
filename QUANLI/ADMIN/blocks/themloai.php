<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm Loại</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .contain-form {
            width: 500px;
            height: 250px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 64px;
            height: 36px;
            display: block;
            margin: 0 auto;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="contain-form">
    <h1>Thêm Loại</h1>
    <form method="post">
        <label> Tên Loại: </label>
        <input type="text" name="tenloai">
        <input type="submit" name="submit" value="Thêm">
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    <?php
    if (isset($_POST['submit'])) {
        $tenloai = $_POST['tenloai'];
        if ($tenloai != "") {
            $selectTenloai = "SELECT tenloai FROM loai WHERE tenloai='$tenloai'";
            $result = mysqli_query($conn, $selectTenloai);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO loai(tenloai) VALUES ('$tenloai')";
                if (mysqli_query($conn, $sql)) {
                    echo "toastr.success('Thêm Thành Công');";
                } else {
                    echo "toastr.error('Thêm Không Thành Công: " . mysqli_error($conn) . "');";
                }
            } else {
                echo "toastr.error('Tên loại đã tồn tại');";
            }
        } else {
            echo "toastr.warning('Vui lòng cung cấp đầy đủ thông tin!');";
        }
    }
    ?>
</script>
</body>
</html>
