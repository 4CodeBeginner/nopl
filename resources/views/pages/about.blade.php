
    @extends('layouts.guest')
    @section('content')
  
<div class="about-wrapper">
    <div class="about-card">
        {{-- Logo --}}
        <div class="logo-section">
            <img src="/img/emstoys.png" alt="ND Logo" class="about-logo">
        </div>

        {{-- About Content --}}
        <div class="about-content">
            <h2 class="section-title">Tentang Kami</h2>
            <div class="divider"></div>

            <p class="about-lead">
                Kami menyediakan berbagai macam miniatur kendaraan berbahan <strong>diecast</strong>
                dengan kualitas terbaik dan detail presisi tinggi.
            </p>

            <p class="about-desc">
                Koleksi kami mencakup miniatur mobil, motor, dan berbagai jenis kendaraan lainnya
                dari beragam merek ternama dunia, tersedia dalam berbagai pilihan skala
                yang cocok untuk kolektor pemula hingga profesional.
            </p>

            {{-- Feature Highlights --}}
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">🏎️</div>
                    <div class="feature-text">
                        <h4>Koleksi Lengkap</h4>
                        <p>Mobil, motor, truk, dan kendaraan langka dari berbagai era</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🌍</div>
                    <div class="feature-text">
                        <h4>Merek Ternama Dunia</h4>
                        <p>Hot Wheels, Tomica, Matchbox, Maisto, Welly, dan masih banyak lagi</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📏</div>
                    <div class="feature-text">
                        <h4>Berbagai Skala</h4>
                        <p>Tersedia dalam skala 1:18, 1:24, 1:43, 1:64 dan lainnya</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">⭐</div>
                    <div class="feature-text">
                        <h4>Kualitas Terjamin</h4>
                        <p>Setiap produk dipilih dengan teliti untuk memastikan detail dan kualitas terbaik</p>
                    </div>
                </div>
            </div>

            <div class="about-tagline">
                <p>"Dari kolektor pemula hingga profesional — temukan koleksi impianmu di sini."</p>
            </div>
        </div>
    </div>
</div>

<style>
    .about-wrapper {
    min-height: calc(100vh - 70px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background:
        linear-gradient(
            120deg,
            #2eb82e 0%,
            #2eb82e 28%,

            #f5f5f5 28%,
            #f5f5f5 32%,

            #0b57a4 32%,
            #0b57a4 58%,

            #f5f5f5 58%,
            #f5f5f5 62%,

            #f0d000 62%,
            #f0d000 84%,

            #f5f5f5 84%,
            #f5f5f5 88%,

            #e60012 88%,
            #e60012 100%
        );
}


    .about-wrapper .about-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 48px 52px;
        max-width: 820px;
        width: 100%;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        animation: fadeInUp 0.5s ease;
    }

    .about-wrapper .logo-section {
        text-align: center;
        margin-bottom: 28px;
    }

    .about-wrapper .about-logo {
        height: 70px;
        object-fit: contain;
    }

    .about-wrapper .section-title {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 10px 0;
        letter-spacing: 0.5px;
    }

    .about-wrapper .divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #2196F3, #4CAF50);
        margin: 0 auto 28px auto;
        border-radius: 2px;
    }

    .about-wrapper .about-lead {
        text-align: center;
        font-size: 16.5px;
        font-weight: 600;
        color: #222;
        line-height: 1.7;
        margin-bottom: 14px;
    }

   .about-wrapper .about-desc {
        text-align: center;
        font-size: 15px;
        color: #555;
        line-height: 1.8;
        margin-bottom: 36px;
    }

    .about-wrapper .features-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 32px;
    }

    .about-wrapper .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: #f8f9fa;
        border-radius: 10px;
        padding: 18px 16px;
        border-left: 4px solid #2196F3;
        transition: transform 0.2s;
    }

    .about-wrapper .feature-item:hover {
        transform: translateY(-2px);
    }

    .about-wrapper .feature-item:nth-child(2) { border-left-color: #4CAF50; }
    .about-wrapper .feature-item:nth-child(3) { border-left-color: #FFC107; }
    .about-wrapper .feature-item:nth-child(4) { border-left-color: #F44336; }

   .about-wrapper .feature-icon {
        font-size: 28px;
        flex-shrink: 0;
    }

    .about-wrapper .feature-text h4 {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
    }

   .about-wrapper .feature-text p {
        margin: 0;
        font-size: 13px;
        color: #666;
        line-height: 1.5;
    }

    .about-wrapper .about-tagline {
        text-align: center;
        padding: 20px 30px;
        background: linear-gradient(135deg,
        rgba(rgba(33, 150, 243, 0.18),
            rgba(76, 175, 80, 0.18)) #f0f7ff, #f0fff4);
        border-radius: 10px;
        border: 1px solid #e0edf8;
    }

   .about-wrapper .about-tagline p {
        margin: 0;
        font-size: 15px;
        font-style: italic;
        color: #444;
        font-weight: 500;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
        .about-wrapper .about-card { padding: 32px 24px; }
        .about-wrapper .features-grid { grid-template-columns: 1fr; }
       .about-wrapper .section-title { font-size: 22px; }
    }
</style>
@endsection
