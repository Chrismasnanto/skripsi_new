<?php
include "../auth/session.php";
include "../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";

/** @var mysqli $conn */
$query = mysqli_query($conn, "SELECT * FROM proses_pembuatan ORDER BY id_proses DESC");
$total_data = mysqli_num_rows($query);
?>

<style>
    /* Menggunakan gaya tabel yang konsisten dengan halaman Beranda */
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
        min-width: 900px !important;
        border-collapse: collapse !important;
    }

    .admin-table th {
        background-color: #f8f9fa !important;
        color: #333 !important;
        font-weight: 700 !important;
        white-space: nowrap !important;
        padding: 12px 15px !important;
        border-bottom: 2px solid #dee2e6 !important;
        text-align: left;
    }

    .admin-table td {
        padding: 12px 15px !important;
        vertical-align: top !important;
        border-bottom: 1px solid #dee2e6 !important;
        color: #444 !important;
        font-size: 0.88rem !important;
        line-height: 1.5 !important;
    }

    /* Penyesuaian lebar kolom untuk tabel proses */
    .col-judul-proses {
        width: 200px !important;
        max-width: 250px !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }

    .col-deskripsi-proses {
        width: 400px !important;
        max-width: 500px !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }

    .admin-thumb { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; }
</style>

<main class="admin-main">
    <?php include "../includes/topbar.php"; ?>

    <section class="admin-content">
        <h1>Proses Pembuatan</h1>

        <div class="admin-data-box">
            <div class="admin-data-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2>Daftar Konten Proses Pembuatan</h2>
                <a href="tambah.php" class="btn-add-admin">
                    <i class="bi bi-plus-lg"></i> Tambah Konten
                </a>
            </div>

            <div class="table-responsive-custom">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No.</th>
                            <th style="width: 120px;">Gambar</th>
                            <th>Judul Tahapan</th>
                            <th>Deskripsi</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_data > 0) : 
                            $no = 1; 
                            while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++; ?>.</td>
                                <td>
                                    <?php if (!empty($row['gambar'])) : ?>
                                        <img src="/uploads/proses/<?= htmlspecialchars($row['gambar']); ?>" class="admin-thumb">
                                    <?php endif; ?>
                                </td>
                                <td class="col-judul-proses"><?= htmlspecialchars($row['judul']); ?></td>
                                <td class="col-deskripsi-proses"><?= nl2br(htmlspecialchars($row['isi'])); ?></td>
                                <td style="text-align: center;">
                                    <a href="edit.php?id=<?= $row['id_proses']; ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
                                    <a href="hapus.php?id=<?= $row['id_proses']; ?>" class="btn-action" onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                        <?php endwhile; 
                        else : ?>
                            <tr><td colspan="5" style="text-align: center; padding: 20px;">Data belum tersedia.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <p class="data-count" style="margin-top: 10px;">Menampilkan <?= $total_data; ?> data</p>
        </div>
    </section>
</main>