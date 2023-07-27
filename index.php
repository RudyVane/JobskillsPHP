<!DOCTYPE html>
<html>
<head>
    <title>Vaardigheden uit vacaturetekst filteren</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <style>
        /* Style for the modal overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        /* Style for the modal content */
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        /* Style for the loading spinner */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        function showLoadingModal() {
            // Create the modal overlay
            var modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay';

            // Create the modal content
            var modalContent = document.createElement('div');
            modalContent.className = 'modal-content';

            // Create the loading spinner
            var loader = document.createElement('div');
            loader.className = 'loader';

            // Append loading spinner and "Wait a moment..." text to the modal content
            modalContent.appendChild(loader);
            modalContent.appendChild(document.createTextNode('Ik ben aan het denken...'));

            // Append modal content to the overlay
            modalOverlay.appendChild(modalContent);

            // Add the modal overlay to the body
            document.body.appendChild(modalOverlay);
        }
    </script>
</head>
<body>
    <h2>Vaardigheden vergelijker</h2>
    <p>Deze tool vergelijkt de ingegeven vacaturetekst met jouw CV en geeft de overeenkomsten weer.</p><br>
    <form action="" method="post" onsubmit="showLoadingModal()">
        <p>Vacature URL of tekst:</p>
        <textarea name="job" rows="7" cols="10" required placeholder="voer hier de url of de tekst van de vacature in"></textarea>
        <p>cv</p>
        <textarea name="cv" rows="7" cols="10" required placeholder="voer hier je cv in"></textarea>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        require_once 'ApiHandler.php'; // Include the ApiHandler class

        // Create an instance of ApiHandler
        $apiHandler = new ApiHandler();

        // Call the handleFormSubmission method
        $apiHandler->handleFormSubmission();
    }
    ?>

</body>
</html>
