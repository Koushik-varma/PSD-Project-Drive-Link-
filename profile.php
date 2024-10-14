<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if user is logged in, if not redirect to login page
if(strlen($_SESSION['login']) == 0) { 
    header('location:index.php');
} else {
    // Profile update logic
    if(isset($_POST['updateprofile'])) {
        $name = $_POST['fullname'];
        $mobileno = $_POST['mobilenumber'];
        $dob = $_POST['dob'];
        $adress = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $email = $_SESSION['login'];

        $sql = "UPDATE tblusers SET FullName=:name, ContactNo=:mobileno, dob=:dob, Address=:adress, City=:city, Country=:country WHERE EmailId=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':adress', $adress, PDO::PARAM_STR);
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $msg = "Profile Updated Successfully";
    }

    // Fetch user profile details from database
    $useremail = $_SESSION['login'];
    $sql = "SELECT * FROM tblusers WHERE EmailId=:useremail";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>
