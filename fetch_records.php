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
            $sql_records = "SELECT *
                            FROM isplata 
                            INNER JOIN vrsta ON isplata.vrstaID = vrsta.vrstaID 
                            WHERE isplata.korisnikID = ? ORDER BY datum";
            $stmt_records = $conn->prepare($sql_records);
            $stmt_records->bind_param("i", $selected_korisnikID);
            $stmt_records->execute();
            $result_records = $stmt_records->get_result();
            $records = $result_records->fetch_all(MYSQLI_ASSOC);

            if (!empty($records)) {
                echo "<table border='1'>";
                echo "<tr><th>Select</th><th>Naziv</th><th>Cijena</th><th>Datum</th></tr>";
                
                foreach ($records as $record) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='isplataIDs[]' value='" . $record['isplataID'] . "'></td>"; // Assuming 'isplataID' is the primary key
                    echo "<td>" . $record['naziv'] . "</td>";
                    echo "<td>" . $record['cijena'] . "</td>";
                    echo "<td>" . date('d/m/Y', strtotime($record['datum'])) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<br>";

            } else {
                echo "<h2>Sve utakmice su isplacene.</h2>";
            }
        }
        
        
        ?>


    </div>

</body>
</html>