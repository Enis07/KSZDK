<?php

require_once 'config.php';


$sql_users = "SELECT * FROM korisnik";
$stmt_users = $conn->query($sql_users);
$users = $stmt_users->fetch_all(MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transfer User Records</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="isplati_sudiju.css" rel="stylesheet">
    
</head>
<body>

<header>
        <img class="slika" src="logoKSZDK.png">
        <h2 class="logo"></h2>
        <nav class="navigation">
            <a class="link" href="index.php">Pocetna</a>
            <a class="link" href="#">Kontakt</a>
            <button class="btnlogin-popup" onclick="window.location.href='admin_dashboard.php'">Uplata</button>
        </nav>
    </header>


<form class="wrapper" action="process_form.php" method="post" id="userForm">

    <div class="left-side">

        <div class="forma">
                <select class="izbor" name="korisnikID" id="korisnik">
                    <option value="" disabled selected>Isplati sudiju</option>
                    <?php foreach ($users as $user): ?>
                        <?php if ($user['usertype'] !== 'admin'): ?>
                            <option value="<?php echo $user['korisnikID']; ?>"><?php echo $user['username'] ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <br><br>
        </div>
        
        <div class="button-container">
        <input type="submit" name="delete" value="Isplati" id="isplatiButton">
        </div>

    </div>
    
    <div class="right-side">
    <div class="swrapper">
        <div class="table-container">
            <table id="userRecordsTable">
                <thead>
                    <!-- Table header content here -->
                </thead>
                <tbody>
                    <h2 id="noUserMessage">Korisnik nije izabran</h2>
                </tbody>
            </table>  
        </div>
        <div class="suma" id="sumUplata"></div>

    </div>

    <div class="swrapper">
        <div class="table-container2">
            <table id="userRecordsTable2">
                <thead>
                    <!-- Table header content here -->
                </thead>
                <tbody>
                    <h2 id="noUserMessage2">Korisnik nije izabran</h2>
                </tbody>
            </table>
        </div>

        <div class="suma" id="sumIsplacenaputarina"></div>
    </div>


</form>

    


<script src="isplati_sudiju.js"></script>

</body>
</html>