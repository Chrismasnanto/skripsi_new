<?php
include "config/database.php";
include "includes/header.php";
include "includes/navbar.php";

$query = mysqli_query($conn, "SELECT * FROM beranda ORDER BY id_beranda DESC LIMIT 1");
$data = mysqli_fetch_assoc($query);

$judul = $data ? $data['judul'] : 'Tenun Ikat Sumba Barat';

$deskripsi = $data ? $data['deskripsi'] : 'Website ini menyajikan informasi mengenai sejarah, motif dan makna, proses pembuatan, serta galeri Tenun Ikat Sumba Barat sebagai media informasi budaya yang mudah diakses masyarakat.';

$gambar = ($data && !empty($data['gambar']))
    ? "/uploads/beranda/" . $data['gambar']
    : "/assets/img/beranda/hero.png";
?>

<!-- HERO SECTION -->
<section class="home-hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="section-badge">MEDIA INFORMASI BUDAYA</span>

                <h1 class="home-hero-title">
                    <?= htmlspecialchars($judul); ?>
                </h1>

                <p class="home-hero-text">
                    <?= nl2br(htmlspecialchars($deskripsi)); ?>
                </p>

                <div class="hero-actions">
                    <a href="/pages/sejarah.php" class="btn-dark-custom">
                        Jelajahi Sejarah
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-image-box">
                    <img src="<?= htmlspecialchars($gambar); ?>"
                        alt="<?= htmlspecialchars($judul); ?>"
                        class="home-hero-img">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- IDENTITAS SUMBA BARAT -->
<section class="home-identity">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-label">
                IDENTITAS BUDAYA
            </span>
            <h2 class="section-title">
                Kekayaan Budaya Sumba Barat
            </h2>
            <p class="section-subtitle">
                Tenun Ikat tidak dapat dipisahkan dari kehidupan masyarakat Sumba Barat.
                Tradisi, simbol adat, dan karya tenun menjadi identitas budaya yang terus
                diwariskan dari generasi ke generasi.
            </p>

        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="identity-card">
                    <img src="/assets/img/beranda/RumahAdat1.png"
                        class="identity-image">
                    <h4>Rumah Adat</h4>
                    <p>
                        Rumah adat menjadi pusat kehidupan masyarakat serta simbol
                        persatuan keluarga di Sumba Barat.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="identity-card">
                    <img src="/assets/img/beranda/TradisiPasola.png"
                        class="identity-image">
                    <h4>Tradisi Pasola</h4>
                    <p>
                        Pasola merupakan tradisi perang berkuda yang menjadi ikon budaya
                        dan daya tarik wisata Sumba Barat.
                    </p>
                </div>
            </div>

            <div class="col-md-4">

                <div class="identity-card">
                    <img src="/assets/img/beranda/Mamuli.png"
                        class="identity-image">
                    <h4>Mamuli</h4>
                    <p>
                        Mamuli merupakan simbol kesuburan, kehidupan, serta penghormatan
                        terhadap perempuan dalam budaya Sumba Barat.
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- PENGENALAN TENUN IKAT -->
<section class="home-about">
    <div class="container">

        <div class="text-center mb-5">
            <span class="section-label">TENTANG TENUN IKAT</span>

            <h2 class="section-title">
                Mengenal Tenun Ikat Sumba Barat
            </h2>

            <p class="section-subtitle">
                Tenun Ikat Sumba Barat merupakan warisan budaya yang memiliki nilai sejarah,
                keindahan motif, filosofi kehidupan, serta menjadi identitas masyarakat yang
                tetap dilestarikan hingga saat ini.
            </p>
        </div>

        <div class="row align-items-center g-5">

            <div class="col-lg-5">
                <img src="/assets/img/beranda/tentang.png"
                    alt="Mengenal Tenun Ikat Sumba Barat"
                    class="about-img">
            </div>

            <div class="col-lg-7">

                <div class="about-point">
                    <div class="about-icon">
                        <i class="bi bi-flower1"></i>
                    </div>

                    <div>
                        <h5>Warisan Budaya</h5>
                        <p>
                            Tenun Ikat diwariskan secara turun-temurun dan menjadi 
                            bagian penting dalam kehidupan masyarakat adat Sumba Barat.
                        </p>
                    </div>
                </div>

                <div class="about-point">
                    <div class="about-icon">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>

                    <div>
                        <h5>Makna Simbolis</h5>
                        <p>
                            Setiap motif memiliki simbol yang menggambarkan 
                            kehidupan, alam, leluhur, serta nilai sosial masyarakat.
                        </p>
                    </div>
                </div>

                <div class="about-point">
                    <div class="about-icon">
                        <i class="bi bi-stars"></i>
                    </div>

                    <div>
                        <h5>Keterampilan Tradisional</h5>
                        <p>
                            Proses menenun dilakukan secara tradisional 
                            dengan ketelitian dan keterampilan yang diwariskan dari generasi ke generasi.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>


<!-- INFORMASI WEBSITE -->
<section class="home-info">
    <div class="container">

        <div class="text-center mb-5">
            <span class="section-label">INFORMASI WEBSITE</span>

            <h2 class="section-title">
                Temukan Informasi Menarik
            </h2>

            <p class="section-subtitle">
                Website ini menyediakan informasi utama mengenai Tenun Ikat Sumba Barat
                melalui beberapa halaman yang dapat diakses dengan mudah.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6 col-lg">
                <div class="info-card">
                    <img src="/assets/img/cards/sejarah.png" alt="Sejarah">

                    <div class="info-card-body">
                        <h5>Sejarah</h5>
                        <p>
                            Ketahui asal usul, perkembangan, serta peran Tenun Ikat dalam kehidupan masyarakat Sumba Barat.
                        </p>

                        <a href="/pages/sejarah.php">
                            Lihat Selengkapnya
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg">
                <div class="info-card">
                    <img src="/assets/img/cards/motif.png" alt="Motif & Makna">

                    <div class="info-card-body">
                        <h5>Motif & Makna</h5>
                        <p>
                            Pelajari nama motif, ciri-ciri visual, warna dominan, asal daerah, 
                            dan makna filosofis Tenun Ikat Sumba Barat.
                        </p>

                        <a href="/pages/motif_makna.php">
                            Lihat Selengkapnya
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg">
                <div class="info-card">
                    <img src="/assets/img/cards/proses.png" alt="Proses Pembuatan">

                    <div class="info-card-body">
                        <h5>Proses Pembuatan</h5>
                        <p>
                            Pelajari setiap tahapan pembuatan Tenun Ikat mulai dari persiapan benang hingga proses penenunan.
                        </p>

                        <a href="/pages/proses_pembuatan.php">
                            Lihat Selengkapnya
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg">
                <div class="info-card">
                    <img src="/assets/img/cards/galeri.png" alt="Galeri">

                    <div class="info-card-body">
                        <h5>Galeri</h5>
                        <p>
                            Lihat dokumentasi berbagai motif, aktivitas menenun, dan kekayaan budaya Sumba Barat.
                        </p>

                        <a href="/pages/galeri.php">
                            Lihat Selengkapnya
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg">
                <div class="info-card">
                    <img src="/assets/img/cards/about.png" alt="About">

                    <div class="info-card-body">
                        <h5>About</h5>
                        <p>
                            Informasi mengenai tujuan website sebagai media pelestarian budaya Tenun Ikat Sumba Barat.
                        </p>

                        <a href="/pages/about.php">
                            Lihat Selengkapnya
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>