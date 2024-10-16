<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>DriveLink | Car Listing</title>

<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custom Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

<!-- Favicons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">

<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php'); ?>
<!-- /Switcher -->  

<!--Header--> 
<?php include('includes/header.php'); ?>
<!-- /Header --> 

<!-- Banners -->
<section id="banner" class="banner-section">
  <div class="container">
    <div class="div_zindex">
      <div class="row">
        <div class="col-md-5 col-md-push-7">
          <div class="banner_content">
            <h1>Find the right car for you.</h1>
            <p>We have more than a thousand cars for you to choose from.</p>
            <a href="car-listing.php" class="btn">Explore Cars <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Banners --> 

<!-- Listings Section -->
<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
            <p><span>1-6</span> of <span>50 Listings</span></p>
          </div>
        </div>

        <!-- Listing -->
        <div class="product-listing-m gray-bg">
          <div class="product-listing-img"><img src="assets/images/car1.jpg" class="img-responsive" alt="Image" /> </div>
          <div class="product-listing-content">
            <h5><a href="car-details.php">Toyota Prius</a></h5>
            <p class="list-price">$45 per day</p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i> 5 seats</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i> 2020 model</li>
              <li><i class="fa fa-car" aria-hidden="true"></i> Automatic</li>
            </ul>
            <a href="car-details.php" class="btn">View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a> 
          </div>
        </div>
        <!-- /Listing -->
        
      </div>

      <!--Side-Bar-->
      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car </h5>
          </div>
          <div class="sidebar_filter">
            <form action="search-carresult.php" method="post">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option>Select Brand</option>
                  <?php $sql = "SELECT * from tblbrands ";
                  $query = $dbh -> prepare($sql);
                  $query->execute();
                  $results=$query->fetchAll(PDO::FETCH_OBJ);
                  if($query->rowCount() > 0)
                  {
                  foreach($results as $result)
                  { ?>
                  <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->BrandName);?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fueltype">
                  <option>Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                  <option value="CNG">CNG</option>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="price">
                  <option>Select Price Range</option>
                  <option value="100">100-200</option>
                  <option value="200">200-300</option>
                  <option value="300">300-400</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block">Search</button>
              </div>
            </form>
          </div>
        </div>
      </aside>
      <!-- /Side-Bar--> 
      
    </div>
  </div>
</section>
<!-- /Listings Section --> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> 
  <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> 
</div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
