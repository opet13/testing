<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studio Prices</title>
</head>
<body>
    <h1>Studio Prices</h1>
    <table>
        <tr>
            <th>Studio</th>
            <th>Price</th>
        </tr>
        <?php
        // Define prices for each studio
        $studio_prices = array(
            "Tap Dance" => 50.00,
            "Irish Dance" => 60.00,
            "Clogging Dance" => 70.00
        );

        // Loop through each studio and display its price
        foreach ($studio_prices as $studio => $price) {
            echo "<tr>";
            echo "<td>$studio</td>";
            echo "<td>RM " . number_format($price, 2) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
