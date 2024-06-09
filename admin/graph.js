// Récupérer les données pour le graphique depuis la base de données
<?php
$chartLabels = array();
$chartData = array();

$sql = "SELECT label, value FROM table_des_donnees";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $chartLabels[] = $row['label'];
        $chartData[] = $row['value'];
    }
}
?>

// Générer le graphique
var ctx = document.getElementById('chart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($chartLabels); ?>,
        datasets: [{
            label: 'Données',
            data: <?php echo json_encode($chartData); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});