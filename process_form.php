<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['korisnikID'])) {
        $korisnikID = $_POST['korisnikID'];

        if (isset($_POST['delete']) && isset($_POST['isplataIDs']) && is_array($_POST['isplataIDs'])) {
            
            foreach ($_POST['isplataIDs'] as $isplataID) {
                $sql_insert_uplata = "INSERT INTO uplata (korisnikID, vrstaID) VALUES (?, ?)";
                $stmt_insert_uplata = $conn->prepare($sql_insert_uplata);
                $stmt_insert_uplata->bind_param("ii", $korisnikID, $isplataID);
                if (!$stmt_insert_uplata->execute()) {
                    echo "Error during insertion into uplata: " . $stmt_insert_uplata->error;
                }

                $sql_delete_isplata = "DELETE FROM isplata WHERE isplataID = ? AND korisnikID = ?";
                $stmt_delete_isplata = $conn->prepare($sql_delete_isplata);
                $stmt_delete_isplata->bind_param("ii", $isplataID, $korisnikID);
                if (!$stmt_delete_isplata->execute()) {
                    echo "Error during deletion from isplata: " . $stmt_delete_isplata->error;
                }
            }
            header('Location: Isplati_sudiju.php');
            exit;
        } elseif (isset($_POST['delete']) && isset($_POST['putarinaIDs']) && is_array($_POST['putarinaIDs'])) {
           
            foreach ($_POST['putarinaIDs'] as $putarinaID) {

                $sql_insert_isplacenaputarina = "INSERT INTO isplacenaputarina (korisnikID, troskoviID) SELECT ?, troskoviID FROM putarina WHERE putarinaID = ?";
                $stmt_insert_isplacenaputarina = $conn->prepare($sql_insert_isplacenaputarina);
                $stmt_insert_isplacenaputarina->bind_param("ii", $korisnikID, $putarinaID);
                if (!$stmt_insert_isplacenaputarina->execute()) {
                    echo "Error during insertion into isplacenaputarina: " . $stmt_insert_isplacenaputarina->error;
                }

                $sql_delete_putarina = "DELETE FROM putarina WHERE putarinaID = ?";
                $stmt_delete_putarina = $conn->prepare($sql_delete_putarina);
                $stmt_delete_putarina->bind_param("i", $putarinaID);
                if (!$stmt_delete_putarina->execute()) {
                    echo "Error during deletion from putarina: " . $stmt_delete_putarina->error;
                }
            }
            header('Location: Isplati_sudiju.php');
            exit;
        }
    } else {
        echo "No user selected.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['korisnikID'])) {
    $korisnikID = $_POST['korisnikID'];

    $sql_uplata = "SELECT SUM(troskovi.cijena) AS sum_uplata 
                   FROM uplata 
                   INNER JOIN troskovi ON uplata.vrstaID = troskovi.troskoviID 
                   WHERE uplata.korisnikID = ?";
    $stmt_uplata = $conn->prepare($sql_uplata);
    $stmt_uplata->bind_param("i", $korisnikID);
    $stmt_uplata->execute();
    $result_uplata = $stmt_uplata->get_result();
    $row_uplata = $result_uplata->fetch_assoc();
    $sum_uplata = $row_uplata['sum_uplata'] ?? 0;

    $sql_isplacenaputarina = "SELECT SUM(troskovi.cijena) AS sum_isplacenaputarina 
                              FROM isplacenaputarina 
                              INNER JOIN troskovi ON isplacenaputarina.troskoviID = troskovi.troskoviID 
                              WHERE isplacenaputarina.korisnikID = ?";
    $stmt_isplacenaputarina = $conn->prepare($sql_isplacenaputarina);
    $stmt_isplacenaputarina->bind_param("i", $korisnikID);
    $stmt_isplacenaputarina->execute();
    $result_isplacenaputarina = $stmt_isplacenaputarina->get_result();
    $row_isplacenaputarina = $result_isplacenaputarina->fetch_assoc();
    $sum_isplacenaputarina = $row_isplacenaputarina['sum_isplacenaputarina'] ?? 0;

    echo json_encode(array("sum_uplata" => $sum_uplata, "sum_isplacenaputarina" => $sum_isplacenaputarina));
} else {
    echo "Error: Invalid request";
}
?>
