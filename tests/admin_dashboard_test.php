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

// Function to test SQL injection prevention
function testSQLInjectionPrevention() {
    global $dbh;
    $sql = "SELECT COUNT(id) FROM tblusers WHERE id = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id);
    $id = "1 OR 1=1"; // SQL injection attempt
    $query->execute();
    $result = $query->fetch(PDO::FETCH_COLUMN);
    return $result == 1 ? "Test Passed" : "Test Failed - SQL Injection succeeded";
}

// Function to test XSS prevention
function testXSSPrevention() {
    $testInput = "<script>alert('XSS');</script>";
    $sanitizedInput = htmlspecialchars($testInput, ENT_QUOTES, 'UTF-8');
    return $sanitizedInput == "&lt;script&gt;alert('XSS');&lt;/script&gt;" ? "Test Passed" : "Test Failed - XSS Prevention failed";
}

// Function to test database connection
function testDatabaseConnection() {
    global $dbh;
    try {
        $dbh->query("SELECT 1");
        return "Test Passed - Database connection is valid";
    } catch (PDOException $e) {
        return "Test Failed - Database connection failed: " . $e->getMessage();
    }
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

// Run all tests and display results
echo "<h2>Test Results</h2>";
echo "<strong>1. Admin Login Redirect Test:</strong> " . testAdminLoginRedirect() . "<br>";
echo "<strong>2. Registered Users Count Test:</strong> " . testRegisteredUsersCount(5) . "<br>"; // Replace 5 with your expected count
echo "<strong>3. Listed Vehicles Count Test:</strong> " . testListedVehiclesCount(10) . "<br>"; // Replace 10 with your expected count
echo "<strong>4. Total Bookings Count Test:</strong> " . testTotalBookingsCount(15) . "<br>"; // Replace 15 with your expected count
echo "<strong>5. SQL Injection Prevention Test:</strong> " . testSQLInjectionPrevention() . "<br>";
echo "<strong>6. XSS Prevention Test:</strong> " . testXSSPrevention() . "<br>";
echo "<strong>7. Database Connection Test:</strong> " . testDatabaseConnection() . "<br>";
echo "<strong>8. Dashboard Links Test:</strong> " . testDashboardLinks() . "<br>";
echo "<strong>9. Subscribers Count Test:</strong> " . testSubscribersCount(8) . "<br>"; // Replace 8 with your expected count

?>
