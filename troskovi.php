<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="enis123.css" rel="stylesheet">
</head>
<body>
<div class="records">
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['korisnikID'])) {
            $selected_korisnikID = $_POST['korisnikID'];

            $sql_putarina = "SELECT putarina.*, troskovi.naziv, troskovi.cijena 
                            FROM putarina 
                            INNER JOIN troskovi ON putarina.troskoviID = troskovi.troskoviID 
                            WHERE putarina.korisnikID = ?
                            ORDER BY datum";
            $stmt_putarina = $conn->prepare($sql_putarina);
            $stmt_putarina->bind_param("i", $selected_korisnikID);
            $stmt_putarina->execute();
            $result_putarina = $stmt_putarina->get_result();
            $records_putarina = $result_putarina->fetch_all(MYSQLI_ASSOC);

            if (!empty($records_putarina)) {
                echo "<table border='1'>";
                echo "<tr><th>Select</th><th>Naziv</th><th>Cijena</th><th>Datum</th></tr>";
                foreach ($records_putarina as $record) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='putarinaIDs[]' value='" . $record['putarinaID'] . "'></td>";
                    echo "<td>" . $record['naziv'] . "</td>";
                    echo "<td>" . $record['cijena'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($record['datum'])) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<h2>Sva putarina je isplacena.</h2>";
            }
        }
    ?>
    </div>
</body>
</html>

