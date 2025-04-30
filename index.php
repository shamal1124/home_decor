<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Decore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">

<div class="text-container">
        <!-- <span>H</span><span>o</span><span>m</span><span>e</span>&nbsp -->
        <span>D</span><span>e</span><span>c</span><span>o</span><span>r</span><span>a</span>&nbsp
        <!-- <span class="small-text">-</span>&nbsp -->
    	<span class="small-text">E</span><span class="small-text">l</span><span class="small-text">e</span><span class="small-text">g</span>
    	<span class="small-text">a</span><span class="small-text">n</span><span class="small-text">t</span>&nbsp
    	<span class="small-text">a</span>
    	<span class="small-text">n</span>
    	<span class="small-text">d</span> &nbsp
    	<span class="small-text">M</span><span class="small-text">o</span><span class="small-text">d</span><span class="small-text">e</span>
    	<span class="small-text">r</span><span class="small-text">n</span>

        <?php if (isset($_SESSION['user_id'])): ?>
    <a href="logout.php" style="background-color: white; color: #5A3220; font-size: 0.875rem; padding: 6px 12px; border-radius: 5px; margin-left: 100px; text-decoration: none;" onmouseover="this.style.backgroundColor='#f3f3f3'" onmouseout="this.style.backgroundColor='white'">Logout</a>
<?php else: ?>
    <a href="login.php" style="background-color: white; color: #5A3220; font-size: 0.875rem; padding: 6px 12px; border-radius: 5px; margin-left: 700px; text-decoration: none;" onmouseover="this.style.backgroundColor='#f3f3f3'" onmouseout="this.style.backgroundColor='white'">Login</a>
    <a href="signup.php" style="background-color: white; color: #5A3220; font-size: 0.875rem; padding: 6px 12px; border-radius: 5px; margin-left: 30px; text-decoration: none;" onmouseover="this.style.backgroundColor='#f3f3f3'" onmouseout="this.style.backgroundColor='white'">Sign Up</a>
<?php endif; ?>


    </div>

    

    <!-- carousel -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="assets/images/design4.jpg" class="d-block w-100" alt="..." style="height: 683px;">
      <div class="carousel-caption d-none d-md-block">
        <h3>Elegant Interiors</h3>
        <p>Transform your space with modern and sophisticated designs.</p>
        <p>For More Details</p> 
        <a href="view_designs.php"><button class="login_btn">Browse Design</button></a>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="assets/images/design3.jpg" class="d-block w-100" alt="..." style="height: 683px;">
      <div class="carousel-caption d-none d-md-block">
        <h3>Luxury Living</h3>
        <p>Experience the finest home decor with Decora.</p>
        <p>For More Details</p> 
        <a href="view_designs.php"><button class="login_btn">Browse Design</button></a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="assets/images/design2.jpg" class="d-block w-100" alt="..." style="height: 683px;">
      <div class="carousel-caption d-none d-md-block">
        <h3>Modern Aesthetics</h3>
        <p>Designs that blend elegance with functionality.</p>
        <p>For More Details</p> 
        <a href="view_designs.php"><button class="login_btn">Browse Design</button></a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
    <!-- carousel -->

<!-- Gallery Section -->
<div class="gallery-section">
  <h2 style="font-family: cursive;">Our Designs</h2>
  <div class="gallery-container">
    <div class="gallery-item"><img src="assets/images/design1.jpg" alt="Gallery 1"></div>
    <div class="gallery-item"><img src="assets/images/design2.jpg" alt="Gallery 2"></div>
    <div class="gallery-item"><img src="assets/images/design2.jpg" alt="Gallery 3"></div>
    <div class="gallery-item"><img src="assets/images/design3.jpg" alt="Gallery 4"></div>
    <div class="gallery-item"><img src="assets/images/design4.jpg" alt="Gallery 5"></div>
    <div class="gallery-item"><img src="assets/images/design1.jpg" alt="Gallery 6"></div>
    <div class="gallery-item"><img src="assets/images/design3.jpg" alt="Gallery 7"></div>
    <!-- <div class="gallery-item"><img src="images/4.jpg" alt="Gallery 8"></div> -->
  </div>
</div>

<!-- Designer Section -->
<div class="designer-section">
  <h2>Meet Our Designers</h2>
  <div class="designer-slider">
    <div class="designer-card">
      <img src="assets/images/designer/designer1.jpg" alt="Designer 1" class="designer-image">
      <div class="designer-info">
        <h4>Anna Doe</h4>
        <p>Interior Architect with 10+ years of experience</p>
      </div>
    </div>

    <div class="designer-card">
      <img src="assets/images/designer/designer8.jpg" alt="Designer 2" class="designer-image">
      <div class="designer-info">
        <h4>Jane Smith</h4>
        <p>Modern design expert specializing in luxury interiors</p>
        
      </div>
    </div>

    <div class="designer-card">
      <img src="assets/images/designer/designer5.jpg" alt="Designer 3" class="designer-image">
      <div class="designer-info">
        <h4>Emily Davis</h4>
        <p>Minimalist and contemporary home designer</p>
      </div>
    </div>

    <div class="designer-card">
      <img src="assets/images/designer/designer2.jpg" alt="Designer 4" class="designer-image">
      <div class="designer-info">
        <h4>Lily Lee</h4>
        <p>Expert in sustainable and eco-friendly designs</p>
      </div>
    </div>

    <div class="designer-card">
      <img src="assets/images/designer/designer7.jpg" alt="Designer 5" class="designer-image">
      <div class="designer-info">
        <h4>Sarah Johnson</h4>
        <p>Specialist in artistic and cultural interiors</p>
      </div>
    </div>
  </div>
</div>


<!-- Footer -->
<footer class="footer">
  <div class="container">
      <div class="row">
          <!-- About Section -->
          <div class="col-md-4 footer-section">
              <h4>About Decora</h4>
              <p>Decora brings elegance and modernity to interior design. We create spaces that reflect beauty, functionality, and luxury.</p>
             
          </div>

          <!-- Quick Links Section -->
          <div class="col-md-4 footer-section">
              <h4>Quick Links</h4>
              <ul class="footer-links">
                  <li><a href="#">Home</a></li>
                  <li><a href="#">Gallery</a></li>
                  <li><a href="#">Designers</a></li>
                  <li><a href="#">Contact</a></li>
              </ul>
          </div>

          <!-- Contact Section -->
          <div class="col-md-4 footer-section">
              <h4>Contact Us</h4>
              <p>Email: <a href="mailto:info@decora.com">info@decora.com</a></p>
              <p>Phone: +1 234 567 890</p>
              <div class="social-icons">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                  <a href="#"><i class="fab fa-linkedin-in"></i></a>
              </div>
          </div>
      </div>
  </div>
  <div class="footer-bottom">
      <p>&copy; 2025 Decora. All Rights Reserved.</p>
  </div>
</footer>

<!-- Footer -->

    <!-- bootstrap -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
	<!-- bootstrap -->
</body>

</html>
