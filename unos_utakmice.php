<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $vrstaIDs = isset($_POST['vrstaID']) ? $_POST['vrstaID'] : array();
    $datum = $_POST['datum'];
    $troskoviID = isset($_POST['troskoviID']) ? $_POST['troskoviID'] : array();

    foreach ($_POST['korisnikID'] as $korisnikID) {
        foreach ($vrstaIDs as $vrstaID) {
            $sql = "INSERT INTO isplata (korisnikID, vrstaID, datum) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $korisnikID, $vrstaID, $datum);
            $stmt->execute();
        }

        if (!empty($troskoviID)) {
            foreach ($troskoviID as $selectedTroskoviID) {
                $sql = "INSERT INTO putarina (korisnikID, troskoviID, datum) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iis", $korisnikID, $selectedTroskoviID, $datum);
                $stmt->execute();
            }
        }
    }
}

header('location: admin_dashboard.php');
?>
