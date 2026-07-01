<?php
include "../auth/session.php";
include "../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";

/** @var mysqli $conn */
$query = mysqli_query($conn, "SELECT * FROM about ORDER BY id_about ASC");
$total_data = mysqli_num_rows($query);
?>

<style>
    /* Wadah responsif */
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
        white-space: nowrap !important;
    }

    .admin-table td {
        padding: 12px 15px !important;
        vertical-align: top !important; /* Teks dimulai dari atas */
        border-bottom: 1px solid #dee2e6 !important;
        color: #333 !important;
        font-size: 0.9rem !important;
    }

    /* Pengaturan kolom agar tidak mepet */
    .col-no { width: 60px !important; text-align: center !important; }
    .col-aksi { width: 120px !important; text-align: center !important; }
    
    .col-isi-full {
        text-align: left !important;         /* Rata kiri */
        padding-right: 30px !important;      /* Beri ruang agar tidak mepet kanan */
        white-space: normal !important;      
        word-wrap: break-word !important;    
        line-height: 1.6 !important;         /* Jarak antar baris agar lega */
    }

    .btn-action-wrapper { display: flex; justify-content: center; gap: 6px; }
    .btn-action { color: #858796; text-decoration: none; padding: 5px; }
</style>

<main class="admin-main">
    <?php include "../includes/topbar.php"; ?>

    <section class="admin-content">
        <h1>Tentang Kami</h1>

        <div class="admin-data-box">
            <div class="admin-data-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h2>Daftar Konten Tentang Kami</h2>
                <a href="tambah.php" class="btn-add-admin">
                    <i class="bi bi-plus-lg"></i> Tambah Konten
                </a>
            </div>

            <div class="table-responsive-custom">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="col-no">No.</th>
                            <th style="width: 200px;">Judul</th>
                            <th class="col-isi-full">Isi Lengkap</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_data > 0) : 
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td class="col-no"><?= $no++; ?>.</td>
                                <td><?= htmlspecialchars($row['judul']); ?></td>
                                <td class="col-isi-full"><?= nl2br(htmlspecialchars($row['isi'])); ?></td>
                                <td class="col-aksi">
                                    <div class="btn-action-wrapper">
                                        <a href="edit.php?id=<?= $row['id_about']; ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
                                        <a href="hapus.php?id=<?= $row['id_about']; ?>" class="btn-action" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; 
                        else : ?>
                            <tr><td colspan="4" style="text-align: center; padding: 20px;">Data belum tersedia.</td></tr>
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

<?php include "../includes/footer.php"; ?>