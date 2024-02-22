<?php

require_once 'config.php';
if(!isset($_SESSION['korisnikID'])){
    header('location: korisnikLogin.php');
 exit;
}

$korisnikID = $_SESSION['korisnikID'];
$sql = "SELECT * FROM korisnik WHERE korisnikID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $korisnikID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


if($user['usertype'] != 'admin'){
    header('location: index.php');
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://kit.fontawesome.com/3277c2990b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<form class="forma" action="unos_utakmice.php" method="post" enctype="multipart/form-data">

    <header>
        <img class="slika" src="logoKSZDK.png">
        <nav class="navigation">
            <a class="a" href="index.php">Pocetna</a>
            <a class="a" href="">Kontakt</a>
            <a class="btnlogin-popup" href="isplati_sudiju.php">Isplata</a>  
        </nav>
    </header>

    <div class="container">
        <div class="select-btn">
            <span class="btn-text">Izaberi sudiju</span>
            <span class="arrow-dwn">
                <i class="fa-solid fa-chevron-down"></i>
            </span>
        </div>
        <ul class="list-items">
            <?php
            $sql = "SELECT * FROM korisnik";
            $run = $conn->query($sql);
            $results = $run->fetch_all(MYSQLI_ASSOC);

            foreach ($results as $result) {
                if ($result['usertype'] == 'user') { ?>
            
                <li class="item">
                    <span class="item-text">
                        <input  type='checkbox' name='korisnikID[]' value='<?php echo $result["korisnikID"]; ?>'><?php echo "{$result["username"]}<br>"; ?>
                    </span>
                </li>
                <?php
                }
            }
            ?>
        </ul>

        
</div>

    <div class="srednji">
        <input type="submit" class="submit-button" value="Uplati">
        <input class="date" type="date" id="datum" name="datum"><br>

        <div class="select-btn3">
        <span class="btn-text3">Putni troskovi</span>
        <span class="arrow-dwn3">
            <i class="fa-solid fa-chevron-down"></i>
        </span>
    </div>
    <ul class="list-items3">
    <?php
    $sql = "SELECT * FROM troskovi ORDER by cijena";
    $run = $conn->query($sql);
    $results = $run->fetch_all(MYSQLI_ASSOC);

    foreach ($results as $result) {
        ?>
        <li class="item3">
            <span class="item-text3">
                <input type='checkbox' name='troskoviID[]' value='<?php echo $result["troskoviID"]; ?>'><?php echo "{$result["naziv"]} {$result["cijena"]}<br>"; ?>
            </span>
        </li>
        <?php
    }
    ?>
    </ul>
    </div>

<div class="container2">
    <div class="select-btn2">
        <span class="btn-text2">Odaberi Utakmicu</span>
        <span class="arrow-dwn2">
            <i class="fa-solid fa-chevron-down"></i>
        </span>
    </div>

    <ul class="list-items2">
    <?php
    $sql = "SELECT * FROM vrsta";
    $run = $conn->query($sql);
    $results = $run->fetch_all(MYSQLI_ASSOC);

    foreach ($results as $result) {
        ?>
        <li class="item2">
            <span class="item-text2">
                <input type='checkbox' name='vrstaID[]' value='<?php echo $result["VrstaID"]; ?>'><?php echo "{$result["naziv"]} {$result["cijena"]}<br>"; ?>
            </span>
        </li>
        <?php
    }
    ?>
    </ul>


</div>



</form>


<script src="admin.js"></script>
</body>
</html>