<?php

require_once 'ApiHandler.php'; // Include the ApiHandler class

// Create an instance of ApiHandler
$apiHandler = new ApiHandler();

// Call the handleFormSubmission method
$apiHandler->handleFormSubmission();
?>

<!DOCTYPE html>
<html>
<head>
<title>Vaardigheden uit vacaturetekst filteren</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<h2>Vaardigheden vergelijker</h2>
<p>Deze tool vergelijkt de ingegeven vacaturetekst met jouw CV en geeft de overeenkomsten weer.</p><br>
    <form action="" method="post">
        <p>Vacature URL of tekst:</p>
		<textarea name="job" rows="7" cols="10" placeholder="voer hier de url of de tekst van de vacature in"></textarea>
        <p>cv</p>
        <textarea name="cv" rows="7" cols="10" placeholder="voer hier je cv in"></textarea>

        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
