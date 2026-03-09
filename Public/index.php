<?php
session_start();
require_once __DIR__ . '/../Includes/db.php';
require_once __DIR__ . '/../Includes/visitor_tracker.php';

// Track visitor
trackVisitor($conn);

// Get articles from database
$result = $conn->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindaNow - Discover Mindanao</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600;700&family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
:root {
    --forest: #1a3a2a;
    --emerald: #2d6a4f;
    --lime: #74c69d;
    --sand: #f4e9d8;
    --ochre: #d4a253;
    --rust: #c25e35;
    --cream: #fdf8f2;
    --charcoal: #1c1c1c;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--charcoal);
    overflow-x: hidden;
}

/* navbar */
.navbar {
    position: fixed; top: 0; width: 100%; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 3rem;
    background: rgba(26,58,42,0.95);
    backdrop-filter: blur(12px);
}
.logo {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 2rem; letter-spacing: 3px;
    color: var(--lime); text-decoration: none;
}
.logo span { color: var(--ochre); }
.nav-links { display: flex; gap: 2rem; list-style: none; }
.nav-links a {
    color: rgba(255,255,255,0.8); text-decoration: none;
    font-size: 0.85rem; font-weight: 500; letter-spacing: 1px;
    text-transform: uppercase; transition: color 0.2s;
}
.nav-links a:hover { color: var(--lime); }

/* hero */
.hero {
    position: relative; height: 100vh;
    background: linear-gradient(160deg, var(--forest) 0%, #0d2416 100%);
    display: flex; align-items: center; overflow: hidden;
}
.hero-bg {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 70% 60%, rgba(45,106,79,0.4) 0%, transparent 60%);
}
.hero-content {
    position: relative; z-index: 2;
    padding: 0 3rem; max-width: 700px;
}
.hero-tag {
    display: inline-block;
    background: rgba(116,198,157,0.15); border: 1px solid rgba(116,198,157,0.3);
    color: var(--lime); font-size: 0.75rem; letter-spacing: 3px;
    text-transform: uppercase; padding: 0.4rem 1rem; border-radius: 1px;
    margin-bottom: 1.5rem;
}
.hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(3.5rem, 7vw, 6rem);
    font-weight: 900; line-height: 1.0;
    color: #fff; margin-bottom: 1.5rem;
}
.hero h1 em { color: var(--ochre); font-style: italic; }
.hero p {
    color: rgba(255,255,255,0.65); font-size: 1.1rem;
    line-height: 1.7; max-width: 480px; margin-bottom: 2.5rem;
}
.btn-primary {
    background: var(--ochre); color: var(--forest);
    padding: 0.9rem 2rem; font-weight: 700;
    font-size: 0.9rem; letter-spacing: 1px; text-transform: uppercase;
    border: none; cursor: pointer; border-radius: 2px;
    transition: transform 0.2s, background 0.2s;
    text-decoration: none; display: inline-block;
}
.btn-primary:hover { background: var(--lime); transform: translateY(-2px); }

/* section */
.section { padding: 5rem 3rem; }
.section-label {
    font-size: 0.72rem; letter-spacing: 4px; text-transform: uppercase;
    color: var(--emerald); font-weight: 600; margin-bottom: 0.6rem;
}
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3vw, 2.8rem); font-weight: 700;
    color: var(--forest); line-height: 1.2; margin-bottom: 3rem;
}

/* destinations grid */
.dest-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}
.dest-card {
    border-radius: 4px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    background: #fff; cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
    text-decoration: none; color: inherit; display: block;
}
.dest-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.14); }
.card-img-placeholder {
    width: 100%; height: 200px;
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem;
}
.g1 { background: linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 100%); }
.g2 { background: linear-gradient(135deg, #1a2e4a 0%, #2a4d6e 100%); }
.g3 { background: linear-gradient(135deg, #3a2010 0%, #6e4020 100%); }
.g4 { background: linear-gradient(135deg, #2a3a10 0%, #4e6e20 100%); }
.g5 { background: linear-gradient(135deg, #2a1040 0%, #4e2e70 100%); }
.g6 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.card-body { padding: 1.3rem 1.5rem 1.6rem; }
.card-loc {
    font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase;
    color: var(--emerald); font-weight: 600; margin-bottom: 0.4rem;
}
.card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem; font-weight: 700; color: var(--forest);
    margin-bottom: 0.5rem; line-height: 1.3;
}
.card-desc {
    font-size: 0.85rem; color: #666; line-height: 1.6;
}

/* cuisine */
.cuisine-section { background: var(--sand); padding: 5rem 3rem; }
.cuisine-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-top: 3rem; }
.cuisine-card {
    background: #fff; border-radius: 4px; overflow: hidden;
    text-align: center; padding: 2rem 1rem 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
}
.cuisine-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.cuisine-emoji { font-size: 2.8rem; margin-bottom: 0.8rem; display: block; }
.cuisine-name {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700; color: var(--forest); margin-bottom: 0.4rem;
}
.cuisine-origin { font-size: 0.75rem; color: #999; letter-spacing: 1px; text-transform: uppercase; }

/* footer */
footer {
    background: var(--charcoal); color: rgba(255,255,255,0.5);
    padding: 3rem 3rem 2rem;
    display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem;
}
.footer-brand .logo { margin-bottom: 1rem; display: block; }
.footer-brand p { font-size: 0.82rem; line-height: 1.7; max-width: 260px; }
.footer-col h4 {
    font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase;
    color: rgba(255,255,255,0.8); margin-bottom: 1rem; font-weight: 600;
}
.footer-col a {
    display: block; color: rgba(255,255,255,0.45);
    text-decoration: none; font-size: 0.83rem; margin-bottom: 0.5rem;
    transition: color 0.2s;
}
.footer-col a:hover { color: var(--lime); }
.footer-bottom {
    background: var(--charcoal); padding: 1rem 3rem;
    border-top: 1px solid rgba(255,255,255,0.07);
    font-size: 0.78rem; color: rgba(255,255,255,0.25);
    text-align: center;
}

@media (max-width: 768px) {
    .navbar { padding: 1rem; }
    .nav-links { display: none; }
    .hero { height: 70vh; }
    .hero-content { padding: 0 1.5rem; }
    .section { padding: 3rem 1.5rem; }
    .dest-grid { grid-template-columns: 1fr; }
    .cuisine-grid { grid-template-columns: repeat(2, 1fr); }
    footer { grid-template-columns: 1fr; gap: 2rem; }
}
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="logo">Minda<span>Now</span></a>
    <ul class="nav-links">
        <li><a href="#home">Home</a></li>
        <li><a href="#blog">Blog</a></li>
        <li><a href="#destinations">Destinations</a></li>
        <li><a href="#map">Map</a></li>
        <li><a href="#cuisine">Cuisine</a></li>
        <li><a href="#events">Events</a></li>
        <li><a href="#gallery">Gallery</a></li>
        <li><a href="#advisories">Advisories</a></li>
    </ul>
</nav>

<!-- HERO -->
<section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-tag">Discover Mindanao</div>
        <h1>The <em>Soul</em><br>of the South</h1>
        <p>Your ultimate guide to Mindanao's best destinations, culture, and hidden gems.</p>
        <a href="#destinations" class="btn-primary">Explore Destinations</a>
    </div>
</section>

<!-- DESTINATIONS -->
<section class="section" id="blog">
    <div class="section-label">Latest Stories</div>
    <div class="section-title">Blog Articles</div>
    
    <div class="dest-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php $colors = ['g1', 'g2', 'g3', 'g4', 'g5', 'g6']; $i = 0; ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="articles.php?id=<?php echo $row['id']; ?>" class="dest-card">
                    <div class="card-img-placeholder <?php echo $colors[$i % 6]; ?>">
                        <span>📰</span>
                    </div>
                    <div class="card-body">
                        <div class="card-loc">
                            <i class="fa-solid fa-calendar"></i> 
                            <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                        </div>
                        <div class="card-title">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </div>
                        <div class="card-desc">
                            <?php 
                                $excerpt = strip_tags($row['content']);
                                echo htmlspecialchars(substr($excerpt, 0, 100)) . '...';
                            ?>
                        </div>
                    </div>
                </a>
                <?php $i++; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                <p style="color: #999;">No articles yet. Check back soon!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- DESTINATION GUIDES -->
<section class="section" id="destinations" style="background: #fff;">
    <div class="section-label">Travel Guides</div>
    <div class="section-title">Popular Destinations</div>
    
    <div class="dest-grid">
        <div class="dest-card">
            <div class="card-img-placeholder g1"><span>🏖️</span></div>
            <div class="card-body">
                <div class="card-loc"><i class="fa-solid fa-location-dot"></i> Sarangani Province</div>
                <div class="card-title">Gumasa Beach</div>
                <div class="card-desc">White sand paradise with crystal clear waters perfect for island hopping.</div>
            </div>
        </div>
        <div class="dest-card">
            <div class="card-img-placeholder g2"><span>⛰️</span></div>
            <div class="card-body">
                <div class="card-loc"><i class="fa-solid fa-location-dot"></i> Davao del Sur</div>
                <div class="card-title">Mount Apo</div>
                <div class="card-desc">Philippines' highest peak offering challenging treks and stunning views.</div>
            </div>
        </div>
        <div class="dest-card">
            <div class="card-img-placeholder g3"><span>🏛️</span></div>
            <div class="card-body">
                <div class="card-loc"><i class="fa-solid fa-location-dot"></i> Zamboanga City</div>
                <div class="card-title">Fort Pilar</div>
                <div class="card-desc">17th-century Spanish colonial fort and religious shrine.</div>
            </div>
        </div>
        <div class="dest-card">
            <div class="card-img-placeholder g4"><span>🌊</span></div>
            <div class="card-body">
                <div class="card-loc"><i class="fa-solid fa-location-dot"></i> Camiguin</div>
                <div class="card-title">White Island</div>
                <div class="card-desc">Stunning sandbar with panoramic views of Mount Hibok-Hibok.</div>
            </div>
        </div>
        <div class="dest-card">
            <div class="card-img-placeholder g5"><span>💧</span></div>
            <div class="card-body">
                <div class="card-loc"><i class="fa-solid fa-location-dot"></i> Bukidnon</div>
                <div class="card-title">Limunsudan Falls</div>
                <div class="card-desc">Tallest waterfall in the Philippines hidden in lush forests.</div>
            </div>
        </div>
        <div class="dest-card">
            <div class="card-img-placeholder g6"><span>🌺</span></div>
            <div class="card-body">
                <div class="card-loc"><i class="fa-solid fa-location-dot"></i> Davao City</div>
                <div class="card-title">Eden Nature Park</div>
                <div class="card-desc">Highland retreat with gardens and eco-adventure activities.</div>
            </div>
        </div>
    </div>
</section>

<!-- INTERACTIVE MAP -->
<section class="section" id="map" style="background: var(--forest); color: white;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div class="section-label" style="color: var(--lime);">Explore Geographically</div>
        <div class="section-title" style="color: white;">Interactive Map of Mindanao</div>
        
        <div style="background: rgba(0,0,0,0.3); border-radius: 8px; padding: 3rem; text-align: center; border: 1px solid rgba(116,198,157,0.2);">
            <i class="fas fa-map-marked-alt" style="font-size: 4rem; color: var(--lime); opacity: 0.5; margin-bottom: 1rem;"></i>
            <p style="color: rgba(255,255,255,0.7); font-size: 1.1rem;">Interactive map coming soon</p>
            <p style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">Explore destinations, routes, and points of interest across Mindanao</p>
        </div>
    </div>
</section>

<!-- GALLERY -->
<section class="section" id="gallery">
    <div class="section-label">Visual Journey</div>
    <div class="section-title">Photo & Video Gallery</div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div style="height: 200px; border-radius: 4px; overflow: hidden;">
            <div class="card-img-placeholder g1"></div>
        </div>
        <div style="height: 200px; border-radius: 4px; overflow: hidden;">
            <div class="card-img-placeholder g2"></div>
        </div>
        <div style="height: 200px; border-radius: 4px; overflow: hidden;">
            <div class="card-img-placeholder g3"></div>
        </div>
        <div style="height: 200px; border-radius: 4px; overflow: hidden;">
            <div class="card-img-placeholder g4"></div>
        </div>
        <div style="height: 200px; border-radius: 4px; overflow: hidden;">
            <div class="card-img-placeholder g5"></div>
        </div>
        <div style="height: 200px; border-radius: 4px; overflow: hidden;">
            <div class="card-img-placeholder g6"></div>
        </div>
    </div>
</section>

<!-- CUISINE -->
<section class="cuisine-section" id="cuisine">
    <div class="section-label">Food Culture</div>
    <div class="section-title">Taste Mindanao</div>
    <div class="cuisine-grid">
        <div class="cuisine-card">
            <span class="cuisine-emoji">🍢</span>
            <div class="cuisine-name">Satti</div>
            <div class="cuisine-origin">Zamboanga · Breakfast</div>
        </div>
        <div class="cuisine-card">
            <span class="cuisine-emoji">🥭</span>
            <div class="cuisine-name">Durian Candy</div>
            <div class="cuisine-origin">Davao · Delicacy</div>
        </div>
        <div class="cuisine-card">
            <span class="cuisine-emoji">🍲</span>
            <div class="cuisine-name">Tiyula Itum</div>
            <div class="cuisine-origin">Maguindanao · Soup</div>
        </div>
        <div class="cuisine-card">
            <span class="cuisine-emoji">🌯</span>
            <div class="cuisine-name">Pastil</div>
            <div class="cuisine-origin">Cotabato · Street Food</div>
        </div>
    </div>
</section>

<!-- EVENTS CALENDAR -->
<section class="section" id="events">
    <div class="section-label">Festivals & Events</div>
    <div class="section-title">Upcoming Events</div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <div style="border-left: 3px solid var(--ochre); padding: 1.5rem; background: #fff; border-radius: 0 4px 4px 0; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
            <div style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; color: var(--rust); font-weight: 600; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-calendar-days"></i> August 2025
            </div>
            <div style="font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--forest); margin-bottom: 0.4rem;">
                Kadayawan Festival
            </div>
            <div style="font-size: 0.82rem; color: #888;">
                <i class="fa-solid fa-location-dot"></i> Davao City
            </div>
        </div>
        
        <div style="border-left: 3px solid var(--ochre); padding: 1.5rem; background: #fff; border-radius: 0 4px 4px 0; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
            <div style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; color: var(--rust); font-weight: 600; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-calendar-days"></i> October 2025
            </div>
            <div style="font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--forest); margin-bottom: 0.4rem;">
                Zamboanga Hermosa Festival
            </div>
            <div style="font-size: 0.82rem; color: #888;">
                <i class="fa-solid fa-location-dot"></i> Zamboanga City
            </div>
        </div>
        
        <div style="border-left: 3px solid var(--ochre); padding: 1.5rem; background: #fff; border-radius: 0 4px 4px 0; box-shadow: 0 2px 12px rgba(0,0,0,0.05);">
            <div style="font-size: 0.72rem; letter-spacing: 2px; text-transform: uppercase; color: var(--rust); font-weight: 600; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-calendar-days"></i> November 2025
            </div>
            <div style="font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--forest); margin-bottom: 0.4rem;">
                Lanzones Festival
            </div>
            <div style="font-size: 0.82rem; color: #888;">
                <i class="fa-solid fa-location-dot"></i> Camiguin
            </div>
        </div>
    </div>
</section>

<!-- SAFETY ADVISORIES -->
<section class="section" id="advisories" style="background: #fff5ee;">
    <div class="section-label">Travel Information</div>
    <div class="section-title">Safety & Travel Advisories</div>
    
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; gap: 1.2rem; align-items: flex-start; padding: 1.2rem 1.5rem; background: #fff; border-radius: 4px; border-left: 3px solid var(--emerald); box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <i class="fas fa-shield-alt" style="font-size: 1.4rem; color: var(--emerald); margin-top: 0.1rem;"></i>
            <div>
                <div style="font-weight: 600; color: var(--charcoal); margin-bottom: 0.2rem; font-size: 0.92rem;">General Safety</div>
                <div style="font-size: 0.82rem; color: #777; line-height: 1.6;">Mindanao is generally safe for tourists. Follow standard travel precautions and stay informed about local conditions.</div>
            </div>
        </div>
        
        <div style="display: flex; gap: 1.2rem; align-items: flex-start; padding: 1.2rem 1.5rem; background: #fff; border-radius: 4px; border-left: 3px solid var(--ochre); box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <i class="fas fa-info-circle" style="font-size: 1.4rem; color: var(--ochre); margin-top: 0.1rem;"></i>
            <div>
                <div style="font-weight: 600; color: var(--charcoal); margin-bottom: 0.2rem; font-size: 0.92rem;">Travel Requirements</div>
                <div style="font-size: 0.82rem; color: #777; line-height: 1.6;">Bring valid ID, check local travel requirements, and register with your embassy if traveling to remote areas.</div>
            </div>
        </div>
        
        <div style="display: flex; gap: 1.2rem; align-items: flex-start; padding: 1.2rem 1.5rem; background: #fff; border-radius: 4px; border-left: 3px solid var(--lime); box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <i class="fas fa-heart" style="font-size: 1.4rem; color: var(--lime); margin-top: 0.1rem;"></i>
            <div>
                <div style="font-weight: 600; color: var(--charcoal); margin-bottom: 0.2rem; font-size: 0.92rem;">Respect Local Culture</div>
                <div style="font-size: 0.82rem; color: #777; line-height: 1.6;">Mindanao is culturally diverse. Respect local customs, dress modestly in religious sites, and ask permission before taking photos.</div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer id="contact">
    <div class="footer-brand">
        <div class="logo">Minda<span>Now</span></div>
        <p>Your ultimate guide to Mindanao's destinations, culture, and hidden gems.</p>
    </div>
    <div class="footer-col">
        <h4>Quick Links</h4>
        <a href="#home">Home</a>
        <a href="#destinations">Destinations</a>
        <a href="#cuisine">Cuisine</a>
        <a href="feedback.php">Contact Us</a>
    </div>
    <div class="footer-col">
        <h4>Follow Us</h4>
        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
        <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
    </div>
</footer>
<div class="footer-bottom">
    &copy; <?php echo date('Y'); ?> MindaNow. All rights reserved.
</div>

</body>
</html>
