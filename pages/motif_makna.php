<?php
include "../config/database.php";
include "../includes/header.php";
include "../includes/navbar.php";


/** @var mysqli $conn */

$queryMotif = mysqli_query($conn, "SELECT * FROM motif_makna ORDER BY id_motif ASC");
$totalMotif = mysqli_num_rows($queryMotif);
?>
<section class="motif-hero">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <span class="section-badge">MOTIF & MAKNA</span>
                <h1>
                    Motif & Makna<br>
                    Tenun Ikat Sumba Barat
                </h1>
                <p>
                    Setiap motif Tenun Ikat Sumba Barat memiliki makna
                    yang mendalam dan diwariskan secara turun-temurun.
                    Melalui motif, masyarakat Sumba Barat mengekspresikan
                    nilai-nilai kehidupan, kepercayaan, dan identitas budaya.
                </p>
            </div>
            <div class="col-lg-6">
                <div class="motif-hero-image-box">
                    <img src="/assets/img/motif/hero-motif.png" alt="Motif Tenun Ikat Sumba Barat"
                        class="motif-hero-img">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="motif-list-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">
                Daftar Motif Tenun Ikat Sumba Barat
            </h2>
            <p class="section-subtitle">
                Jelajahi berbagai motif khas beserta makna yang terkandung di dalamnya.
            </p>
        </div>
        <div class="row g-4">
            <?php if ($totalMotif > 0): ?>
                <?php $index = 1; ?>
                <?php while ($m = mysqli_fetch_assoc($queryMotif)): ?>
                    <?php
                    $modalId = "modalMotif" . $index;
                    $gambar = !empty($m['gambar'])
                        ? "/uploads/motif/" . $m['gambar']
                        : "/assets/img/motif/default-motif.jpg";
                    ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="motif-card">
                            <img src="<?= htmlspecialchars($gambar); ?>" alt="<?= htmlspecialchars($m['nama_motif']); ?>"
                                class="motif-card-img">
                            <div class="motif-card-body">
                                <h4><?= htmlspecialchars($m['nama_motif']); ?></h4>
                                <div class="motif-location">
                                    Asal : <?= htmlspecialchars($m['asal_daerah']); ?>
                                </div>
                                <p>
                                    <?= nl2br(htmlspecialchars($m['makna'])); ?>
                                </p>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#<?= $modalId; ?>">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="<?= $modalId; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content motif-modal-content position-relative">
                                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                    data-bs-dismiss="modal" aria-label="Close" style="z-index: 1055;"></button>
                                <div class="modal-body motif-modal-body p-4">
                                    <div class="row g-4">
                                        <div class="col-md-5 d-flex flex-column justify-content-between">
                                            <div>
                                                <div class="motif-modal-image mb-3">
                                                    <img src="<?= htmlspecialchars($gambar); ?>"
                                                        alt="<?= htmlspecialchars($m['nama_motif'] ?? 'Motif'); ?>"
                                                        class="img-fluid">
                                                </div>
                                                 
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="ps-md-2">
                                                <span class="section-badge mb-2">DETAIL MOTIF</span>

                                                <h2 class="motif-title mt-1 mb-2">
                                                    <?= htmlspecialchars($m['nama_motif'] ?? '-'); ?>
                                                </h2>
                                                <div class="mb-3 text-brown">
                                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                    <strong>Asal Daerah :</strong>
                                                    <span
                                                        class="text-danger"><?= htmlspecialchars($m['asal_daerah'] ?? '-'); ?></span>
                                                </div>
                                                <div class="motif-detail-item">
                                                    <h5><i class="bi bi-book"></i> Makna Motif</h5>
                                                    <p class="text-secondary">
                                                        <?= isset($m['makna']) ? nl2br(htmlspecialchars($m['makna'])) : '-'; ?>
                                                    </p>
                                                </div>
                                                <div class="motif-detail-item">
                                                    <h5><i class="bi bi-pencil"></i> Ciri-ciri Motif</h5>
                                                    <ul class="motif-list-checked">
                                                        <?php
                                                        // Antisipasi jika data kosong atau menggunakan pembatas selain baris baru
                                                        $ciri_data = $m['ciri_motif'] ?? ($m['ciri'] ?? '');
                                                        $ciri_items = array_filter(explode("\n", str_replace("\r", "", $ciri_data)));
                                                        if (!empty($ciri_items)):
                                                            foreach ($ciri_items as $item):
                                                                ?>
                                                                <li>
                                                                    <i class="bi bi-check-circle"></i>
                                                                    <span><?= htmlspecialchars(trim($item)); ?></span>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <li class="text-muted">Tidak ada data ciri-ciri.</li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                                <div class="motif-detail-item">
                                                    <h5><i class="bi bi-palette"></i> Warna Dominan</h5>
                                                    <div class="warna-container">
                                                        <?php
                                                        $warna_data = $m['warna_dominan'] ?? ($m['warna'] ?? '');
                                                        $warna_items = array_filter(explode(",", $warna_data));
                                                        
                                                        // Peta warna dasar bahasa Indonesia ke Hex/Warna Web standar
                                                        $color_map = [
                                                            'merah'   => '#b31111',
                                                            'kuning'  => '#ffcc00',
                                                            'hitam'   => '#1a1a1a',
                                                            'putih'   => '#ffffff',
                                                            'cokelat' => '#6b3e26',
                                                            'coklat'  => '#6b3e26',
                                                            'biru'    => '#1f4e79',
                                                            'cream'   => '#f5f5dc',
                                                            'krem'    => '#e6d7b8',
                                                            'hijau'   => '#2e7d32',
                                                            'abu-abu' => '#808080',
                                                            'abu'     => '#808080',
                                                            'jingga'  => '#ff9800',
                                                            'oranye'  => '#ff9800'
                                                        ];

                                                        if (!empty($warna_items)):
                                                            foreach ($warna_items as $warna):
                                                                $trimmed_warna = strtolower(trim($warna));
                                                                
                                                                // Jika terdaftar di map pakai map, jika tidak, pakai namanya langsung sebagai fallback warna CSS (misal input 'red', 'gold', dll)
                                                                $hex_color = $color_map[$trimmed_warna] ?? $trimmed_warna;
                                                                
                                                                // Beri border tipis jika warnanya putih atau cream cerah agar tidak samar dengan background web
                                                                $border_style = (in_array($trimmed_warna, ['putih', 'cream', 'krem'])) ? 'border: 1px solid #ccc;' : '';
                                                                ?>
                                                                <div class="warna-item">
                                                                    <span class="warna-dot"
                                                                        style="background-color: <?= htmlspecialchars($hex_color); ?>; <?= $border_style; ?>"></span>
                                                                    <span class="warna-text"><?= htmlspecialchars(trim($warna)); ?></span>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Tidak ada data warna.</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="motif-detail-item border-0 pb-0">
                                                    <h5><i class="bi bi-award"></i> Penggunaan</h5>
                                                    <div class="penggunaan-badge">
                                                        <?php
                                                        $penggunaan_data = $m['penggunaan'] ?? '';
                                                        $penggunaan_items = array_filter(explode(",", $penggunaan_data));
                                                        if (!empty($penggunaan_items)):
                                                            foreach ($penggunaan_items as $item):
                                                                ?>
                                                                <span><?= htmlspecialchars(trim($item)); ?></span>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">Tidak ada data penggunaan.</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $index++; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="text-center">
                        <p>
                            Data motif dan makna belum tersedia.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php include "../includes/footer.php"; ?>