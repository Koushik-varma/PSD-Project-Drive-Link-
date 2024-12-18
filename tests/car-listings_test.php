// Fetch car listings from the database
$carListings = $db->query("SELECT * FROM cars");

// Assert that the car listings contain valid data
foreach ($carListings as $car) {
    // Check if car make, model, price, and image are present
    $this->assertNotEmpty($car['make'], "Car make is missing");
    $this->assertNotEmpty($car['model'], "Car model is missing");
    $this->assertNotEmpty($car['price'], "Car price is missing");
    $this->assertNotEmpty($car['image'], "Car image is missing");
    $this->assertTrue(file_exists($car['image']), "Car image does not exist");
}

// Fetch the 4 most recently listed cars
$recentCars = $db->query("SELECT * FROM cars ORDER BY created_at DESC LIMIT 4");

// Assert that 4 cars are returned
$this->assertCount(4, $recentCars, "Recently listed cars should be 4");

// Check each car details
foreach ($recentCars as $car) {
    $this->assertNotEmpty($car['make'], "Car make is missing");
    $this->assertNotEmpty($car['model'], "Car model is missing");
    $this->assertNotEmpty($car['price'], "Car price is missing");
}

// Execute search query with criteria that should return no results
$searchResults = $db->query("SELECT * FROM cars WHERE price BETWEEN 1000 AND 2000");

// Assert that no cars are returned
$this->assertEmpty($searchResults, "No cars should be found for this search criteria");

// Assert that 'No cars found' message is displayed
$this->assertContains('No cars found', $htmlOutput, "No cars found message is missing");

// Fetch the first 10 cars for page 1
$page1Cars = $db->query("SELECT * FROM cars LIMIT 10 OFFSET 0");

// Assert that 10 cars are displayed on the first page
$this->assertCount(10, $page1Cars, "First page should display 10 cars");

// Fetch the next 10 cars for page 2
$page2Cars = $db->query("SELECT * FROM cars LIMIT 10 OFFSET 10");

// Assert that 10 cars are displayed on the second page
$this->assertCount(10, $page2Cars, "Second page should display 10 cars");

// Verify that cars on page 1 are different from cars on page 2
$this->assertNotEquals($page1Cars, $page2Cars, "Cars on page 1 and page 2 should be different");

// Fetch car details for a specific car
$carID = 123;
$carDetails = $db->query("SELECT * FROM cars WHERE id = $carID")->fetch();

// Assert that the car details match expected values from the database
$this->assertEquals('Toyota', $carDetails['make'], "Car make mismatch");
$this->assertEquals('Corolla', $carDetails['model'], "Car model mismatch");
$this->assertEquals(100, $carDetails['price'], "Car price mismatch");
$this->assertEquals(5, $carDetails['seating_capacity'], "Seating capacity mismatch");

// Fetch car listings that have missing or invalid data
$invalidCars = $db->query("SELECT * FROM cars WHERE price IS NULL OR image IS NULL");

// Assert that the system handles missing data
foreach ($invalidCars as $car) {
    // Check if price is missing and assert that default 'N/A' is displayed
    if (empty($car['price'])) {
        $this->assertContains('N/A', $htmlOutput, "Default price not displayed for missing price");
    }
    
    // Check if image is missing and assert that default image is displayed
    if (empty($car['image'])) {
        $this->assertContains('<img src="default_image.jpg"', $htmlOutput, "Default image not displayed for missing car image");
    }
}
