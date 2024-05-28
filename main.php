<body>
<?php
echo "<BR>";
echo "Shiyu Jiang, Richard Zhang";
echo "<BR>";
echo "Group #9";
echo "<BR>";
echo "Final Project";
echo "<BR>";
system("ls -l ./main.php");
?>

<form id="dynamicQueryForm" action="secondary2.php" method="GET">
    <h3>Select Casr Based on your Preferences</h3>

    <p>Select a Vehicle Model:</p>
    <select name="vehicleModel" size="1">
    <option value="">All Models</option>
    <?php
    require_once("../../db/connect3.php");
    $query = "SELECT DISTINCT Brand, Model FROM Vehicles ORDER BY Brand, Model";
    $result = $conn->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $brand = htmlspecialchars($row['Brand']);
            $model = htmlspecialchars($row['Model']);
            echo "<option value=\"$model\">$brand - $model</option>";
        }
    } else {
        echo "<option value=\"\">No Models Found</option>";
    }
    ?>
    </select>

    <p>Select a Price Range:</p>
    <label for="minPrice">Min Price:</label>
    <input type="number" name="minPrice" id="minPrice" min="0" value="0">
    <label for="maxPrice">Max Price:</label>
    <input type="number" name="maxPrice" id="maxPrice" min="0" value="100000">

    <p>Select a Electric Range:</p>
    <label for="minRange">Min Range:</label>
    <input type="number" name="minRange" id="minRange" min="0" value="0">
    <label for="maxRange">Max Range:</label>
    <input type="number" name="maxRange" id="maxRange" min="0" value="1000">

    <p>Select an EV Type:</p>
    <select name="evType" size="1">
    <option value="">All Types</option>
    <?php
    $typeQuery = "SELECT DISTINCT EVType FROM Vehicle_Types";
    $typeResult = $conn->query($typeQuery);
$typeResult = $conn->query($typeQuery);
    if ($typeResult) {
        while ($typeRow = $typeResult->fetch_assoc()) {
            $evType = htmlspecialchars($typeRow['EVType']);
            echo "<option value=\"$evType\">$evType</option>";
        }
    } else {
        echo "<option value=\"\">No EV types found</option>";
    }
    ?>
    </select>



    <p>Select CAFV Eligibility:</p>
    <select name="cafEligibility" size="1">
    <option value="">All Eligibilities</option>
    <?php
    $cafQuery = "SELECT DISTINCT CAFV_Eligibility FROM Vehicle_Types";
    $cafResult = $conn->query($cafQuery);
    if ($cafResult) {
        while ($cafRow = $cafResult->fetch_assoc()) {
            $cafEligibility = htmlspecialchars($cafRow['CAFV_Eligibility']);
            echo "<option value=\"$cafEligibility\">$cafEligibility</option>";
        }
    } else {
        echo "<option value=\"\">No CAFV eligibility found</option>";
    }
    ?>
    </select>
<p>Select a County:</p>
    <select name="county" size = "1">
    <option value="">All Counties</option>
    <?php
    $countyQuery = "SELECT DISTINCT County FROM Registrations";
    $countyResult = $conn->query($countyQuery);
    if ($countyResult){
        while ($countyRow=$countyResult->fetch_assoc()){
           $county=htmlspecialchars($countyRow['County']);
       echo "<option value=\"$county\">$county</option>";
       }
    }else{
            echo "<option value=\"\">No Counties Found</option>";
    }
    ?>
    </select>

    <p>Select a City:</p>
    <select name="city" size="1">
        <option value="">All Cities</option>
        <?php
        $cityQuery = "SELECT DISTINCT City FROM Registrations";
        $cityResult = $conn->query($cityQuery);
        if ($cityResult) {
            while ($cityRow = $cityResult->fetch_assoc()) {
                $city = htmlspecialchars($cityRow['City']);
                echo "<option value=\"$city\">$city</option>";
        }
        } else {
                echo "<option value=\"\">No Cities Found</option>";                             }
        ?>
    </select>

    <p>Select a State:</p>
    <select name="state" size="1">
        <option value="">All States</option>
        <?php
        $stateQuery = "SELECT DISTINCT State FROM Registrations";
        $stateResult = $conn->query($stateQuery);
        if($stateResult){
                while($stateRow=$stateResult->fetch_assoc()){
                        $state = htmlspecialchars($stateRow['State']);
                echo "<option value=\"$state\">$state</option>";
                }
        } else {
echo "<option value=\"\">No States Found</option>";
                }
        ?>
    </select>

    <p>Select a Utility Provider:</p>
    <select name="utilityProvider" size="1">
    <option value="">All Providers</option>
    <?php
    $utilityQuery = "SELECT DISTINCT Utility_Name FROM Utilities_Providers";
    $utilityResult = $conn->query($utilityQuery);
    if ($utilityResult) {
        while ($utilityRow = $utilityResult->fetch_assoc()) {
            $utilityName = htmlspecialchars($utilityRow['Utility_Name']);
            echo "<option value=\"$utilityName\">$utilityName</option>";
        }
    } else {
        echo "<option value=\"\">No Utility Providers Found</option>";
    }
    ?>
    </select>


    <p><input type="submit" value="Submit Query" /></p>
    <br><br>



</form>
</body>
</html>
