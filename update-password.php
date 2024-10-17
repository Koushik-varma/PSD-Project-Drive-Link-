<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    // Function to verify the current password
    function verifyPassword($email, $password, $dbh) {
        $sql = "SELECT Password FROM tblusers WHERE EmailId=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        
        if ($result && password_verify($password, $result->Password)) {
            return true;
        }
        return false;
    }

    // Function to update the new password
    function updatePassword($email, $newPassword, $dbh) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE tblusers SET Password=:newpassword WHERE EmailId=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':newpassword', $newHashedPassword, PDO::PARAM_STR);
        $query->execute();
        return $query->rowCount() > 0;
    }

    if (isset($_POST['update'])) {
        $password = $_POST['password'];
        $newPassword = $_POST['newpassword'];
        $email = $_SESSION['login'];

        // Verify current password
        if (verifyPassword($email, $password, $dbh)) {
            // Update password if verification is successful
            if (updatePassword($email, $newPassword, $dbh)) {
                $msg = "Your password was successfully changed.";
            } else {
                $error = "Error in updating the password. Please try again.";
            }
        } else {
            $error = "Your current password is incorrect.";
        }
    }
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<!-- Header and CSS Links -->
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php'); ?>
<!-- /Switcher -->

<!-- Header -->
<?php include('includes/header.php'); ?>
<!-- /Header -->

<section class="page-header profile_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Update Password</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="#">Home</a></li>
                <li>Update Password</li>
            </ul>
        </div>
    </div>
    <div class="dark-overlay"></div>
</section>

<?php
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
                   <?php echo htmlentities($result->City); ?>, <?php echo htmlentities($result->Country); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>
            </div>
            <div class="col-md-6 col-sm-8">
                <div class="profile_wrap">
                    <form name="chngpwd" method="post" onSubmit="return valid();">
                        <div class="gray-bg field-title">
                            <h6>Update Password</h6>
                        </div>
                        <?php if ($error) { ?>
                            <div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?></div>
                        <?php } else if ($msg) { ?>
                            <div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?></div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label">Current Password</label>
                            <input class="form-control white_bg" id="password" name="password" type="password" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">New Password</label>
                            <input class="form-control white_bg" id="newpassword" type="password" name="newpassword" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <input class="form-control white_bg" id="confirmpassword" type="password" name="confirmpassword" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" name="update" id="submit" class="btn btn-block">
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

<!-- Footer -->
<?php include('includes/footer.php'); ?>
<!-- /Footer -->

<!-- Back to top -->
<div id="back-top" class="back-top">
    <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
</div>
<!-- /Back to top -->

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
</body>
</html>

<?php } ?>