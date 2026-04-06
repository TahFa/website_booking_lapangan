<?php
session_start();

// khusus user
if ($_SESSION['role'] != 'user') {
    echo "<script>
    alert('Akses ditolak! Bukan user');
    window.location='../admin/index.php';
    </script>";
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>User Panel</title>
</head>

<body>

    <?php
    if (!isset($_SESSION['login'])) {
        include 'login.php';
    } else {
        include 'dashboard.php';
    }
    ?>

</body>

</html>