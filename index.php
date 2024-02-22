<?php

require_once 'config.php';

if(!$conn){
    die("Neuspjesna konekcija");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password']; 

    $sql = "SELECT korisnikID, password, usertype FROM korisnik WHERE username = ?";
    
    $run = $conn->prepare($sql);
    $run->bind_param("s", $username);
    $run->execute();
    $results = $run->get_result();

    if($results->num_rows == 1){

        $korisnik = $results->fetch_assoc();

        if($korisnik['password'] === $password) {
            $_SESSION['korisnikID'] = $korisnik['korisnikID'];

            if($korisnik['usertype'] == 'user') {
                header('location: isplata.php');
            } elseif($korisnik['usertype'] == 'admin') {
                header('location: admin_dashboard.php');
            } else {
                $_SESSION['error'] = "Unknown user type!";
                header('location: index.php');
                exit;
            }
            
        } else {
            $_SESSION['error'] = "Pogresan password!";
            header('location: index.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Korisnik ne postoji!";
        header('location: index.php');
        exit;
    }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KSZDK</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    
    <header>
        <img class="slika" src="logoKSZDK.png">
        
    </header>

    <div class="wrapper">
        <div class="form-box login">
            <h2>Login</h2>
            <form action="" method="POST">
                <div class="input-box">
                    <span class="icon"></span>
                    <input type="text" name="username" required>
                    <label>Ime i Prezime</label>
                </div>
                <div class="input-box">
                    <span class="icon"></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                
                <button type="submit" value="login" class="btn">Login</button>
                <?php

                    if(isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger alert-top-right" role="alert">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }

                ?>
                
            </form>
        </div>
    </div>

</body>
</html>