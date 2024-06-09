<?php
include '../../source/mysqlcon.php';

$link = $conn;

if (isset($_GET['resourceId'])) {
    $resourceId = $_GET['resourceId'];

    // Retrieve resource information from the database
    $query = "SELECT FilePath, ResourceName FROM CourseResources WHERE ResourceID = ?";
    $stmt = $link->prepare($query);
    $stmt->execute([$resourceId]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $filePath = $row['FilePath'];
        $resourceName = $row['ResourceName'];

        if (isset($_POST['confirmDelete'])) {
            // Delete the file from the directory
            if (unlink($filePath)) {
                // Delete the entry from the database
                $query = "DELETE FROM CourseResources WHERE ResourceID = ?";
                $stmt = $link->prepare($query);
                $stmt->execute([$resourceId]);

                // Redirect the user to the main resource page
                header('Location: support_maintenance.php');
                exit();
            } else {
                echo "An error occurred while deleting the file.";
            }
        }
    } else {
        $resourceName = "Resource not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supprimer une ressource</title>
  <link rel="stylesheet" href="styles/support_maintenance.css">
</head>
<body>
  <div class="confirmation-container">
    <h1>Supprimer la ressource</h1>
    <p>Voulez-vous vraiment supprimer la ressource "<?php echo $resourceName; ?>" ?</p>
    <form action="" method="POST">
      <button type="submit" name="confirmDelete" class="btn-delete">Oui, supprimer</button>
      <a href="support_maintenance.php" class="btn-cancel">Annuler</a>
    </form>
  </div>
</body>
</html>