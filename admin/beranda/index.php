<?php
include "../auth/session.php";
include __DIR__ . "/../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";

$query = mysqli_query($conn, "SELECT * FROM beranda ORDER BY id_beranda DESC");
$total_data = mysqli_num_rows($query);
?>

<!-- STYLE FIX: DISESUAIKAN DENGAN FORMAT STRUKTUR TABEL MOTIF -->
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
        vertical-align: top !important; /* Agar teks deskripsi panjang sejajar dari atas */
        border-bottom: 1px solid #dee2e6 !important;
        color: #444 !important;
        font-size: 0.88rem !important;
        line-height: 1.5 !important;
    }

    /* Mengunci kolom teks agar text-wrap turun kebawah dengan rapi */
    .col-judul-beranda {
        width: 200px !important;
        max-width: 250px !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }

    .col-deskripsi-beranda {
        width: 400px !important;
        max-width: 500px !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }
</style>

<main class="admin-main">

    <?php include "../includes/topbar.php"; ?>

    <section class="admin-content">

        <h1>Beranda</h1>

        <div class="admin-data-box">

            <div class="admin-data-header">
                <h2>Daftar Konten Beranda</h2>

                <a href="tambah.php" class="btn-add-admin">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Konten
                </a>
            </div>

            <!-- REVISI BAGIAN TABEL BERANDA -->
            <div class="table-responsive-custom">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No.</th>
                            <th style="width: 130px;">Gambar</th>
                            <th>Judul</th>
                            <th>Deskripsi Singkat</th>
                            <th style="text-align: center; width: 110px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($total_data > 0) : ?>
                            <?php 
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)) : 
                            ?>
                                <tr>
                                    <!-- 1. Kolom Nomor Urut -->
                                    <td style="text-align: center; font-weight: 600; color: #666;">
                                        <?= $no++; ?>.
                                    </td>

                                    <!-- 2. Kolom Gambar (Sizing Diperbesar 100px) -->
                                    <td>
                                        <?php if (!empty($row['gambar'])) : ?>
                                            <img src="/uploads/beranda/<?= htmlspecialchars($row['gambar']); ?>"
                                                 alt="<?= htmlspecialchars($row['judul']); ?>"
                                                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <?php else : ?>
                                            <div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background: #eee; border-radius: 6px;">
                                                <i class="bi bi-image" style="color: #ccc; font-size: 1.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- 3. Kolom Judul -->
                                    <td class="col-judul-beranda">
                                        <strong><?= htmlspecialchars($row['judul']); ?></strong>
                                    </td>

                                    <!-- 4. Kolom Deskripsi Singkat (FIX: DIBUAT FULL TANPA POTONGAN SUBSTR) -->
                                    <td class="col-deskripsi-beranda">
                                        <?= htmlspecialchars(strip_tags($row['deskripsi'])); ?>
                                    </td>

                                    <!-- 5. Kolom Aksi Berborder Kotak Minimalis -->
                                    <td>
                                        <div style="display: flex; justify-content: center; gap: 6px;">
                                            <a href="edit.php?id=<?= $row['id_beranda']; ?>" class="btn-action" title="Edit" style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; color: #333; text-decoration: none; display: inline-block;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id_beranda']; ?>"
                                               class="btn-action"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')"
                                               title="Hapus" style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; color: #dc3545; text-decoration: none; display: inline-block;">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        <?php else : ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px; color: #858796;">
                                    Data beranda belum tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <p class="data-count" style="margin-top: 15px; color: #666; font-size: 0.9rem;">
                Menampilkan <strong><?= $total_data; ?></strong> data
            </p>

        </div>

    </section>

    <div class="admin-bottom">
        © 2026 Tenun Ikat Sumba Barat. All Rights Reserved.
    </div>

</main>

<?php include "../includes/footer.php"; ?>