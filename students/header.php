<style>
/* Student navbar overrides */
.header {
    background: rgba(255, 255, 255, 0.85) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    box-shadow: 0 1px 12px rgba(15, 23, 42, 0.06) !important;
}

.navbar-brand img {
    height: 40px !important;
    transition: transform 0.3s ease;
}

.navbar-brand:hover img { transform: scale(1.05); }

.nav-link {
    font-weight: 600;
    color: #475569 !important;
    padding: 6px 14px !important;
    border-radius: 8px;
    transition: all 0.25s ease !important;
    font-size: 0.92rem;
    margin: 0 3px;
}

.nav-link:hover {
    color: #4f46e5 !important;
    background: rgba(79, 70, 229, 0.08);
}

.nav-home {
    color: #4f46e5 !important;
    background: rgba(79, 70, 229, 0.1) !important;
    text-decoration: none !important;
}

.btn-login {
    background: transparent !important;
    border: 2px solid #4f46e5 !important;
    color: #4f46e5 !important;
    border-radius: 10px !important;
    font-weight: 600 !important;
    padding: 8px 18px !important;
    font-size: 0.9rem !important;
    transition: all 0.3s ease !important;
}

.btn-login:hover {
    background: #4f46e5 !important;
    color: #fff !important;
}
</style>
