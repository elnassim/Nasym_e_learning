<?php
include '../../source/mysqlcon.php';

// Récupérer l'ID du professeur à partir de l'URL
$professorID = $_GET['id'] ?? '';

if (!empty($professorID)) {
    // Insérer une nouvelle demande de suppression dans la table ProfRequests
    $sql = "INSERT INTO ProfRequests (ProfessorID, RequestStatus) VALUES (:professorID, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':professorID', $professorID);
    $stmt->execute();

    // Rediriger vers la page précédente avec un message de confirmation
    $message = "La demande de suppression pour le professeur ID " . $professorID . " a été envoyée.";
    header("Location: /user_management.php?message=" . urlencode($message));
    exit();
} else {
    // Rediriger vers la page précédente avec un message d'erreur
    $message = "Erreur : ID du professeur manquant.";
    header("Location: /user_management.php?message=" . urlencode($message));
    exit();
}