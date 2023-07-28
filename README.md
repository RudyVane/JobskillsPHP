# Skills Extraction from Job Description and CV

This is a simple web application that allows users to extract required skills and tools from a job description and a candidate's CV. The application makes use of the OpenAI GPT-3.5 Turbo model to process the input texts and generate the desired output. It also can write a motivation letter for the job

## Prerequisites

Before running the application, you need to make sure you have the following components installed:

- PHP: The application is built using PHP, so you need to have PHP installed on your server or local machine.

## Getting Started

1. Clone the repository or download the files to your local machine.

2. Ensure you have an API key from OpenAI to make API calls to their service. Create a file named `api.txt` in the root directory of the project and paste your API key into it.

3. Place the extracted files (index.php, ApiHandler.php, TextProcessor.php) into the desired directory on your server or local machine.

4. Start a web server with PHP support in the root directory of the project.

5. Open your web browser and navigate to your url

## How to Use

1. On the main page, you will see a form with two input fields:
   - **vacaturetekst of URL**: Enter the URL of the job description or the text of the job description.
   - **cv**: Enter the candidate's CV.

2. Click the **Overeenkomende vaardigheden zoeken** button for matching skills.
3. Click the **Motivatiebrief schrijven** button to write a motivation letter.

4. The application will then extract the required skills and tools from both the job description and the CV, and it will display the results in a table format. It also shows the matching percentage, or it will generate a motivation letter.


## Acknowledgments

This project uses the OpenAI GPT-3.5 Turbo model for natural language processing. Special thanks to OpenAI for providing access to their API.

## Disclaimer

This project is provided as-is and is meant for educational and experimental purposes. The accuracy of the skills extraction process heavily relies on the capabilities of the GPT-3.5 Turbo model and the quality of the input texts. Please use it responsibly and always review the results manually for accuracy and relevance.
