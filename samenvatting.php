<?php

session_start();
    $tekst = $_SESSION['txt'];
              
?>

<!DOCTYPE html>
<html>
<head>
<title>Samenvatting</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script>
        // JavaScript function to go back to index.php
        function goBack() {
            window.location.href = 'riepe.php';
        }
    </script>
</head>
<body>
<button onclick="goBack()">Terug naar startpagina</button><br>
<h2>Samenvatting</h2><br>
    <div class="flex-container" style =  "text-align: center">

        <!-- Display variable 1:  -->
        <div class="flex-item">
            
            <p><?php echo nl2br($tekst); ?></p>
        </div>

    </div>
	
</body>
</html>
