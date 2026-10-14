<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CampusFind Team">
    <meta name="description" content="CampusFind – the easiest way for Nigerian university students to report and recover lost items on campus.">
    <title>CampusFind - Reunite with Your Lost Items</title>
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fa/css/all.min.css">
    <link rel="stylesheet" href="assets/css/theme.css">

    <style>
        :root { --primary: #4f46e5; --primary-light: #6366f1; }
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; background: #ffffff; color: #334155; }

        .header {
            background: rgba(255,255,255,0.9) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226,232,240,0.6);
            box-shadow: 0 1px 10px rgba(15,23,42,0.05) !important;
            position: sticky; top: 0; z-index: 1000;
        }
        .navbar-brand img { height: 40px; transition: transform 0.3s ease; }
        .navbar-brand:hover img { transform: scale(1.05); }
        .nav-link { font-weight: 600; color: #475569 !important; padding: 8px 16px !important; border-radius: 8px; font-size: 0.92rem; transition: all 0.25s ease !important; }
        .nav-link:hover { color: #4f46e5 !important; background: rgba(79,70,229,0.06); }

        .btn-login {
            background: transparent !important; border: 2px solid #4f46e5 !important;
            color: #4f46e5 !important; border-radius: 10px !important;
            font-weight: 600 !important; padding: 8px 20px !important; font-size: 0.9rem !important;
            transition: all 0.3s ease !important;
        }
        .btn-login:hover { background: #4f46e5 !important; color: #fff !important; }

        .btn-get-started {
            background: linear-gradient(135deg, #4f46e5, #6366f1) !important;
            border: none !important; color: #fff !important;
            border-radius: 10px !important; font-weight: 700 !important;
            padding: 8px 24px !important; font-size: 0.9rem !important;
            box-shadow: 0 4px 14px rgba(79,70,229,0.35) !important;
            transition: all 0.3s ease !important;
        }
        .btn-get-started:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(79,70,229,0.45) !important; }

        .hero {
            background: linear-gradient(170deg, #f8fafc 0%, #eef2ff 60%, #e0e7ff 100%);
            padding: 100px 0 90px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute;
            width: 700px; height: 700px; border-radius: 50%;
            background: rgba(79,70,229,0.06);
            top: -300px; left: -200px;
        }
        .hero::after {
            content: ''; position: absolute;
            width: 500px; height: 500px; border-radius: 50%;
            background: rgba(6,182,212,0.06);
            bottom: -200px; right: -150px;
        }
        .hero .container { position: relative; z-index: 2; }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(79,70,229,0.1); color: #4f46e5;
            border-radius: 999px; padding: 5px 16px;
            font-size: 0.8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-weight: 800; font-size: clamp(2.2rem, 5vw, 3.2rem);
            color: #0f172a; letter-spacing: -0.03em; line-height: 1.15;
            margin-bottom: 24px;
        }
        .hero h1 span { color: #4f46e5; }

        .hero p.lead { color: #64748b; font-size: 1.12rem; line-height: 1.7; max-width: 480px; }

        .btn-hero {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff; border: none; border-radius: 14px;
            padding: 1rem 2.5rem; font-size: 1.05rem; font-weight: 700;
            box-shadow: 0 6px 20px rgba(79,70,229,0.35);
            transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-hero:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(79,70,229,0.45); color: #fff; }

        .hero-img {
            border-radius: 24px;
            box-shadow: 0 32px 64px rgba(15,23,42,0.12);
            border: 4px solid rgba(255,255,255,0.8);
            max-height: 480px;
            object-fit: cover;
        }

        .features { padding: 100px 0; background: #fff; }

        .feature-card {
            background: #fff;
            border: 1px solid rgba(226,232,240,0.8);
            border-radius: 20px;
            padding: 2.25rem 1.75rem;
            box-shadow: 0 4px 12px rgba(15,23,42,0.04);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
        }
        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(79,70,229,0.1);
            border-color: rgba(79,70,229,0.15);
        }

        .feature-icon {
            width: 64px; height: 64px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1.25rem;
        }
        .feature-card h5 { font-weight: 700; color: #0f172a; margin-bottom: 10px; font-size: 1.05rem; }
        .feature-card p  { color: #64748b; font-size: 0.92rem; line-height: 1.6; }

        .section-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(79,70,229,0.08); color: #4f46e5;
            border-radius: 999px; font-size: 0.75rem; font-weight: 700;
            padding: 4px 14px; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px;
        }
        .section-heading { font-weight: 800; font-size: 2rem; color: #0f172a; letter-spacing: -0.02em; }
        .section-sub { color: #64748b; font-size: 1rem; max-width: 520px; margin: 0 auto; }

        .how { padding: 100px 0; background: #f8fafc; }

        .step-card {
            background: #fff;
            border: 1px solid rgba(226,232,240,0.8);
            border-radius: 20px;
            padding: 2rem 1.75rem;
            box-shadow: 0 4px 12px rgba(15,23,42,0.04);
            text-align: center;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .step-card::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border-radius: 20px 20px 0 0;
            opacity: 0; transition: opacity 0.3s ease;
        }
        .step-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(79,70,229,0.1); }
        .step-card:hover::before { opacity: 1; }

        .step-num {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff; font-weight: 800; font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .step-card h5 { font-weight: 700; color: #0f172a; margin-bottom: 10px; }
        .step-card p  { color: #64748b; font-size: 0.92rem; line-height: 1.6; }

        .uni-section { padding: 100px 0; background: #fff; }

        .uni-img {
            border-radius: 24px;
            box-shadow: 0 24px 48px rgba(15,23,42,0.1);
            border: 4px solid rgba(255,255,255,0.8);
        }

        .check-list li {
            display: flex; align-items: center; gap: 14px;
            padding: 10px 0;
            font-size: 0.95rem; color: #334155; font-weight: 500;
        }
        .check-icon {
            width: 28px; height: 28px; border-radius: 8px;
            background: #ecfdf5; color: #10b981;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; flex-shrink: 0;
        }

        footer { background: linear-gradient(180deg,#0c1220 0%,#090d16 100%) !important; color:#94a3b8 !important; padding:80px 0 24px !important; border-top:1px solid rgba(255,255,255,0.05); }
        footer h5 { color:#fff !important; font-weight:700 !important; font-size:1rem !important; margin-bottom:1.25rem !important; }
        footer ul.list-unstyled li { margin-bottom:10px; }
        footer a { color:#64748b !important; text-decoration:none !important; font-size:0.9rem; transition:all 0.2s ease !important; display:inline-block; }
        footer a:hover { color:#818cf8 !important; transform:translateX(4px); }
        .footer-logo { width:160px !important; margin-bottom:1.25rem !important; opacity:0.9; }
        .footer-desc { font-size:0.88rem; color:#475569; line-height:1.7; max-width:260px; }
        .footer-divider { border-color:rgba(255,255,255,0.07) !important; margin:2rem 0 1.5rem !important; }
        .footer-copy { color:#334155; font-size:0.85rem; }
        .social-icons { display:flex; gap:16px; margin-top:1.5rem; }
        .social-icons a { width:38px; height:38px; border-radius:10px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.08); display:flex !important; align-items:center; justify-content:center; color:#64748b !important; font-size:1rem; transition:all 0.3s ease !important; }
        .social-icons a:hover { background:rgba(79,70,229,0.25) !important; color:#818cf8 !important; border-color:rgba(79,70,229,0.4) !important; transform:translateY(-3px) !important; }
        .social-icons i { margin:0 !important; font-size:0.95rem !important; }
    </style>
</head>

<body>

<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="index.php">
                <img src="images/logop.png" alt="CampusFind Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#head">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#universities">For Universities</a></li>
                    <li class="nav-item"><a class="nav-link" href="#footer">Contact Us</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="authentication/loginstudent.php" class="btn btn-login">Login</a>
                    <a href="authentication/signupstudent.php" class="btn btn-get-started">Sign Up</a>
                </div>
            </div>
        </nav>
    </div>
</header>

<section class="hero" id="head">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-badge"><i class="fas fa-sparkles"></i> NEVER LOSE AGAIN</div>
                <h1>Reuniting students with their <span>lost belongings</span> on campus.</h1>
                <p class="lead mb-4">
                    Report lost or found items, get smart matches, and recover your belongings safely and quickly.
                </p>
                <a href="authentication/signupstudent.php" class="btn-hero" style="text-decoration: none">
                    Start Reporting Now <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <img src="images/land1.jpg" class="img-fluid hero-img" alt="CampusFind Hero">
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag"><i class="fas fa-bolt"></i> Why CampusFind</div>
            <h2 class="section-heading">Everything you need to find your stuff</h2>
            <p class="section-sub">A modern lost-and-found platform built for campus life.</p>
        </div>
        <div class="row g-4" id="how">
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(79,70,229,0.08);">
                        <i class="fas fa-search" style="color: #4f46e5;"></i>
                    </div>
                    <h5>Easy Reporting</h5>
                    <p class="mb-0">Report lost or found items in less than a minute with our streamlined forms.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(6,182,212,0.08);">
                        <i class="fas fa-map-marker-alt" style="color: #0891b2;"></i>
                    </div>
                    <h5>Smart Matching</h5>
                    <p class="mb-0">Our system helps match reported items with potential owners automatically.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon" style="background: rgba(16,185,129,0.08);">
                        <i class="fas fa-shield-alt" style="color: #10b981;"></i>
                    </div>
                    <h5>Secure & Safe</h5>
                    <p class="mb-0">Verified users and a secure handover process keep items safe.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="how">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag"><i class="fas fa-route"></i> How It Works</div>
            <h2 class="section-heading">Three simple steps to recovery</h2>
            <p class="section-sub">Getting your lost items back has never been easier.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card h-100">
                    <div class="step-num">1</div>
                    <h5>Report It</h5>
                    <p class="mb-0">Submit details of your lost or found item — name, photo, location, and description.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card h-100">
                    <div class="step-num">2</div>
                    <h5>Get Matched</h5>
                    <p class="mb-0">Our system surfaces potential matches from the database of reported items.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card h-100">
                    <div class="step-num">3</div>
                    <h5>Reunite</h5>
                    <p class="mb-0">Collect your item safely through verified campus channels.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="uni-section" id="universities">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="images/land2.jpg" class="img-fluid uni-img" alt="For Universities">
            </div>
            <div class="col-lg-6">
                <div class="section-tag"><i class="fas fa-university"></i> For Universities</div>
                <h2 class="section-heading mb-3">Built for Campus Management</h2>
                <p class="text-muted mb-4" style="font-size: 1.05rem; line-height: 1.7;">
                    Help your students recover lost items while reducing administrative burden on security and lost &amp; found offices.
                </p>
                <ul class="list-unstyled check-list">
                    <li>
                        <span class="check-icon"><i class="fas fa-check"></i></span>
                        Centralized lost &amp; found system
                    </li>
                    <li>
                        <span class="check-icon"><i class="fas fa-check"></i></span>
                        Analytics and reporting dashboard
                    </li>
                    <li>
                        <span class="check-icon"><i class="fas fa-check"></i></span>
                        Integration with student portal
                    </li>
                    <li>
                        <span class="check-icon"><i class="fas fa-check"></i></span>
                        Multi-campus support
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<footer id="footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-12">
                <img src="images/logod.png" alt="CampusFind" class="footer-logo">
                <p class="footer-desc">Helping students across Nigerian universities recover their lost items quickly and safely.</p>
                <div class="social-icons">
                    <a href="#" aria-label="Telegram"><i class="fab fa-telegram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <h5>Platform</h5>
                <ul class="list-unstyled">
                    <li><a href="authentication/loginstudent.php">Browse Items</a></li>
                    <li><a href="authentication/loginstudent.php">Report Found Item</a></li>
                    <li><a href="authentication/loginstudent.php">Report Lost Item</a></li>
                    <li><a href="#how">How It Works</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <h5>Company</h5>
                <ul class="list-unstyled">
                    <li><a href="#head">About Us</a></li>
                    <li><a href="#universities">For Universities</a></li>
                    <li><a href="#footer">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-12">
                <h5>Get In Touch</h5>
                <p style="font-size:0.88rem; margin-bottom:10px;"><i class="fas fa-envelope me-2" style="color:#4f46e5;"></i> hello@campusfind.ng</p>
                <p style="font-size:0.88rem;"><i class="fas fa-phone me-2" style="color:#4f46e5;"></i> +234 803 000 0000</p>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="text-center footer-copy">
            <p class="mb-0">&copy; 2026 CampusFind. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>