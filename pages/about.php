<?php
include "../config/database.php";
include "../includes/header.php";
include "../includes/navbar.php";


/** @var mysqli $conn */

/* AMBIL DATA TUJUAN WEBSITE */
$queryTujuan = mysqli_query($conn, "SELECT * FROM about WHERE judul='Tujuan Website' LIMIT 1");
$tujuan = mysqli_fetch_assoc($queryTujuan);

$judul_tujuan = $tujuan ? $tujuan['judul'] : 'Tujuan Website';

$isi_tujuan = $tujuan
    ? $tujuan['isi']
    : 'Website ini dibuat sebagai media informasi untuk memperkenalkan Tenun Ikat Sumba Barat kepada masyarakat luas melalui penyajian informasi sejarah, motif dan makna, proses pembuatan, serta galeri.

Melalui website ini, pengguna dapat lebih mudah mengenal nilai budaya, keindahan motif, serta pentingnya pelestarian Tenun Ikat Sumba Barat sebagai salah satu warisan budaya daerah.';


/* AMBIL DATA HARAPAN WEBSITE */
$queryHarapan = mysqli_query($conn, "SELECT * FROM about WHERE judul='Harapan Website' LIMIT 1");
$harapan = mysqli_fetch_assoc($queryHarapan);

$judul_harapan = $harapan ? $harapan['judul'] : 'Harapan Website';

$isi_harapan = $harapan
    ? $harapan['isi']
    : 'Website ini diharapkan dapat menjadi sarana yang bermanfaat bagi masyarakat untuk mengenal lebih dalam Tenun Ikat Sumba Barat serta mendorong upaya pelestarian agar warisan budaya ini tetap lestari dan dikenal oleh generasi mendatang.

Dengan adanya website ini, informasi mengenai Tenun Ikat Sumba Barat dapat diakses dengan lebih mudah, sehingga nilai budaya yang terkandung di dalamnya dapat terus diperkenalkan kepada masyarakat luas.';
?>

<!-- HERO ABOUT / TUJUAN WEBSITE -->
<section class="about-hero">
    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="section-badge">About</span>

                <h1 class="about-hero-title">
                    <?= htmlspecialchars($judul_tujuan); ?>
                </h1>

                <div class="about-hero-text">
                    <?= nl2br(htmlspecialchars($isi_tujuan)); ?>
                </div>
            </div>

            <div class="col-lg-6">
                <img src="/assets/img/about/rumahadat.png"
                     alt="<?= htmlspecialchars($judul_tujuan); ?>"
                     class="about-hero-img">
            </div>

        </div>

    </div>
</section>


<!-- HARAPAN WEBSITE -->
<section class="about-section">
    <div class="container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <img src="/assets/img/about/about.png"
                     alt="<?= htmlspecialchars($judul_harapan); ?>"
                     class="about-content-img">
            </div>

            <div class="col-lg-6">
                <div class="about-content">
                    <span class="section-badge">HARAPAN</span>

                    <h2>
                        <?= htmlspecialchars($judul_harapan); ?>
                    </h2>

                    <div class="about-content-text">
                        <?= nl2br(htmlspecialchars($isi_harapan)); ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<?php include "../includes/footer.php"; ?>