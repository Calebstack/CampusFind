<?php
$is_auth_dir = (strpos($_SERVER['SCRIPT_NAME'], 'authentication') !== false);
?>
<style>
footer {
    background: linear-gradient(180deg, #0c1220 0%, #090d16 100%) !important;
    color: #94a3b8 !important;
    padding: 80px 0 24px !important;
    border-top: 1px solid rgba(255,255,255,0.05);
}

footer h5 {
    color: #fff !important;
    font-weight: 700 !important;
    font-size: 1rem !important;
    margin-bottom: 1.25rem !important;
}

footer ul.list-unstyled li {
    margin-bottom: 10px;
}

footer a {
    color: #64748b !important;
    text-decoration: none !important;
    font-size: 0.9rem;
    transition: all 0.2s ease !important;
    display: inline-block;
}

footer a:hover {
    color: #818cf8 !important;
    transform: translateX(4px);
}

.footer-logo {
    width: 160px !important;
    margin-bottom: 1.25rem !important;
    opacity: 0.9;
}

.footer-desc {
    font-size: 0.88rem;
    color: #475569;
    line-height: 1.7;
    max-width: 260px;
}

.footer-divider {
    border-color: rgba(255,255,255,0.07) !important;
    margin: 2rem 0 1.5rem !important;
}

.footer-copy {
    color: #334155;
    font-size: 0.85rem;
}

.social-icons {
    display: flex;
    gap: 16px;
    margin-top: 1.5rem;
}

.social-icons a {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    display: flex !important;
    align-items: center;
    justify-content: center;
    color: #64748b !important;
    font-size: 1rem;
    transition: all 0.3s ease !important;
    transform: none !important;
}

.social-icons a:hover {
    background: rgba(79, 70, 229, 0.25) !important;
    color: #818cf8 !important;
    border-color: rgba(79, 70, 229, 0.4) !important;
    transform: translateY(-3px) !important;
}

.social-icons i {
    margin: 0 !important;
    font-size: 0.95rem !important;
}
</style>

<footer id="footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-12">
                <img src="../images/logod.png" alt="CampusFind" class="footer-logo">
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
                    <li><a href="<?php echo $is_auth_dir ? 'loginstudent.php' : 'categories.php'; ?>">Browse Items</a></li>
                    <li><a href="<?php echo $is_auth_dir ? 'loginstudent.php' : 'reportfound.php'; ?>">Report Found Item</a></li>
                    <li><a href="#">How It Works</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4 col-6">
                <h5>Company</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">For Universities</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4 col-12">
                <h5>Get In Touch</h5>
                <p style="font-size: 0.88rem; margin-bottom: 10px;"><i class="fas fa-envelope me-2" style="color:#4f46e5;"></i> hello@campusfind.ng</p>
                <p style="font-size: 0.88rem;"><i class="fas fa-phone me-2" style="color:#4f46e5;"></i> +234 803 000 0000</p>
            </div>
        </div>

        <hr class="footer-divider">
        <div class="text-center footer-copy">
            <p class="mb-0">&copy; 2026 CampusFind. All Rights Reserved.</p>
        </div>
    </div>
</footer>