<?php
// Standard header component for all pages
// Include this file after the opening <body> tag
?>
<header class="header-section">
    <div class="container">
        <div class="header-flex">
            <div class="logo-container">
                <img src="images/Guni_Logo.png" alt="Ganpat University Logo" width="60" height="40">
            </div>
            <h1 class="site-title">Campus Lost and Found</h1>
        </div>
    </div>
</header>

<style>
.header-section {
    background: #111;
    color: #fff;
    padding: 20px 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.header-section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.header-flex {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 20px;
}

.logo-container {
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.logo-container img {
    width: 60px;
    height: 40px;
    object-fit: contain;
    object-position: center;
    background: #fff;
    padding: 6px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}

.logo-container img:hover {
    transform: scale(1.05);
}

.site-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    letter-spacing: 1px;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    line-height: 1.2;
}

/* Responsive design */
@media (max-width: 768px) {
    .header-flex {
        gap: 15px;
    }
    
    .site-title {
        font-size: 1.5rem;
    }
    
    .logo-container img {
        width: 50px;
        height: 35px;
    }
}

@media (max-width: 480px) {
    .header-section .container {
        padding: 0 15px;
    }
    
    .site-title {
        font-size: 1.3rem;
    }
    
    .logo-container img {
        width: 45px;
        height: 30px;
    }
}
</style>