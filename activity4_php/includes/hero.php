<?php // Landing page hero section ?>
<section id="home" class="hero-section">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 text-center text-lg-start">
                        <p id="welcome-message" class="text-info mb-2 fs-4" aria-live="polite">Welcome, <?= htmlspecialchars($_SESSION['authenticated_user'] ?? 'Adventurer', ENT_QUOTES, 'UTF-8') ?>!</p>
                        <h1 class="hero-title mb-4">RETH'S STRANGE JOURNEY</h1>
                        <p class="mb-4 text-light fs-4">
                            Step into a 16-bit retro realm full of magical anomalies, pixelated landscapes, and intense tactical battles. Guide Reth through an unpredictable quest across digital dimensions!
                        </p>
                        <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                            <a href="#overworld" class="btn-pixel">Explore World</a>
                            <a href="#characters" class="btn-pixel btn-pixel-secondary" aria-label="Read the character lore">Lore Book</a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="pixel.jpg" alt="Pixel-art game scene from Reth's Strange Journey" class="img-fluid pixel-art-frame rounded">
                    </div>
                </div>
            </div>
        </section>
