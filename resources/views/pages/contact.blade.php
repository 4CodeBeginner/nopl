
    @extends('layouts.guest')
    @section('content')
      
<div class="contact-wrapper">
    <div class="contact-card">
        {{-- Logo --}}
        <div class="logo-section">
            <img src="img/emstoys.png" alt="ND Logo" class="contact-logo">
        </div>

        {{-- Header --}}
        <h2 class="section-title">Hubungi Kami</h2>
        <div class="divider"></div>
        <p class="section-subtitle">
            Ada pertanyaan tentang koleksi kami? Kami siap membantu kamu menemukan miniatur diecast impianmu.
        </p>

        {{-- Contact Info Grid --}}
        <div class="contact-grid">
            <div class="contact-item">
                <div class="contact-icon" style="background: #e3f2fd;">📍</div>
                <div class="contact-detail">
                    <h4>Alamat Toko</h4>
                    <p>Jl. Contoh No. 123, Malang, Jawa Timur 65111</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon" style="background: #e8f5e9;">📱</div>
                <div class="contact-detail">
                    <h4>WhatsApp / Telepon</h4>
                    <p>+62 812-3456-7890</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon" style="background: #fff8e1;">📧</div>
                <div class="contact-detail">
                    <h4>Email</h4>
                    <p>info@nddiecast.com</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon" style="background: #fce4ec;">🕐</div>
                <div class="contact-detail">
                    <h4>Jam Operasional</h4>
                    <p>Senin – Sabtu: 09.00 – 21.00 WIB</p>
                </div>
            </div>
        </div>

        {{-- Social Media --}}
        <div class="social-section">
            <h4 class="social-title">Temukan Kami di Media Sosial</h4>
            <div class="social-links">
                <a href="#" class="social-btn instagram">
                    <span class="social-icon">📸</span>
                    <span>Instagram</span>
                </a>
                <a href="#" class="social-btn facebook">
                    <span class="social-icon">📘</span>
                    <span>Facebook</span>
                </a>
                <a href="#" class="social-btn tokopedia">
                    <span class="social-icon">🛒</span>
                    <span>Tokopedia</span>
                </a>
                <a href="#" class="social-btn shopee">
                    <span class="social-icon">🛍️</span>
                    <span>Shopee</span>
                </a>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-section">
            <p>Ingin tanya-tanya langsung? Klik tombol di bawah untuk chat dengan kami!</p>
            <a href="https://wa.me/6281234567890" target="_blank" class="wa-btn">
                💬 Chat via WhatsApp
            </a>
        </div>
    </div>
</div>

<style>
    .contact-wrapper {
    margin-top:-10px;
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

   .contact-wrapper .contact-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 48px 52px;
        max-width: 820px;
        width: 100%;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        animation: fadeInUp 0.5s ease;
    }

   .contact-wrapper .logo-section {
        text-align: center;
        margin-bottom: 24px;
    }

   .contact-wrapper .contact-logo {
        height: 70px;
        object-fit: contain;
    }

   .contact-wrapper .section-title {
        text-align: center;
        font-size: 26px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0 0 10px 0;
        letter-spacing: 0.5px;
    }

   .contact-wrapper .divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #2196F3, #4CAF50);
        margin: 0 auto 14px auto;
        border-radius: 2px;
    }

   .contact-wrapper .section-subtitle {
        text-align: center;
        font-size: 15px;
        color: #666;
        line-height: 1.7;
        margin-bottom: 32px;
    }

    /* Contact Grid */
   .contact-wrapper .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 30px;
    }

   .contact-wrapper .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 18px 16px;
        background: #f9f9f9;
        border-radius: 12px;
        border: 1px solid #eeeeee;
        transition: box-shadow 0.2s, transform 0.2s;
    }

   .contact-wrapper .contact-item:hover {
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .contact-wrapper .contact-icon {
        font-size: 24px;
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-wrapper .contact-detail h4 {
        margin: 0 0 4px 0;
        font-size: 13px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

   .contact-wrapper .contact-detail p {
        margin: 0;
        font-size: 14.5px;
        color: #222;
        font-weight: 500;
        line-height: 1.5;
    }

    /* Social Media */
    .contact-wrapper .social-section {
        text-align: center;
        margin-bottom: 28px;
    }

   .contact-wrapper .social-title {
        font-size: 14px;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin: 0 0 16px 0;
    }

   .contact-wrapper .social-links {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .contact-wrapper .social-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        transition: opacity 0.2s, transform 0.2s;
    }

   .contact-wrapper .social-btn:hover {
        opacity: 0.88;
        transform: translateY(-1px);
        color: #fff;
    }

    .contact-wrapper .social-btn.instagram { background: linear-gradient(135deg, #e1306c, #833ab4); }
    .contact-wrapper .social-btn.facebook  { background: #1877f2; }
   .contact-wrapper  .social-btn.tokopedia { background: #42b549; }
    .contact-wrapper .social-btn.shopee    { background: #f05d21; }

   .contact-wrapper .social-icon { font-size: 16px; }

    /* CTA */
    .contact-wrapper .cta-section {
        text-align: center;
        padding: 24px;
        background: #f0fdf4;
        border-radius: 12px;
        border: 1px solid #c6f6d5;
    }

    .contact-wrapper .cta-section p {
        margin: 0 0 14px 0;
        font-size: 15px;
        color: #444;
    }

    .contact-wrapper .wa-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #25D366;
        color: #fff;
        padding: 12px 28px;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.2s, transform 0.2s;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);
    }

    .contact-wrapper .wa-btn:hover {
        background: #1ebe59;
        transform: translateY(-2px);
        color: #fff;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 600px) {
       .contact-wrapper  .contact-card { padding: 32px 20px; }
        .contact-wrapper .contact-grid { grid-template-columns: 1fr; }
       .contact-wrapper  .section-title { font-size: 22px; }
    }
</style>
@endsection