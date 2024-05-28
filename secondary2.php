<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Query Results</title>
</head>
<body>
<h3>Query Results</h3>
<p><a href="main.php">Back to Form</a></p>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("../../db/connect3.php");

function displayResults($result) {
    if ($result->num_rows > 0) {
       echo "<table border='1'><tr>";
       $fields = $result->fetch_fields();
       foreach ($fields as $field) {
               echo "<th>" . htmlspecialchars($field->name) . "</th>";
       }
       echo "</tr>";
       while ($row = $result->fetch_assoc()) {
               echo "<tr>";
               foreach ($row as $key => $value) {
                  if ($key == 'Electric_Range') {
                      echo "<td>" . htmlspecialchars($value) . " miles</td>";
                  } else {
                      echo "<td>" . htmlspecialchars($value) . "</td>";
                  }
               }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No results found.";
    }
}

?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$minRange = isset($_GET['minRange']) ? intval($_GET['minRange']) : 0;
$maxRange = isset($_GET['maxRange']) ? intval($_GET['maxRange']) : PHP_INT_MAX;
$minPrice = isset($_GET['minPrice']) ? intval($_GET['minPrice']) : 0;
$maxPrice = isset($_GET['maxPrice']) ? intval($_GET['maxPrice']) : PHP_INT_MAX;
$evType = $conn->real_escape_string($_GET['evType'] ?? '');
$cafEligibility = $conn->real_escape_string($_GET['cafEligibility'] ?? '');
$county = $conn->real_escape_string($_GET['county'] ?? '');
$city = $conn->real_escape_string($_GET['city'] ?? '');
$state = $conn->real_escape_string($_GET['state'] ?? '');
$model = $conn->real_escape_string($_GET['vehicleModel'] ?? '');
$utilityProvider = $conn->real_escape_string($_GET['utilityProvider'] ?? '');

if ($minPrice > $maxPrice) {
    echo "Invalid price range.";
    exit;
}
if ($minRange > $maxRange) {
   echo "Invalid electric range.";
   exit;
}

$query = "SELECT v.Vin, v.Brand, v.Model, v.Electric_Range, vt.EVType, vt.CAFV_Eligibility, p.Base_MSRP, rg.County, rg.City, rg.State, up.Utility_Name 
          FROM Vehicles v
          JOIN Vehicle_Types vt ON v.Model = vt.Model
          JOIN Prices p ON v.Model = p.Model 
          JOIN Registrations rg ON v.Vin = rg.Vin
          JOIN Utilities_Providers up ON v.Vin = up.Vin
          WHERE 1=1";

$params = [];
$types = "";

if (!empty($brand) && !empty($model)) {
            $query .= " AND v.Brand = ? AND v.Model = ?";
            $params[] = &$brand;
            $params[] = &$model;
            $types .= "ss";
} elseif (!empty($model)) {
            $query .= " AND v.Model = ?";
            $params[] = &$model;
            $types .= "s";
}


if (!empty($evType)) {
    $query .= " AND vt.EVType = ?";
    $params[] = &$evType;
    $types .= "s";
}
if (!empty($cafEligibility)) {
    $query .= " AND vt.CAFV_Eligibility = ?";
    $params[] = &$cafEligibility;
    $types .= "s";
}

if (!empty($county)) {
    $query .= " AND rg.County = ?";
    $params[] = &$county;
    $types .= "s";
}

if (!empty($city)) {
    $query .= " AND rg.City = ?";
    $params[] = &$city;
    $types .= "s";
}

if (!empty($state)) {
    $query .= " AND rg.State = ?";
    $params[] = &$state;
    $types .= "s";
}

$query .= " AND p.Base_MSRP BETWEEN ? AND ?";
$params[] = &$minPrice;
$params[] = &$maxPrice;
$types .= "ii";

$query .= " AND v.Electric_Range BETWEEN ? AND ?";
$params[] = &$minRange;
$params[] = &$maxRange;
$types .= "ii";

if (!empty($utilityProvider)) {
    $query .= " AND up.Utility_Name = ?";
    $params[] = &$utilityProvider;
    $types .= "s";
}

if ($stmt = $conn->prepare($query)) {
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        echo "Error: " . $stmt->error;
} else {
        echo "<p>Results for Vehicle Model $model with Price Range $minPrice - $maxPrice and Eletric Range $minRange - $maxRange:</p>";
        displayResults($result);
    }
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}

$conn->close();
?>

<p><a href="main.php">Back to Form</a></p>
</body>
</html>
