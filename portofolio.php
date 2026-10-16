<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Jurusan TJKT | SMKN 1 MAJA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00d9ff;
            --bg-dark: #050b14;
            --card-bg: rgba(16, 32, 58, 0.7);
            --border-glow: rgba(0, 217, 255, 0.2);
            --text-light: #dce8f5;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; scroll-behavior: smooth; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-dark); color: #ffffff; overflow-x: hidden; }
        header { position: fixed; top: 0; width: 100%; z-index: 1000; background: rgba(5, 11, 20, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        nav { max-width: 1280px; margin: auto; height: 80px; display: flex; justify-content: space-between; align-items: center; padding: 0 35px; }
        .logo { color: white; font-size: 26px; font-weight: 800; display: flex; align-items: center; gap: 8px; }
        .logo span { color: var(--primary); text-shadow: 0 0 15px rgba(0, 217, 255, 0.5); }
        nav ul { list-style: none; display: flex; gap: 30px; align-items: center; }
        nav ul li a { color: var(--text-light); text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav ul li a:hover { color: var(--primary); }
        section { padding: 120px 8% 90px; position: relative; }
        .hero { min-height: 100vh; display: flex; align-items: center; background: radial-gradient(circle at 80% 20%, rgba(0, 217, 255, 0.15) 0%, transparent 40%), linear-gradient(rgba(5, 11, 20, 0.9), rgba(5, 11, 20, 0.95)), url("https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1600&q=80"); background-size: cover; background-position: center; }
        .hero-content { max-width: 800px; z-index: 2; }
        .hero h1 { font-size: 55px; font-weight: 800; line-height: 1.15; margin-bottom: 25px; }
        .hero h1 span { color: var(--primary); text-shadow: 0 0 30px rgba(0, 217, 255, 0.4); }
        .hero p { font-size: 18px; line-height: 1.8; margin-bottom: 35px; color: var(--text-light); }
        .btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 32px; border-radius: 12px; background: linear-gradient(135deg, #00d9ff, #0284c7); color: #050b14; text-decoration: none; font-weight: 700; font-size: 15px; box-shadow: 0 10px 25px rgba(0, 217, 255, 0.3); transition: 0.3s; }
        .btn:hover { transform: translateY(-4px); box-shadow: 0 15px 35px rgba(0, 217, 255, 0.5); background: white; color: #050b14; }
        .title { text-align: center; margin-bottom: 60px; }
        .title h2 { font-size: 40px; font-weight: 800; color: white; margin-bottom: 12px; }
        .title p { color: #8da4c4; font-size: 16px; }
        .about { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; max-width: 1200px; margin: auto; align-items: center; }
        .about img { width: 100%; border-radius: 24px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4); border: 1px solid var(--border-glow); }
        .about-text { background: var(--card-bg); padding: 40px; border-radius: 24px; backdrop-filter: blur(10px); border: 1px solid var(--border-glow); }
        .about-text h3 { font-size: 30px; margin-bottom: 20px; color: white; }
        .about-text p { line-height: 1.8; color: var(--text-light); margin-bottom: 18px; }
        .guru-container, .materi-container, .project-container { max-width: 1200px; margin: auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
        .guru-card, .project-container > div, .materi { background: var(--card-bg); border-radius: 20px; overflow: hidden; border: 1px solid var(--border-glow); backdrop-filter: blur(10px); transition: 0.3s; }
        .guru-card:hover, .project-container > div:hover, .materi:hover { transform: translateY(-8px); border-color: var(--primary); box-shadow: 0 20px 40px rgba(0, 217, 255, 0.15); }
        .guru-card img, .project-container img { width: 100%; height: 240px; object-fit: cover; }
        .guru-info, .project-content { padding: 25px; }
        .guru-info h3, .project-content h3, .materi h3 { font-size: 20px; color: white; margin-bottom: 10px; }
        .guru-info .jabatan { color: var(--primary); font-weight: 700; font-size: 13px; text-transform: uppercase; margin-bottom: 12px; }
        .guru-info p, .project-content p, .materi p { color: #8da4c4; line-height: 1.6; font-size: 14px; }
        .skill-container { max-width: 1200px; margin: auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
        .skill { background: var(--card-bg); padding: 35px 25px; border-radius: 20px; text-align: center; border: 1px solid var(--border-glow); backdrop-filter: blur(10px); transition: 0.3s; }
        .skill:hover { border-color: var(--primary); transform: translateY(-6px); }
        .skill .icon { font-size: 45px; margin-bottom: 20px; }
        .skill h3 { font-size: 18px; color: white; margin-bottom: 10px; }
        .skill p { color: #8da4c4; font-size: 13px; }
        .data-peralatan { text-align: center; background: linear-gradient(135deg, rgba(16, 32, 58, 0.9), rgba(5, 11, 20, 0.95)); border-radius: 24px; max-width: 1000px; margin: auto; border: 1px solid var(--border-glow); padding: 60px 40px; }
        .contact-box { background: var(--card-bg); padding: 50px; border-radius: 24px; border: 1px solid var(--border-glow); text-align: center; max-width: 900px; margin: auto; }
        .contact-box p { margin: 15px 0; color: var(--text-light); }
        footer { background: #03070d; color: #8da4c4; text-align: center; padding: 40px; border-top: 1px solid rgba(255,255,255,0.05); }
        footer span { color: var(--primary); font-weight: 700; }
        @media (max-width: 900px) {
            nav { padding: 0 20px; }
            nav ul { gap: 14px; }
            .about { grid-template-columns: 1fr; gap: 30px; }
            .guru-container, .materi-container, .project-container { grid-template-columns: repeat(2, 1fr); }
            .skill-container { grid-template-columns: repeat(2, 1fr); }
            .hero h1 { font-size: 44px; }
        }
        @media (max-width: 600px) {
            nav { height: auto; min-height: 80px; padding: 12px 18px; align-items: flex-start; flex-direction: column; }
            nav ul { width: 100%; flex-wrap: wrap; gap: 8px 14px; }
            nav ul li a { font-size: 12px; }
            section { padding: 110px 6% 70px; }
            .hero h1 { font-size: 36px; }
            .hero p { font-size: 16px; }
            .title h2 { font-size: 30px; }
            .guru-container, .materi-container, .project-container, .skill-container { grid-template-columns: 1fr; }
            .about-text, .contact-box { padding: 28px 22px; }
            .data-peralatan { padding: 40px 22px; }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">TJKT<span>.</span></div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#guru">Guru</a></li>
            <li><a href="#kompetensi">Kompetensi</a></li>
            <li><a href="#data-peminjaman">Inventaris</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
    </nav>
</header>

<section class="hero" id="home">
    <div class="hero-content">
        <h1>MENGHUBUNGKAN IDE DENGAN <span>SISTEM CERDAS.</span></h1>
        <p>Teknik Jaringan Komputer dan Telekomunikasi merupakan bidang keahlian unggulan yang mempelajari infrastruktur komputer, routing jaringan, server, keamanan siber, dan teknologi telekomunikasi.</p>
        <a href="#about" class="btn"><i class="fa-solid fa-compass"></i> Jelajahi Website</a>
    </div>
</section>

<section id="about">
    <div class="title"><h2>Tentang Jurusan TJKT</h2><p>Mengenal lebih dekat standar kompetensi dan keunggulan bidang keahlian</p></div>
    <div class="about">
        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1000&q=80" alt="Jaringan">
        <div class="about-text">
            <h3>Teknik Jaringan Komputer & Telekomunikasi</h3>
            <p>TJKT mencakup penguasaan mendalam mengenai arsitektur jaringan komputer modern, instalasi sistem operasi server, konfigurasi perangkat jaringan skala enterprise, hingga sistem komunikasi nirkabel.</p>
            <p>Kurikulum kami memadukan teori fundamental dan praktik langsung di laboratorium, mempersiapkan siswa agar memiliki daya saing tinggi di dunia industri digital global.</p>
        </div>
    </div>
</section>

<section id="guru">
    <div class="title"><h2>Tim Pengajar TJKT</h2><p>Instruktur profesional yang membimbing siswa</p></div>
    <div class="guru-container">
        <div class="guru-card">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80" alt="Guru">
            <div class="guru-info"><h3>Ahmad Fauzi, S.Kom.</h3><div class="jabatan">Guru Jaringan Komputer</div><p>Spesialis routing, switching lanjutan, dan perancangan topologi jaringan.</p></div>
        </div>
        <div class="guru-card">
            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=800&q=80" alt="Guru">
            <div class="guru-info"><h3>Siti Rahma, S.Kom.</h3><div class="jabatan">Guru Administrasi Sistem</div><p>Berpengalaman dalam manajemen sistem operasi jaringan dan konfigurasi server.</p></div>
        </div>
        <div class="guru-card">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80" alt="Guru">
            <div class="guru-info"><h3>Budi Santoso, S.T.</h3><div class="jabatan">Guru Telekomunikasi</div><p>Mengampu bidang teknologi transmisi dan instalasi fiber optik.</p></div>
        </div>
    </div>
</section>

<section id="kompetensi">
    <div class="title"><h2>Kompetensi Utama</h2><p>Keahlian teknis dan vokasi yang dikuasai siswa</p></div>
    <div class="skill-container">
        <div class="skill"><div class="icon">🖥️</div><h3>Hardware</h3><p>Perakitan unit komputer dan perawatan komponen.</p></div>
        <div class="skill"><div class="icon">🌐</div><h3>Networking</h3><p>Konfigurasi LAN, WAN, router, dan switch.</p></div>
        <div class="skill"><div class="icon">🗄️</div><h3>Server Admin</h3><p>Pengelolaan sistem operasi server.</p></div>
        <div class="skill"><div class="icon">💡</div><h3>Fiber Optik</h3><p>Praktik penyambungan kabel optik dan FTTH.</p></div>
    </div>
</section>

<section id="data-peminjaman">
    <div class="data-peralatan">
        <h2>Sistem Manajemen & Inventaris Lab</h2>
        <p>Akses data alat praktik serta data siswa secara transparan dan terintegrasi dengan database.</p>
        <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
            <a href="index.php" class="btn"><i class="fa-solid fa-boxes-stacked"></i> Buka Data Inventaris Alat</a>
            <a href="siswa.php" class="btn" style="background: transparent; border: 2px solid var(--primary); color: var(--primary);"><i class="fa-solid fa-users"></i> Buka Data Siswa</a>
        </div>
    </div>
</section>

<section id="kontak">
    <div class="title"><h2>Kontak Jurusan</h2><p>Hubungi kami untuk informasi lebih lanjut</p></div>
    <div class="contact">
        <div class="contact-box">
            <h3>Teknik Jaringan Komputer & Telekomunikasi</h3>
            <p>🏫 <strong>SMKN 1 MAJA</strong></p>
            <p>📍 Jl. Pasukan Sindangkasih No.155 Maja Selatan - Maja Kab. Majalengka</p>
            <p>📧 tjkt@smkn1maja.sch.id | 📞 0233-282480</p>
            <br>
            <a href="#home" class="btn" style="padding: 10px 20px; font-size: 13px;"><i class="fa-solid fa-arrow-up"></i> Kembali ke Atas</a>
        </div>
    </div>
</section>

<footer><p>© 2026 <span>Jurusan TJKT</span> | Portofolio Teknik Jaringan Komputer dan Telekomunikasi</p></footer>
</body>
</html>