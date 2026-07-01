<?php
include "../auth/session.php";
include "../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";

/** @var mysqli $conn */

if (isset($_POST['simpan'])) {
    $id_admin = $_SESSION['admin'];

    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi = mysqli_real_escape_string($conn, $_POST['isi']);

    $cek = mysqli_query($conn, "SELECT * FROM about WHERE judul='$judul' LIMIT 1");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
                alert('Judul about sudah ada. Silakan edit data yang sudah tersedia.');
                window.location='index.php';
              </script>";
        exit;
    }

    $query = mysqli_query($conn, "INSERT INTO about (id_admin, judul, isi)
                                  VALUES ('$id_admin', '$judul', '$isi')");

    if ($query) {
        echo "<script>
                alert('Data about berhasil ditambahkan');
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data about gagal ditambahkan');
              </script>";
    }
}
?>

<main class="admin-main">

    <header class="admin-topbar">
        <div></div>

        <div class="topbar-user-simple">
            <div class="user-icon">
                <i class="bi bi-person"></i>
            </div>

            <span>Halo, <?= $_SESSION['nama'] ?? 'Admin'; ?></span>
            <i class="bi bi-chevron-down"></i>
        </div>
    </header>

    <section class="admin-content">

        <h1>Tambah About</h1>

        <div class="admin-data-box">

            <div class="admin-data-header">
                <h2>Form Tambah Konten About</h2>

                <a href="index.php" class="btn-add-admin">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>

            <form action="" method="POST" class="admin-form">

                <div class="form-admin-group">
                    <label>Judul</label>

                    <select name="judul" required>
                        <option value="">-- Pilih Judul --</option>
                        <option value="Tujuan Website">Tujuan Website</option>
                        <option value="Harapan Website">Harapan Website</option>
                    </select>
                </div>

                <div class="form-admin-group">
                    <label>Isi</label>
                    <textarea name="isi"
                              rows="8"
                              placeholder="Masukkan isi konten about"
                              required></textarea>
                </div>

                <div class="form-admin-action">
                    <button type="submit" name="simpan" class="btn-submit-admin">
                        Simpan
                    </button>

                    <a href="index.php" class="btn-cancel-admin">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </section>

    <div class="admin-bottom">
        © 2026 Tenun Ikat Sumba Barat. All Rights Reserved.
    </div>

</main>

<?php include "../includes/footer.php"; ?>