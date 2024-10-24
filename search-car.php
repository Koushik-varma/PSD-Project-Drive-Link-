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
<title>Car Rental Portal | Car Listing</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
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
        
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header--> 
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Page Header-->
<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Car Listing</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Car Listing</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<!--Listing-->
<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
          <?php
        // Get user inputs from the search form
        $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
        $fueltype = isset($_POST['fueltype']) ? $_POST['fueltype'] : '';
        $seats = isset($_POST['seats']) ? intval($_POST['seats']) : null;
        $price = isset($_POST['price']) ? intval($_POST['price']) : null;

        // SQL query to fetch cars based on filter criteria
        $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
                FROM tblvehicles 
                JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                WHERE tblvehicles.VehiclesBrand LIKE :brand 
                AND tblvehicles.FuelType LIKE :fueltype 
                AND tblvehicles.SeatingCapacity >= :seats 
                AND tblvehicles.PricePerDay <= :price";

        // Prepare the query
        $query = $dbh->prepare($sql);

        // Bind values based on user input
        $query->bindValue(':brand', '%' . $brand . '%', PDO::PARAM_STR); 
        $query->bindValue(':fueltype', '%' . $fueltype . '%', PDO::PARAM_STR);
        $query->bindValue(':seats', $seats, PDO::PARAM_INT);
        $query->bindValue(':price', $price, PDO::PARAM_INT);

        // Execute the query
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Display the results in the main content area
        if ($query->rowCount() > 0) {
            foreach ($results as $result) {
                ?>
                <!-- Create a separate container for each car listing -->
        <div class="car-listing-container" style="margin-bottom: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
            <div class="car-listing">
                <div class="car-img">
                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
                        <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image" style="max-width: 100%; border-radius: 5px;">
                    </a>
                </div>
                <div class="car-title">
                    <h5>
                        <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
                            <?php echo htmlentities($result->BrandName);?>, <?php echo htmlentities($result->VehiclesTitle);?>
                        </a>
                    </h5>
                    <p class="price">$<?php echo htmlentities($result->PricePerDay);?> Per Day</p>
                    <ul class="car-info">
                        <li><i class="fa fa-user"></i> <?php echo htmlentities($result->SeatingCapacity);?> seats</li>
                        <li><i class="fa fa-calendar"></i> <?php echo htmlentities($result->ModelYear);?> model</li>
                        <li><i class="fa fa-car"></i> <?php echo htmlentities($result->FuelType);?></li>
                    </ul>
                    <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>" class="btn">View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
                </div>
            </div>
        </div> <!-- End of car listing container -->
        <?php
    }
} else {
    echo "<div class='col-md-12'><p>No cars found matching your criteria.</p></div>";
}
?>
         </div>
        </div>
      </div>
      
      <!--Side-Bar-->
      <aside class="col-md-3 col-md-pull-9">
      <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your  Car </h5>
          </div>
          <div class="sidebar_filter">
  <form action="search-carresult.php" method="post">
    <!-- Brand Select -->
    <div class="form-group select">
      <label for="brand">Select Brand</label>
      <select class="form-control" name="brand">
        <option>Select Brand</option>
        <?php
        $sql = "SELECT * FROM tblbrands";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
          foreach ($results as $result) { ?>
            <option value="<?php echo htmlentities($result->id); ?>">
              <?php echo htmlentities($result->BrandName); ?>
            </option>
          <?php }
        } ?>
      </select>
    </div>

    <!-- Fuel Type Select -->
    <div class="form-group select">
      <label for="fueltype">Select Fuel Type</label>
      <select class="form-control" name="fueltype">
        <option>Select Fuel Type</option>
        <option value="Petrol">Petrol</option>
        <option value="Diesel">Diesel</option>
        <option value="CNG">CNG</option>
      </select>
    </div>

    <!-- Seats Range Slider -->
    <div class="form-group">
      <label for="seats">Number of Seats</label>
      <input type="range" class="form-control-range" id="seats" name="seats" min="2" max="7" step="1" value="4"
             oninput="document.getElementById('seatsOutput').value = this.value;">
      <output id="seatsOutput">4</output> Seats
    </div>

    <!-- Price Per Day Range Slider -->
    <div class="form-group">
      <label for="price">Price Per Day</label>
      <input type="range" class="form-control-range" id="price" name="price" min="0" max="200" step="5" value="100"
             oninput="document.getElementById('priceOutput').value = this.value;">
      <output id="priceOutput">100</output> $
    </div>

    <!-- Submit Button -->
    <div class="form-group">
      <button type="submit" class="btn btn-block"><i class="fa fa-search" aria-hidden="true"></i> Search Car</button>
    </div>
  </form>
</div>

        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-car" aria-hidden="true"></i> Recently Listed Cars</h5>
          </div>
          <div class="recent_addedcars">
            <ul>
<?php $sql = "SELECT tblvehicles.*,tblbrands.BrandName,tblbrands.id as bid  from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand order by id desc limit 4";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

              <li class="gray-bg">
                <div class="recent_post_img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
                <div class="recent_post_title"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?></a>
                  <p class="widget_price">$<?php echo htmlentities($result->PricePerDay);?> Per Day</p>
                </div>
              </li>
              <?php }} ?>
              
            </ul>
          </div>
        </div>
      </aside>
      <!--/Side-Bar--> 

    </div>
  </div>
</section>
<!-- /Listing--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

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
