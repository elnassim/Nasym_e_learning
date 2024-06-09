<?php
include '../../source/mysqlcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si l'ID du professeur est présent dans les données postées
    if (isset($_POST['id'])) {
        $professorID = $_POST['id'];

        // Vérifier si les autres champs requis sont présents
        if (isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['email'])) {
            $lastName = $_POST['lastName'];
            $firstName = $_POST['firstName'];
            $email = $_POST['email'];

            // Mettre à jour les informations du professeur dans la base de données
            $sql = "UPDATE professors SET LastName = :lastName, FirstName = :firstName, Email = :email WHERE ProfessorID = :professorID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':professorID', $professorID);

            if ($stmt->execute()) {
                echo "Professor updated successfully.";
            } else {
                echo "Error updating professor.";
            }
        } else {
            echo "Missing required fields.";
        }
    } else {
        echo "Invalid professor ID.";
    }
} else {
    echo "Invalid request.";
}

// Fermer la connexion à la base de données
$conn = null;
?>