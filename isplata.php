<?php

require_once 'config.php';

if (!isset($_SESSION['korisnikID'])) {
    header('location: index.php');
    exit;
}

$sql = "SELECT username FROM korisnik WHERE korisnikID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["korisnikID"]);
$stmt->execute();
$result = $stmt->get_result();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="isplata.css">
</head>
<body>

    <header>
        <img class="slika" src="logoKSZDK.png">
        <h2 class="logo"></h2>
        <nav class="navigation">
            <a class="link" href="index.php">Pocetna</a>
            
        </nav>
        
    </header>

    

    <div class="container">
        <div class="left">
            <div class="naziv">
            <p>Naziv</p>
            <p>Cijena</p>
            <p>Datum</p>
            </div>
            <div class="dugovanja">
                <?php
                    $sql = "SELECT datum, vrstaID
                    FROM isplata
                    WHERE korisnikID = ?
                    ORDER BY datum";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION["korisnikID"]);
                $stmt->execute();
                $result = $stmt->get_result();
                
                $sum_cijena = 0; 
                
                if ($result->num_rows > 0) {
                    echo "<table><tr><th></th><th></th><th></th></tr>";
                
                    while ($row = $result->fetch_assoc()) {
                        $date = strtotime($row['datum']);
                        $new_date = date("d/m/Y", $date); 
                        $vrsta_id = $row['vrstaID']; 
                        
                        $sql2 = "SELECT naziv,cijena FROM vrsta WHERE vrstaID=?";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bind_param("i", $vrsta_id);
                        $stmt2->execute();
                        $result2 = $stmt2->get_result();
                
                        if ($result2->num_rows > 0) {
                            $row2 = $result2->fetch_assoc();
                            $naziv = $row2['naziv'];
                            $cijena = $row2['cijena'];

                            $sum_cijena += $cijena;
                
                            echo "<tr><td>" .  $naziv . "</td><td>" . $cijena . "</td><td>" . $new_date . "</td></tr>";
                        }
                    }
                
                    echo "</table>";
                } else {
                    echo "<h2>Isplaceno.</h2>";
                }
                

                $sql = "SELECT SUM(troskovi.cijena) AS sum_put 
                FROM putarina 
                INNER JOIN troskovi ON putarina.troskoviID = troskovi.troskoviID 
                WHERE putarina.korisnikID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION["korisnikID"]);
                $stmt->execute();
                $result = $stmt->get_result();

                $row = $result->fetch_assoc();
                $sum_put = !empty($row['sum_put']) ? $row['sum_put'] : '0';

                ?>
            </div>
            <div class="swrapper">
                <div class="suma"><?php echo "<h1>Dug utakmice: " . $sum_cijena . "KM</h1>"; ?></div>
                <div class="suma2"><?php echo "<h1> Dug putarine: " . $sum_put . "KM</h1>"; ?></div>
            </div>
        </div>
        

        <div class="right">
            <div class="naziv">
                <p>Naziv</p>
                <p>Cijena</p>
                <p>Datum</p>
            </div>
            <div class="isplaceno">
                <?php
                $sql = "SELECT datum, vrstaID
                FROM uplata
                WHERE korisnikID = ?
                ORDER BY datum";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION["korisnikID"]);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                echo "<table><tr><th></th><th></th><th></th></tr>";

                $sum_cijena = 0;

                while ($row = $result->fetch_assoc()) {
                    $date = strtotime($row['datum']);
                    $new_date = date("d/m/Y", $date);
                    $vrsta_id = $row['vrstaID'];

                    $sql2 = "SELECT naziv,cijena FROM vrsta WHERE vrstaID=?";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bind_param("i", $vrsta_id);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();

                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        $naziv = $row2['naziv'];
                        $cijena = $row2['cijena'];

                        $sum_cijena += $cijena;

                        echo "<tr><td>" .  $naziv . "</td><td>" . $cijena . "</td><td>" . $new_date . "</td></tr>";
                    }
                }
                echo "</table>";
                } else {
                echo "<h2>Isplaceno: 0 </h2>";
                }


                $sql = "SELECT SUM(troskovi.cijena) AS sum_put 
                    FROM isplacenaputarina 
                    INNER JOIN troskovi ON isplacenaputarina.troskoviID = troskovi.troskoviID 
                    WHERE isplacenaputarina.korisnikID = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_SESSION["korisnikID"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $row = $result->fetch_assoc();
                    $sum_put = !empty($row['sum_put']) ? $row['sum_put'] : '0';
                ?>

            </div>
                <div class="swrapper">
                    <div class="suma"><?php echo "<h1>Isplacene utakmice: " . $sum_cijena . "KM</h1>"; ?></div>
                    <div class="suma2"><?php echo "<h1>Isplacena putarina: " . $sum_put . "KM</h1>"; ?></div>
                </div>
        </div>
    </div>
</body>
</html>