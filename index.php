<!DOCTYPE html>
<html>
<head>
<title>Vaardigheden uit vacaturetekst filteren</title>
</head>
<body>

<form action="" method="post">
    <p>vacaturetekst URL:</p>
    <input type="url" name="url_vacaturetekst" size="100" placeholder="voer hier de URL van de vacaturetekst in">
    <p>cv</p>
    <textarea name="cv" rows="10" cols="50" placeholder="voer hier je cv in"></textarea>
    <br>
    <input type="submit" value="Submit">
</form>

<?php
require_once 'ApiHandler.php';
require_once 'TextProcessor.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url_vacaturetekst = $_POST['url_vacaturetekst'];
    $cv = $_POST['cv'];

    // Initialize TextProcessor and ApiHandler
    $textProcessor = new TextProcessor();
    $apiHandler = new ApiHandler();

    // Get plain text from the URL
    $vacaturetekst = $textProcessor->getPlainTextFromUrl($url_vacaturetekst);

    // Prepare data for API call
    $data = $textProcessor->prepareDataForApi($vacaturetekst, $cv);

    // Make the API call
    $response = $apiHandler->callOpenAI_API($data);

    // Handle API response
    if (!$response) {
        echo "Failed to communicate with the API.";
    } else {
        if (isset($response['error'])) {
            echo "API Error: " . $response['error']['message'];
        } else {
            // Display the generated output
            if (isset($response['choices'][0]['message']['content'])) {
                echo "<h2>Resultaat:</h2>";
                echo nl2br($response['choices'][0]['message']['content']);
            } else {
                echo "Failed to extract skills.";
            }
        }
    }
}
?>
</body>
</html>
