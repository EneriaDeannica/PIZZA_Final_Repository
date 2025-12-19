<?php
include 'header.php';
?>

<style>
.about-section {
    max-width: 1000px;
    margin: 60px auto;
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: center;
    align-items: center;
}

.about-text {
    flex: 1 1 400px;
}

.about-text h1 {
    font-size: 36px;
    color: #7a1f12;
    margin-bottom: 20px;
}

.about-text p {
    font-size: 16px;
    line-height: 1.6;
    color: #555;
    margin-bottom: 15px;
}

.about-image {
    flex: 1 1 400px;
    text-align: center;
}

.about-image img {
    max-width: 100%;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.values-section {
    margin-top: 50px;
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
}

.value-card {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    width: 220px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.value-card h3 {
    color: #7a1f12;
    margin-bottom: 10px;
}

.value-card p {
    font-size: 14px;
    color: #555;
}
</style>

<section class="about-section">
    <div class="about-text">
        <h1>About Our Pizzeria</h1>
        <p>Welcome to our pizzeria! We serve freshly made, hot, and delicious pizzas crafted with love and the finest ingredients. Our passion is creating memorable experiences for our customers through quality food and excellent service.</p>
        <p>We believe in using only the freshest ingredients and traditional recipes to ensure every bite is full of flavor. Whether you're dining in, taking out, or having it delivered, we aim to bring happiness to your table.</p>

        <div class="values-section">
            <div class="value-card">
                <h3>Quality</h3>
                <p>We use only the freshest ingredients and traditional recipes for authentic taste.</p>
            </div>
            <div class="value-card">
                <h3>Freshness</h3>
                <p>Every pizza is made to order, ensuring maximum flavor and quality.</p>
            </div>
            <div class="value-card">
                <h3>Service</h3>
                <p>Fast, friendly, and reliable service for both dine-in and delivery.</p>
            </div>
        </div>
    </div>

    <div class="about-image">
        <img src="assets/images/about_us.jpg" alt="About Us Image">
    </div>
</section>

<?php include 'footer.php'; ?>
