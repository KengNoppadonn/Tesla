<?php
session_start();
require_once 'config/db.php';
//เดี๋ยวต้องเพิ่มระบบเช็คว่าเป็นแอดมิน

if (isset($_SESSION['user_login'])) {
    header('location: HomeView.php');
} else if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;300&family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./css/Admin_TestDrive.css">

</head>
<nav>
    <?php include("./navAdmin.php") ?>
</nav>
<script>
    function approveTestDrive(TID) {

        xmlHttp = new XMLHttpRequest();
        var url = './db/AcceptTestDrive.php?TID=' + TID;
        xmlHttp.open("POST", url, true);


        xmlHttp.onload = function() {
            if (xmlHttp.readyState == 4 && xmlHttp.status === 200) {
                // ถ้าการร้องขอสำเร็จ (state 4 และ สถานะ 200) ลบแถวที่มีปุ่มที่ถูกคลิก
                const button = document.querySelector(".approve-button");
                if (button) {
                    button.closest("tr").remove();
                }
                // ตรวจสอบว่าไม่มีแถวในตาราง
                if (document.querySelector("table tbody tr") === null) {
                    // ถ้าไม่มีแถวในตาราง ลบตารางและแสดงข้อความ "ไม่มีคนยื่นเรื่องขออนุมัติ"
                    const table = document.querySelector("table");
                    if (table) {
                        table.remove();
                    }
                    const container = document.querySelector(".table_container");
                    if (container) {
                        container.innerHTML = "<h1>ไม่มีคนยื่นเรื่องขออนุมัติ</h1>";
                    }
                }
            }

        };
        xmlHttp.send();
    }
</script>

<body><br><br>
    <div class="Container">
        <br>

        <div class="center-horizontally">
            <a href="./Admin_HistoryTestDrive.php">
                <button class="History">ประวัติการสั่งซื้อ</button>
            </a>
        </div>


        <br>
        <?php
        $stmt = $conn->query("SELECT * FROM users INNER JOIN Tesdrive ON users.uid = Tesdrive.uid WHERE Tesdrive.Status = 0;");
        $stmt->execute();

        ?>
        <div class="table_container">
            <?php if ($stmt->rowCount() > 0) { ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ชื่อสมาชิก</th>
                            <th>นามสกุล</th>
                            <th>อีเมล</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>Modelรถ</th>
                            <th>Model Typeรถ</th>
                            <th>อนุมัติการขอ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($row = $stmt->fetch()) :
                        ?>
                            <?php $TID = $row["TID"] ?>
                            <tr>
                                <td><?= $row["firstname"] ?></td>
                                <td><?= $row["lastname"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $row["Tel"] ?></td>
                                <td><?= $row["Model"] ?></td>
                                <td><?= $row["Model_Type"] ?></td>
                                <td>
                                    <input type='submit' class="approve-button" name='Approve' onclick="approveTestDrive(<?= $TID ?>)" value="อนุมัติ">
                                </td>

                            </tr>
                    <?php endwhile;
                    } else {
                        echo "<h1>ไม่มีคนยื่นเรื่องขออนุมัติ</h1>";
                    } ?>
                    </tbody>
                </table>
        </div>

    </div>

</body>

</html>