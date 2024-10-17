<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if user is logged in, if not redirect to login page
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['updateprofile'])) {
        $name = $_POST['fullname'];
        $mobileno = $_POST['mobilenumber'];

        // Date of Birth Format conversion (from dd/mm/yyyy to yyyy-mm-dd)
        if (!empty($_POST['dob'])) {
            $dob = DateTime::createFromFormat('d/m/Y', $_POST['dob'])->format('Y-m-d');
        } else {
            $dob = null; // Handle empty DOB if required
        }

        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $email = $_SESSION['login']; // Get the logged-in user's email from session

        // Update profile query
        $sql = "UPDATE tblusers SET FullName=:name, ContactNo=:mobileno, dob=:dob, Address=:address, City=:city, Country=:country WHERE EmailId=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        // Execute query and check for success
        if ($query->execute()) {
            $msg = "Profile Updated Successfully";
        } else {
            $error = "Error: Unable to update profile. Please try again later.";
        }
    }
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Car Rental Portal | My Profile</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->

<!-- Header -->
<?php include('includes/header.php');?>
<!-- /Header -->

<!-- Page Header -->
<section class="page-header profile_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Your Profile</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Profile</li>
            </ul>
        </div>
    </div>
    <!-- Dark Overlay -->
    <div class="dark-overlay"></div>
</section>
<!-- /Page Header -->

<?php
// Fetch user details to display
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>

<section class="user_profile inner_pages">
    <div class="container">
        <div class="user_profile_info gray-bg padding_4x4_40">
            <div class="upload_user_logo">
                <img src="assets/images/dealer-logo.jpg" alt="image">
            </div>

            <div class="dealer_info">
                <h5><?php echo htmlentities($result->FullName); ?></h5>
                <p><?php echo htmlentities($result->Address); ?><br>
                   <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country); ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>
            </div>
            <div class="col-md-6 col-sm-8">
                <div class="profile_wrap">
                    <h5 class="uppercase underline">General Settings</h5>
                    <?php if ($msg) { ?>
                        <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div>
                    <?php } elseif ($error) { ?>
                        <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div>
                    <?php } ?>
                    <form method="post">
                        <div class="form-group">
                            <label class="control-label">Reg Date -</label>
                            <?php echo htmlentities($result->RegDate); ?>
                        </div>
                        <?php if ($result->UpdationDate != "") { ?>
                            <div class="form-group">
                                <label class="control-label">Last Update at -</label>
                                <?php echo htmlentities($result->UpdationDate); ?>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label">Full Name</label>
                            <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->FullName); ?>" id="fullname" type="text" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email Address</label>
                            <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId); ?>" name="emailid" id="email" type="email" required readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Phone Number</label>
                            <input class="form-control white_bg" name="mobilenumber" value="<?php echo htmlentities($result->ContactNo); ?>" id="phone-number" type="text" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date of Birth (dd/mm/yyyy)</label>
                            <input class="form-control white_bg" value="<?php echo htmlentities($result->dob); ?>" name="dob" placeholder="dd/mm/yyyy" id="birth-date" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Your Address</label>
                            <textarea class="form-control white_bg" name="address" rows="4"><?php echo htmlentities($result->Address); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            <input class="form-control white_bg" id="country" name="country" value="<?php echo htmlentities($result->Country); ?>" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input class="form-control white_bg" id="city" name="city" value="<?php echo htmlentities($result->City); ?>" type="text">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="updateprofile" class="btn">Save Changes <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    }
}
?>

<!--Footer -->
<?php include('includes/footer.php'); ?>
<!-- /Footer -->

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>

</body>
</html>
