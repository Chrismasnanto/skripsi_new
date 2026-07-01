<?php
include "../auth/session.php";
include "../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";

/** @var mysqli $conn */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_query($conn, "SELECT * FROM motif_makna WHERE id_motif='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>
            alert('Data motif dan makna tidak ditemukan');
            window.location='index.php';
          </script>";
    exit;
}

if (isset($_POST['update'])) {
    $id_admin = $_SESSION['admin'];

    $nama_motif = mysqli_real_escape_string($conn, $_POST['nama_motif']);
    $asal_daerah = mysqli_real_escape_string($conn, $_POST['asal_daerah']);
    $makna = mysqli_real_escape_string($conn, $_POST['makna']);
    $ciri_motif = mysqli_real_escape_string($conn, $_POST['ciri_motif']);
    $warna_dominan = mysqli_real_escape_string($conn, $_POST['warna_dominan']);
    $filosofi_visual = mysqli_real_escape_string($conn, $_POST['filosofi_visual']);
    $penggunaan = mysqli_real_escape_string($conn, $_POST['penggunaan']);

    $gambar = $data['gambar'];

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
            if (!empty($data['gambar']) && file_exists($folder_upload . $data['gambar'])) {
                unlink($folder_upload . $data['gambar']);
            }

            move_uploaded_file($tmp_gambar, $folder_upload . $nama_baru);
            $gambar = $nama_baru;
        } else {
            echo "<script>
                    alert('Format gambar harus JPG, JPEG, PNG, atau WEBP');
                  </script>";
        }
    }

    $update = mysqli_query($conn, "UPDATE motif_makna SET
                                    id_admin='$id_admin',
                                    nama_motif='$nama_motif',
                                    asal_daerah='$asal_daerah',
                                    makna='$makna',
                                    ciri_motif='$ciri_motif',
                                    warna_dominan='$warna_dominan',
                                    filosofi_visual='$filosofi_visual',
                                    penggunaan='$penggunaan',
                                    gambar='$gambar'
                                  WHERE id_motif='$id'");

    if ($update) {
        echo "<script>
                alert('Data motif dan makna berhasil diperbarui');
                window.location='index.php';
              </script>";
    } else {
        echo "<script>
                alert('Data motif dan makna gagal diperbarui');
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

        <h1>Edit Motif dan Makna</h1>

        <div class="admin-data-box">

            <div class="admin-data-header">
                <h2>Form Edit Konten Motif dan Makna</h2>

                <a href="index.php" class="btn-add-admin">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="admin-form">
    <input type="hidden" name="id_motif" value="<?= $data['id_motif']; ?>">

                <div class="form-admin-group">
                    <label>Nama Motif</label>
                    <input type="text"
                           name="nama_motif"
                           value="<?= htmlspecialchars($data['nama_motif']); ?>"
                           required>
                </div>

                <div class="form-admin-group">
                    <label>Asal Daerah</label>
                    <input type="text"
                           name="asal_daerah"
                           value="<?= htmlspecialchars($data['asal_daerah']); ?>"
                           required>
                </div>

                <div class="form-admin-group">
                    <label>Makna</label>
                    <textarea name="makna"
                              rows="8"
                              required><?= htmlspecialchars($data['makna']); ?></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Ciri-ciri Motif</label>
                    <textarea
                        name="ciri_motif"
                        rows="5"
                        required><?= htmlspecialchars($data['ciri_motif']); ?></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Warna Dominan</label>
                    <input
                        type="text"
                        name="warna_dominan"
                        value="<?= htmlspecialchars($data['warna_dominan']); ?>"
                        required>
                </div>


                <div class="form-admin-group">
                    <label>Filosofi Visual</label>
                    <textarea
                        name="filosofi_visual"
                        rows="5"
                        required><?= htmlspecialchars($data['filosofi_visual']); ?></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Penggunaan Kain</label>
                    <textarea
                        name="penggunaan"
                        rows="5"
                        required><?= htmlspecialchars($data['penggunaan']); ?></textarea>
                </div>

                <div class="form-admin-group">
                    <label>Gambar Saat Ini</label>

                    <?php if (!empty($data['gambar'])) : ?>
                        <img src="/uploads/motif/<?= htmlspecialchars($data['gambar']); ?>"
                             alt="<?= htmlspecialchars($data['nama_motif']); ?>"
                             class="admin-preview-img">
                    <?php else : ?>
                        <p>Belum ada gambar.</p>
                    <?php endif; ?>
                </div>

                <div class="form-admin-group">
                    <label>Ganti Gambar</label>
                    <input type="file" name="gambar" accept="image/*">
                </div>

                <div class="form-admin-action">
                    <button type="submit" name="update" class="btn-submit-admin">
                        Update
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