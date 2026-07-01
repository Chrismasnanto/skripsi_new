<?php
include "../auth/session.php";
include "../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";


/** @var mysqli $conn */

if (isset($_POST['simpan'])) {
    $id_admin = $_SESSION['admin'];

    $nama_motif = mysqli_real_escape_string($conn, $_POST['nama_motif']);
    $asal_daerah = mysqli_real_escape_string($conn, $_POST['asal_daerah']);
    $makna = mysqli_real_escape_string($conn, $_POST['makna']);
    $ciri_motif = mysqli_real_escape_string($conn, $_POST['ciri_motif']);
    $warna_dominan = mysqli_real_escape_string($conn, $_POST['warna_dominan']);
    $filosofi_visual = mysqli_real_escape_string($conn, $_POST['filosofi_visual']);
    $penggunaan = mysqli_real_escape_string($conn, $_POST['penggunaan']);
    
    // Cek apakah data motif dengan nama dan asal daerah yang sama sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM motif_makna 
                                WHERE nama_motif='$nama_motif' 
                                AND asal_daerah='$asal_daerah' 
                                LIMIT 1");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
                alert('Data motif dengan nama dan asal daerah yang sama sudah ada. Silakan gunakan data lain atau edit data yang sudah ada.');
                window.location='index.php';
              </script>";
        exit;
    }

    $gambar = "";

    if (!empty($_FILES['gambar']['name'])) {
        $nama_gambar = $_FILES['gambar']['name'];
        $tmp_gambar = $_FILES['gambar']['tmp_name'];
        $ekstensi = strtolower(pathinfo($nama_gambar, PATHINFO_EXTENSION));

        $nama_baru = time() . "_" . uniqid() . "." . $ekstensi;
        $folder_upload = "../../uploads/motif/";

        if (!is_dir($folder_upload)) {
            mkdir($folder_upload, 0777, true);
        }

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ekstensi, $allowed)) {
            move_uploaded_file($tmp_gambar, $folder_upload . $nama_baru);
            $gambar = $nama_baru;
        } else {
            echo "<script>
                    alert('Format gambar harus JPG, JPEG, PNG, atau WEBP');
                  </script>";
        }
    }

    $query = mysqli_query($conn, "INSERT INTO motif_makna
    (
        id_admin,
        nama_motif,
        asal_daerah,
        makna,
        ciri_motif,
        warna_dominan,
        filosofi_visual,
        penggunaan,
        gambar
    )
    VALUES
    (
        '$id_admin',
        '$nama_motif',
        '$asal_daerah',
        '$makna',
        '$ciri_motif',
        '$warna_dominan',
        '$filosofi_visual',
        '$penggunaan',
        '$gambar'
    )");

    if ($query) {
        echo "<script>
                alert('Data motif dan makna berhasil ditambahkan');
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data motif dan makna gagal ditambahkan');
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

        <h1>Tambah Motif dan Makna</h1>

        <div class="admin-data-box">

            <div class="admin-data-header">
                <h2>Form Tambah Konten Motif dan Makna</h2>

                <a href="index.php" class="btn-add-admin">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="admin-form">

                <div class="form-admin-group">
                    <label>Nama Motif</label>
                    <input type="text" name="nama_motif" placeholder="Masukkan nama motif" required>
                </div>

                <div class="form-admin-group">
                    <label>Asal Daerah</label>
                    <input type="text" name="asal_daerah" placeholder="Masukkan asal daerah" required>
                </div>

                <div class="form-admin-group">
                    <label>Makna</label>
                    <textarea name="makna" rows="8" placeholder="Masukkan makna motif" required></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Ciri-ciri Motif</label>
                    <textarea
                        name="ciri_motif"
                        rows="5"
                        placeholder="Masukkan ciri-ciri visual motif"
                        required></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Warna Dominan</label>

                    <input
                        type="text"
                        name="warna_dominan"
                        placeholder="Contoh : Merah, Hitam, Putih"
                        required>
                </div>

                <div class="form-admin-group">
                    <label>Filosofi Visual</label>

                    <textarea
                        name="filosofi_visual"
                        rows="5"
                        placeholder="Masukkan filosofi visual motif"
                        required></textarea>
                </div>
                
                <div class="form-admin-group">
                    <label>Penggunaan Motif</label>

                    <textarea
                        name="penggunaan"
                        rows="5"
                        placeholder="Contoh : Digunakan pada upacara adat, pernikahan, penyambutan tamu, dan acara budaya"
                        required></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Gambar Motif</label>
                    <input type="file" name="gambar" accept="image/*">
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