<?php

include("../config/protection.php");
include("../config/connexion.php");

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: liste.php");
    exit;
}

$id = (int) $_GET['id'];


/* Empêcher un administrateur de supprimer
   son propre compte */
if (
    isset($_SESSION['idUtilisateur']) &&
    (int) $_SESSION['idUtilisateur'] === $id
) {
    header("Location: liste.php?erreur=compte_actuel");
    exit;
}


$sql = "DELETE FROM utilisateur WHERE idUtilisateur = ?";

$stmt = mysqli_prepare($connexion, $sql);

if (!$stmt) {
    header("Location: liste.php?erreur=suppression");
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: liste.php?suppression=ok");
    exit;
}

mysqli_stmt_close($stmt);

header("Location: liste.php?erreur=suppression");
exit;

?>