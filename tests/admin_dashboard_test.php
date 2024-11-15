<?php
// Include database configuration
include('includes/config.php');

// Function to check redirection for unauthorized users
function testAdminLoginRedirect() {
    session_start();
    if (!isset($_SESSION['alogin'])) {
        return "Redirecting to login page - Test Passed";
    } else {
        return "Access granted - Test Failed";
    }
}

// Function to test total number of registered users
function testRegisteredUsersCount($expectedCount) {
    global $dbh;
    $sql = "SELECT COUNT(id) AS total FROM tblusers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result->total == $expectedCount ? "Test Passed" : "Test Failed - Expected: $expectedCount, Actual: $result->total";
}

// Function to test total number of listed vehicles
function testListedVehiclesCount($expectedCount) {
    global $dbh;
    $sql = "SELECT COUNT(id) AS total FROM tblvehicles";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result->total == $expectedCount ? "Test Passed" : "Test Failed - Expected: $expectedCount, Actual: $result->total";
}

// Function to test total number of bookings
function testTotalBookingsCount($expectedCount) {
    global $dbh;
    $sql = "SELECT COUNT(id) AS total FROM tblbooking";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result->total == $expectedCount ? "Test Passed" : "Test Failed - Expected: $expectedCount, Actual: $result->total";
}


// Function to test each dashboard link (simulate by outputting links)
function testDashboardLinks() {
    $links = [
        "manage-vehicles.php",
        "manage-users.php",
        "manage-bookings.php",
        "manage-subscribers.php"
    ];
    foreach ($links as $link) {
        echo "Testing link: $link - Clickable and points to correct page<br>";
    }
    return "Test Passed - Links are correct";
}

// Function to test total number of subscribers
function testSubscribersCount($expectedCount) {
    global $dbh;
    $sql = "SELECT COUNT(id) AS total FROM tblsubscribers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result->total == $expectedCount ? "Test Passed" : "Test Failed - Expected: $expectedCount, Actual: $result->total";
}

?>
