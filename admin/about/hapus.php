<?php
include "../auth/session.php";
include "../../config/database.php";

/** @var mysqli $conn */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_query($conn, "SELECT * FROM about WHERE id_about='$id'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    mysqli_query($conn, "DELETE FROM about WHERE id_about='$id'");

    echo "<script>
            alert('Data about berhasil dihapus');
            window.location='index.php';
          </script>";
} else {
    echo "<script>
            alert('Data about tidak ditemukan');
            window.location='index.php';
          </script>";
}
?>