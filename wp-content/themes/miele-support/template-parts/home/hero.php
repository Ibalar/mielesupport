<?php

declare(strict_types=1);

/**
 * Hero section for front page
 * Template part: template-parts/home/hero.php
 */
?>

<section class="hero">
    <div class="hero__bg">
        <img src="<?= get_template_directory_uri() ?>/assets/images/hero-bg.jpg" alt="Miele Professional Equipment" loading="eager">
    </div>
    
    <div class="hero__overlay"></div>
    
    <div class="container">
        <div class="hero__content">
            <div class="hero__eyebrow">MINIMIERUNG VON</div>
            
            <h1 class="hero__title">AUSFALLZEITEN</h1>
            
            <p class="hero__text">
                Unsere Spezialisten sorgen dafür, dass Ihre MIELE Professional Anlagen jederzeit einwandfrei funktionieren – 
                schnell, zuverlässig und nach den höchsten Qualitätsstandards.
            </p>
            
            <div class="hero__actions">
                <a href="#tel:+41791234567" class="btn btn--primary">
                    <svg class="btn__icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.5 12.84V15.64C16.5 15.87 16.46 16.09 16.37 16.3C16.29 16.51 16.17 16.7 16.01 16.86C15.85 17.02 15.66 17.15 15.44 17.24C15.23 17.33 15.01 17.38 14.78 17.38C14.26 17.38 13.74 17.27 13.23 17.06C12.73 16.85 12.27 16.55 11.85 16.17C10.15 14.6 8.84 12.85 7.93 10.9C7.02 8.95 6.56 6.89 6.56 4.71C6.56 4.48 6.61 4.27 6.71 4.07C6.81 3.87 6.95 3.71 7.13 3.58C7.31 3.45 7.51 3.35 7.73 3.3C7.95 3.24 8.17 3.23 8.39 3.26C8.83 3.32 9.24 3.48 9.62 3.75C10 4.01 10.33 4.35 10.61 4.76L11.99 6.72C12.08 6.85 12.12 6.99 12.12 7.13C12.12 7.27 12.08 7.41 12 7.54C11.88 7.72 11.71 7.83 11.48 7.88L10.7 7.96C10.85 8.9 11.14 9.81 11.57 10.69C12 11.57 12.57 12.37 13.28 13.09L13.36 12.28C13.39 12.05 13.51 11.85 13.71 11.68C13.84 11.6 13.98 11.56 14.12 11.56C14.26 11.56 14.39 11.6 14.47 11.67L16.41 13.03C16.81 13.31 17.15 13.64 17.43 14.03C17.71 14.42 17.88 14.85 17.95 15.32C17.98 15.5 17.99 15.67 17.97 15.84C17.96 16.02 17.93 16.19 17.88 16.36L16.5 12.84Z" fill="white"/>
                    </svg>
                    JETZT ANRUFEN
                </a>
                
                <a href="/kontakt" class="btn btn--outline">
                    <svg class="btn__icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.25 5.25C2.25 4.46 3.06 4.25 4 4.25H14C14.94 4.25 15.75 4.46 15.75 5.25V14C15.75 14.79 14.94 15 14 15H4C3.06 15 2.25 14.79 2.25 14V5.25Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M2.25 5L9 9.75L15.75 5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    KONTAKT AUFNEHMEN
                </a>
            </div>
        </div>
    </div>
</section>