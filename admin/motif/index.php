<?php
include "../auth/session.php";
include "../../config/database.php";
include "../includes/header.php";
include "../includes/sidebar.php";

/** @var mysqli $conn */

// Mengambil semua data dari database
$query = mysqli_query($conn, "SELECT * FROM motif_makna ORDER BY id_motif ASC");
$total_data = mysqli_num_rows($query);

// Fungsi bantu KHUSUS untuk mengubah teks Ciri-ciri menjadi format poin-poin (Bullet Points)
function formatKePoinCiri($teks) {
    $teks = trim($teks);
    if (empty($teks) || $teks == '-') {
        return '-';
    }
    
    // Memecah teks berdasarkan baris baru (enter)
    $baris = preg_split('/\R/', $teks);
    $output = '<ul style="margin: 0; padding-left: 15px; list-style-type: disc;">';
    $ada_poin = false;

    foreach ($baris as $b) {
        $b = trim($b);
        // Menghilangkan tanda strip (-), bullet (•), atau angka di awal jika diinput manual
        $b = preg_replace('/^[\-\•\*\d+\.]\s*/', '', $b);
        if (!empty($b)) {
            $output .= '<li style="margin-bottom: 4px;">' . htmlspecialchars($b) . '</li>';
            $ada_poin = true;
        }
    }
    $output .= '</ul>';

    return $ada_poin ? $output : htmlspecialchars($teks);
}
?>

<style>
    /* Pembungkus utama tabel agar bisa digeser ke samping */
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
        min-width: 1700px !important; /* Disesuaikan agar ruang untuk gambar lebih lega */
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

    /* Mengunci lebar kolom Nama Motif agar tidak memanjang full ke samping */
    .col-nama-motif {
        width: 130px !important;
        max-width: 150px !important;
        white-space: normal !important; 
        word-wrap: break-word !important;
    }

    /* Mengunci lebar kolom teks deskripsi */
    .col-deskripsi {
        width: 250px !important;
        max-width: 300px !important;
        white-space: normal !important;
        word-wrap: break-word !important;
    }
</style>

<main class="admin-main">

    <?php include "../includes/topbar.php"; ?>

    <section class="admin-content">

        <h1>Motif dan Makna</h1>

        <div class="admin-data-box">

            <div class="admin-data-header">
                <h2>Daftar Konten Motif dan Makna</h2>

                <a href="tambah.php" class="btn-add-admin">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Konten
                </a>
            </div>

            <div class="table-responsive-custom">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No.</th>
                            <th style="width: 120px;">Gambar</th>
                            <th>Nama Motif</th>
                            <th>Asal Daerah</th>
                            <th>Warna Dominan</th>
                            <th>Makna</th>
                            <th>Ciri-ciri Motif</th>
                            <th>Filosofi Visual</th>
                            <th>Penggunaan</th>
                            <th style="text-align: center; width: 100px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($total_data > 0) : ?>
                            <?php 
                            // Inisialisasi awal nomor urut
                            $no = 1; 
                            ?>
                            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #666;">
                                        <?= $no++; ?>.
                                    </td>

                                    <td>
                                        <?php if (!empty($row['gambar'])) : ?>
                                            <img src="/uploads/motif/<?= htmlspecialchars($row['gambar']); ?>"
                                                 alt="<?= htmlspecialchars($row['nama_motif']); ?>"
                                                 class="admin-thumb" style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                        <?php else : ?>
                                            <div class="table-image-placeholder" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background: #eee; border-radius: 6px;">
                                                <i class="bi bi-image" style="color: #ccc; font-size: 1.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="col-nama-motif">
                                        <?= htmlspecialchars($row['nama_motif']); ?>
                                    </td>

                                    <td style="white-space: nowrap;">
                                        <?= htmlspecialchars($row['asal_daerah']); ?>
                                    </td>

                                    <td style="white-space: nowrap;">
                                        <?= htmlspecialchars($row['warna_dominan'] ?? ($row['warna'] ?? '-')); ?>
                                    </td>

                                    <td class="col-deskripsi">
                                        <?= !empty($row['makna_motif']) ? nl2br(htmlspecialchars($row['makna_motif'])) : (!empty($row['makna']) ? nl2br(htmlspecialchars($row['makna'])) : '-'); ?>
                                    </td>

                                    <td class="col-deskripsi">
                                        <?php 
                                        $ciri_data = $row['ciri_motif'] ?? '-';
                                        echo formatKePoinCiri($ciri_data);
                                        ?>
                                    </td>

                                    <td class="col-deskripsi">
                                        <?= !empty($row['filosofi_visual']) ? nl2br(htmlspecialchars($row['filosofi_visual'])) : '-'; ?>
                                    </td>

                                    <td class="col-deskripsi">
                                        <?= !empty($row['penggunaan']) ? nl2br(htmlspecialchars($row['penggunaan'])) : '-'; ?>
                                    </td>

                                    <td>
                                        <div class="action-buttons" style="display: flex; justify-content: center; gap: 6px;">
                                            <a href="edit.php?id=<?= $row['id_motif']; ?>" class="btn-action" title="Edit" style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; color: #333; text-decoration: none;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="hapus.php?id=<?= $row['id_motif']; ?>"
                                               class="btn-action"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')"
                                               title="Hapus" style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 4px; color: #dc3545; text-decoration: none;">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center" style="padding: 20px; text-align: center;">
                                    Data motif dan makna belum tersedia.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <p class="data-count" style="margin-top: 15px;">
                Menampilkan <?= $total_data; ?> data dari database.
            </p>

        </div>

    </section>

    <div class="admin-bottom">
        © 2026 Tenun Ikat Sumba Barat. All Rights Reserved.
    </div>

</main>

<?php include "../includes/footer.php"; ?>