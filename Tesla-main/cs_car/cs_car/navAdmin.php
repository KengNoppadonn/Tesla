<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="./css/nav.css">

</head>
<?php
if (isset($_SESSION['admin_login'])) {
  $user_id = $_SESSION['admin_login'];
  $stmt = $conn->query("SELECT * FROM users WHERE uid = $user_id");
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<nav>
  <div class="nav-container">
    <div id="logo">
      <a href="HomeView.php">ADMIN CS CAR</a>
    </div>

      <ul class="BarMenu">
        <li><a href="./Admin_TestDrive.php">ตรวจสอบทดลองขับ</a></li>
        <li><a href="./Admin_SecondHand.php">ตรวจสอบโพสต์</a></li>
        <li><a href="./marketplace.php">ตลาดซื้อขายมือสอง</a></li>
      </ul>
 


    <?php if (isset($_SESSION['admin_login'])) { ?>
      <div class="LoginIcon">
        <ul class="BarMenu">
          <div class="adminName">
            <li><?php echo $row['firstname'] ?>&nbsp;&nbsp;</li>
          </div>
          <!-- <li><a href="user_page.php">แก้ไขข้อมูล</a></li> -->
          <a href="./logout.php"><i class="fa fa-sign-out" aria-hidden="true" style="color: black;"></i></a>
        <?php } else { ?>
          <a href="./signin.php"><i class="fa fa-user-circle-o" aria-hidden="true" style="color: black;"></i></a>
        <?php } ?>
        </ul>

      </div>
      <button class="mobile-menu-button" id="showmenu">เมนู</button>

      <!-- เพิ่มเมนูโทรศัพท์มือถือ -->
  </div>
</nav>

<script>
  const mobileMenuButton = document.getElementById('showmenu');
  const mobileMenu = document.getElementById('mobileMenu');

  mobileMenuButton.addEventListener('click', function() {
    if (mobileMenu.style.display === 'none' || mobileMenu.style.display === '') {
      mobileMenu.style.display = 'block';
      mobileMenuButton.innerHTML = '<i class="fa fa-times"></i>';
      console.log("เปิดเมนู");
    } else {
      mobileMenu.style.display = 'none';
      mobileMenuButton.innerHTML = 'เมนู';
      console.log(" ! ปิดเมนู");
    }
  });
</script>


</html>