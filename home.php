<?php include 'header.php'; ?>

<style>
    /* HOME HERO */
.home-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 60px 80px;
    background:url('Background.jpg')
}

.home-text {
    width: 50%;
}

.home-text h1 {
    font-size: 56px;
    color: #7a1f12;
}

.home-text h1 span {
    color: #c0392b;
}

.home-text p {
    margin-top: 15px;
    max-width: 520px;
    line-height: 1.7;
    color: #444;
}

/* BUTTON */
.btn-primary {
    display: inline-block;
    margin-top: 25px;
    background: #7a1f12;
    color: #fff;
    padding: 14px 32px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #a93226;
}

/* FEATURES */
.home-features {
    display: flex;
    gap: 20px;
    margin-top: 40px;
}

.feature {
    background: #f6f1ed;
    padding: 20px;
    border-radius: 15px;
    width: 180px;
    text-align: center;
}

.feature h4 {
    margin: 10px 0 5px;
    color: #7a1f12;
}

/* HERO IMAGE */
.home-image {
    position: relative;
    width: 480px;
    height: 480px; /* make it square for perfect circle */
    margin: 0 auto;
    border-radius: 240px; /* full round */
      /* clip image and overlay inside the circle */
    background: url('background.jpg') no-repeat center center;
    background-size: cover;
}

/* Overlay inside the circle */
.home-image::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(236, 157, 100, 0.69); /* semi-transparent overlay */
    pointer-events: none;
    border-radius: 240px;  
}

/* Floating image */
.home-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;     /* cover the container */
    position: relative;
    animation: float 3s ease-in-out infinite;
    z-index: 1; /* above overlay */
    /* match container radius */
}

/* Float animation */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}


/* DON'T MISS */
.dont-miss {
    padding: 50px 80px;
}

.dont-miss h2 {
    color: #7a1f12;
    margin-bottom: 25px;
}

.food-cards {
    display: flex;
    gap: 30px;
}

.food-card {
    background: #fff;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.food-card img {
    width: 200px;
}

.food-card:hover {
    transform: translateY(-8px);
}

.food-card p {
    margin-top: 15px;
    font-weight: bold;
    color: #7a1f12;
}
</style>

<section class="home-hero">
    <div class="home-image">
        <img src="explode.png" alt="Pizza Overload">
    </div>
    <div class="home-text">
        <h1>Pizza <span>Overload!</span></h1>
    

        <p>
            A flavor-packed feast for true pizza lovers! Loaded with layers of
            melty cheese, savory pepperoni, earthy mushrooms, briny olives,
            and finished with fresh basil.
        </p>

        <a href="menu.php" class="btn-primary">View Menu</a>

        <div class="home-features">
            <div class="feature">
                🚀
                <h4>Fast Delivery</h4>
                <small>Within 20 minutes</small>
            </div>

            <div class="feature">
                🍽️
                <h4>Serves the Best</h4>
                <small>High-quality food</small>
            </div>
        </div>
    </div>

    
</section>

<section class="dont-miss">
    <h2>Don’t Miss!</h2>

    <div class="food-cards">
        <div class="food-card">
            <img src="4.png" alt="Chicken Burger">
            <p>Chicken Burger</p>
        </div>

        <div class="food-card">
            <img src="5.png" alt="Classic Beef Burger">
            <p>Classic Beef Burger</p>
        </div>

        <div class="food-card">
            <img src="6.png" alt="Bacon Cheeseburger">
            <p>Bacon Cheeseburger</p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
