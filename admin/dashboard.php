<?php
include "auth/session.php";
include "../config/database.php";

/** @var mysqli $conn */

$jml_beranda = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM beranda"));
$jml_sejarah = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sejarah"));
$jml_motif   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM motif_makna"));
$jml_proses  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM proses_pembuatan"));
$jml_galeri  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM galeri"));
$jml_about   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM about"));

$data_terbaru = [];
function tambahDataTerbaru($conn, &$data_terbaru, $sql, $kategori, $folder_upload, $edit_link, $hapus_link)
{
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $data_terbaru[] = [
                'id' => $row['id_data'],
                'konten' => $row['konten'],
                'gambar' => $row['gambar'] ?? '',
                'created_at' => $row['created_at'],
                'kategori' => $kategori,
                'folder_upload' => $folder_upload,
                'edit_link' => $edit_link,
                'hapus_link' => $hapus_link
            ];
        }
    }
}

tambahDataTerbaru(
    $conn,
    $data_terbaru,
    "SELECT id_beranda AS id_data, judul AS konten, gambar, created_at 
     FROM beranda 
     ORDER BY created_at DESC 
     LIMIT 3",
    "Beranda",
    "/uploads/beranda/",
    "beranda/edit.php?id=",
    "beranda/hapus.php?id="
);

tambahDataTerbaru(
    $conn,
    $data_terbaru,
    "SELECT id_sejarah AS id_data, judul AS konten, gambar, created_at 
     FROM sejarah 
     ORDER BY created_at DESC 
     LIMIT 3",
    "Sejarah",
    "/uploads/sejarah/",
    "sejarah/edit.php?id=",
    "sejarah/hapus.php?id="
);

tambahDataTerbaru(
    $conn,
    $data_terbaru,
    "SELECT id_motif AS id_data, nama_motif AS konten, gambar, created_at 
     FROM motif_makna 
     ORDER BY created_at DESC 
     LIMIT 3",
    "Motif & Makna",
    "/uploads/motif/",
    "motif/edit.php?id=",
    "motif/hapus.php?id="
);

tambahDataTerbaru(
    $conn,
    $data_terbaru,
    "SELECT id_proses AS id_data, judul AS konten, gambar, created_at 
     FROM proses_pembuatan 
     ORDER BY created_at DESC 
     LIMIT 3",
    "Proses Pembuatan",
    "/uploads/proses/",
    "proses/edit.php?id=",
    "proses/hapus.php?id="
);

tambahDataTerbaru(
    $conn,
    $data_terbaru,
    "SELECT id_galeri AS id_data, judul AS konten, gambar, created_at 
     FROM galeri 
     ORDER BY created_at DESC 
     LIMIT 3",
    "Galeri",
    "/uploads/galeri/",
    "galeri/edit.php?id=",
    "galeri/hapus.php?id="
);

tambahDataTerbaru(
    $conn,
    $data_terbaru,
    "SELECT id_about AS id_data, judul AS konten, '' AS gambar, created_at 
     FROM about 
     ORDER BY created_at ASC ",
    "About",
    "",
    "about/edit.php?id=",
    "about/hapus.php?id="
);

usort($data_terbaru, function ($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$data_terbaru = array_slice($data_terbaru, 0, 8);

include "includes/header.php";
include "includes/sidebar.php";
?>

<style>
    .table-responsive-custom {
        width: 100% !important;
        overflow-x: auto !important;
        margin-top: 15px;
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        background: #fff;
    }
    
    .admin-table {
        width: 100% !important;
        border-collapse: collapse !important;
        table-layout: fixed !important;
    }

    .admin-table th {
        background-color: #f8f9fa !important;
        color: #333 !important;
        font-weight: 700 !important;
        padding: 12px 15px !important;
        border-bottom: 2px solid #dee2e6 !important;
    }

    .admin-table td {
        padding: 12px 15px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #dee2e6 !important;
        color: #333 !important;
        font-size: 0.9rem !important;
    }

    /* Penataan Ulang Proporsi Lebar Kolom */
    .col-no {
        width: 60px !important;
        text-align: center !important;
    }
    
    .col-gambar {
        width: 130px !important;
        text-align: left !important;
    }

    .col-konten {
        text-align: left !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }

    /* REVISI UTAMA: Diperlebar ke 280px agar area kiri meluas, sehingga teks/badge otomatis bergeser ke kiri */
    .col-kategori {
        width: 280px !important;
        text-align: left !important;
    }

    .col-aksi {
        width: 120px !important;
        text-align: center !important;
    }

    .btn-action-wrapper {
        display: flex; 
        justify-content: center; 
        gap: 6px;
    }

    .btn-action-custom {
        padding: 6px 10px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
        color: #333; 
        background: #fff;
        text-decoration: none; 
        display: inline-block;
    }

    .btn-action-delete {
        color: #dc3545;
    }
</style>    

<main class="admin-main">

    <div class="admin-topbar">
        <div class="topbar-account">
            <div class="topbar-account-icon">
                <i class="bi bi-person"></i>
            </div>

            <div class="topbar-account-name">
                Halo, <?= htmlspecialchars($_SESSION['nama'] ?? 'Administrator'); ?>
            </div>

            <div class="topbar-account-menu">
                <button type="button" class="topbar-account-btn" onclick="toggleAccountDropdown(event)">
                    <i class="bi bi-chevron-down"></i>
                </button>

                <div class="topbar-account-dropdown" id="topbarAccountDropdown">
                    <div class="account-dropdown-profile">
                        <div class="account-dropdown-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <strong><?= htmlspecialchars($_SESSION['nama'] ?? 'Administrator'); ?></strong>
                            <small><?= htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></small>
                        </div>
                    </div>
                    <div class="account-dropdown-line"></div>
                    <a href="logout.php"><i class="bi bi-arrow-repeat"></i> Ganti Akun</a>
                    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>
        </div>
    </div>

    <section class="admin-content">

        <h1>Dashboard</h1>

        <div class="dashboard-summary">
            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-house-door"></i></div>
                <div>
                    <span>Beranda</span>
                    <h3><?= $jml_beranda; ?></h3>
                    <p>Data</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-clock-history"></i></div>
                <div>
                    <span>Sejarah</span>
                    <h3><?= $jml_sejarah; ?></h3>
                    <p>Data</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                <div>
                    <span>Motif & Makna</span>
                    <h3><?= $jml_motif; ?></h3>
                    <p>Data</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-sliders"></i></div>
                <div>
                    <span>Proses Pembuatan</span>
                    <h3><?= $jml_proses; ?></h3>
                    <p>Data</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-image"></i></div>
                <div>
                    <span>Galeri</span>
                    <h3><?= $jml_galeri; ?></h3>
                    <p>Data</p>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon"><i class="bi bi-info-circle"></i></div>
                <div>
                    <span>About</span>
                    <h3><?= $jml_about; ?></h3>
                    <p>Data</p>
                </div>
            </div>
        </div>

        <div class="admin-data-box" style="margin-top: 25px;">
            <h2>Data Terbaru</h2>

            <div class="table-responsive-custom">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-no">No.</th>
                            <th class="col-gambar">Gambar</th>
                            <th class="col-konten">Konten</th>
                            <th class="col-kategori">Kategori</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($data_terbaru)) : ?>
                            <?php foreach ($data_terbaru as $index => $data) : ?>
                                <tr>
                                    <td class="col-no" style="font-weight: 600; color: #666;">
                                        <?= $index + 1; ?>.
                                    </td>

                                    <td class="col-gambar">
                                        <?php if (!empty($data['gambar'])) : ?>
                                            <img src="<?= htmlspecialchars($data['folder_upload'] . $data['gambar']); ?>"
                                                 alt="<?= htmlspecialchars($data['konten']); ?>"
                                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <?php else : ?>
                                            <div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background: #eee; border-radius: 6px;">
                                                <i class="bi bi-image" style="color: #ccc; font-size: 1.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="col-konten">
                                       <?= htmlspecialchars($data['konten']); ?> 
                                    </td>

                                    <td class="col-kategori">
                                          
                                            <?= htmlspecialchars($data['kategori']); ?>
                                        
                                    </td>

                                    <td class="col-aksi">
                                        <div class="btn-action-wrapper">
                                            <a href="<?= htmlspecialchars($data['edit_link'] . $data['id']); ?>" class="btn-action-custom" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= htmlspecialchars($data['hapus_link'] . $data['id']); ?>"
                                               class="btn-action-custom btn-action-delete"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')"
                                               title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #858796;">
                                    Data terbaru belum tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

    <div class="admin-bottom">
        © 2026 Tenun Ikat Sumba Barat. All Rights Reserved.
    </div>

</main>

<?php include "includes/footer.php"; ?>