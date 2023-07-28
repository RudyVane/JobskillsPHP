<?php

session_start();
    $motivation = $_SESSION['motivation'];
              
?>

<!DOCTYPE html>
<html>
<head>
<title>Motivatiebrief</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<button onclick="goBack()">Terug naar startpagina</button><br>
<h2>Motivatiebrief</h2><br>
    <div class="flex-container" style =  "text-align: center">

        <!-- Display variable 1:  -->
        <div class="flex-item">
            
            <p><?php echo nl2br($motivation); ?></p>
        </div>

    </div>
<script>
        // JavaScript function to go back to index.php
        function goBack() {
            window.location.href = 'index.php';
        }
    </script>	
</body>
</html>
