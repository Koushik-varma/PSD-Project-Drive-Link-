class CarListingTest extends PHPUnit\Framework\TestCase
{
    private $dbh;

    protected function setUp(): void
    {
        $this->dbh = new PDO('mysql:host=localhost;dbname=test_db', 'username', 'password');
    }

    public function testSearchCarsByBrand()
    {
        // Mock form input: brand
        $_POST['brand'] = 'Toyota';
        $_POST['fueltype'] = '';
        $_POST['seats'] = 4;
        $_POST['price'] = 100;

        // Prepare SQL query based on the code provided
        $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
                FROM tblvehicles 
                JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
                WHERE tblvehicles.VehiclesBrand LIKE :brand 
                AND tblvehicles.FuelType LIKE :fueltype 
                AND tblvehicles.SeatingCapacity >= :seats 
                AND tblvehicles.PricePerDay <= :price";

        // Prepare the statement and execute
        $query = $this->dbh->prepare($sql);
        $query->bindValue(':brand', '%' . $_POST['brand'] . '%', PDO::PARAM_STR);
        $query->bindValue(':fueltype', '%' . $_POST['fueltype'] . '%', PDO::PARAM_STR);
        $query->bindValue(':seats', $_POST['seats'], PDO::PARAM_INT);
        $query->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
        $query->execute();

        // Fetch results
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        // Check if the results contain the brand 'Toyota'
        $this->assertGreaterThan(0, count($results), "No cars found for Toyota brand");
    }
}

public function testFilterByFuelType()
{
    // Mock form input: fuel type
    $_POST['brand'] = '';
    $_POST['fueltype'] = 'Diesel';
    $_POST['seats'] = 4;
    $_POST['price'] = 100;

    // Prepare SQL query based on the code provided
    $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
            FROM tblvehicles 
            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
            WHERE tblvehicles.VehiclesBrand LIKE :brand 
            AND tblvehicles.FuelType LIKE :fueltype 
            AND tblvehicles.SeatingCapacity >= :seats 
            AND tblvehicles.PricePerDay <= :price";

    // Prepare the statement and execute
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':brand', '%' . $_POST['brand'] . '%', PDO::PARAM_STR);
    $query->bindValue(':fueltype', '%' . $_POST['fueltype'] . '%', PDO::PARAM_STR);
    $query->bindValue(':seats', $_POST['seats'], PDO::PARAM_INT);
    $query->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $query->execute();

    // Fetch results
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Check if the results contain the fuel type 'Diesel'
    foreach ($results as $car) {
        $this->assertEquals('Diesel', $car->FuelType, "Fuel type mismatch");
    }
}

public function testFilterBySeatsAndPrice()
{
    // Mock form input: seats and price
    $_POST['brand'] = '';
    $_POST['fueltype'] = '';
    $_POST['seats'] = 5;
    $_POST['price'] = 50;

    // Prepare SQL query based on the code provided
    $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
            FROM tblvehicles 
            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
            WHERE tblvehicles.VehiclesBrand LIKE :brand 
            AND tblvehicles.FuelType LIKE :fueltype 
            AND tblvehicles.SeatingCapacity >= :seats 
            AND tblvehicles.PricePerDay <= :price";

    // Prepare the statement and execute
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':brand', '%' . $_POST['brand'] . '%', PDO::PARAM_STR);
    $query->bindValue(':fueltype', '%' . $_POST['fueltype'] . '%', PDO::PARAM_STR);
    $query->bindValue(':seats', $_POST['seats'], PDO::PARAM_INT);
    $query->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $query->execute();

    // Fetch results
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Check if the results match the seat and price criteria
    foreach ($results as $car) {
        $this->assertGreaterThanOrEqual(5, $car->SeatingCapacity, "Seating capacity mismatch");
        $this->assertLessThanOrEqual(50, $car->PricePerDay, "Price mismatch");
    }
}

public function testNoSearchCriteria()
{
    // Mock form input: no search criteria
    $_POST['brand'] = '';
    $_POST['fueltype'] = '';
    $_POST['seats'] = 0;
    $_POST['price'] = 0;

    // Prepare SQL query based on the code provided
    $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
            FROM tblvehicles 
            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
            WHERE tblvehicles.VehiclesBrand LIKE :brand 
            AND tblvehicles.FuelType LIKE :fueltype 
            AND tblvehicles.SeatingCapacity >= :seats 
            AND tblvehicles.PricePerDay <= :price";

    // Prepare the statement and execute
    $query = $this->dbh->prepare($sql);
    $query->bindValue(':brand', '%' . $_POST['brand'] . '%', PDO::PARAM_STR);
    $query->bindValue(':fueltype', '%' . $_POST['fueltype'] . '%', PDO::PARAM_STR);
    $query->bindValue(':seats', $_POST['seats'], PDO::PARAM_INT);
    $query->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $query->execute();

    // Fetch results
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Check if the results return all cars (assuming there are cars in the database)
    $this->assertGreaterThan(0, count($results), "No cars found");
}

public function testRecentlyListedCars()
{
    // Prepare SQL query to fetch recently listed cars
    $sql = "SELECT tblvehicles.*, tblbrands.BrandName 
            FROM tblvehicles 
            JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
            ORDER BY tblvehicles.id DESC LIMIT 4";

    // Execute the query
    $query = $this->dbh->prepare($sql);
    $query->execute();

    // Fetch results
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Assert that at most 4 cars are fetched
    $this->assertLessThanOrEqual(4, count($results), "More than 4 cars are listed");
    
    // Check if the cars are ordered by ID (descending)
    $prev_id = PHP_INT_MAX;
    foreach ($results as $car) {
        $this->assertLessThan($prev_id, $car->id, "Cars are not in descending order by ID");
        $prev_id = $car->id;
    }
}
