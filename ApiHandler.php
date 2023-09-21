
<?php
class ApiHandler
{
    // Function to check if the given text is a URL
    private function isUrl($text)
    { 
        // Use a regular expression to check the URL
        $pattern = '/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i';

        // Use preg_match to compare the text with the pattern
        return preg_match($pattern, $text);
    }

    public function handleFormSubmission()
    {
        // Controleer of het formulier is ingediend
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Controleer of de vereiste velden zijn ingevuld
            if (isset($_POST['job']) && isset($_POST['cv'])) {
                // Haal de ingediende gegevens op
                $job = $_POST['job'];
                $cv = $_POST['cv'];

                // Controleer of $job een URL is
                if ($this->isUrl($job)) {
                    // Text processing for job offer and CV
                    $jobOfferText = $this->getPlainTextFromUrl($job);
                } else {
                    $jobOfferText = $job;
                }
$prompt_job = $this->read_prompt_job();
                // Define the data for the API call for the job offer
                $data_job_offer = [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $prompt_job,
						],
                        [
                            'role' => 'user',
                            'content' => $jobOfferText,
                        ],
                    ],
                    'temperature' => 0,
                    'max_tokens' => 3000,
                    'model' => 'gpt-4',
                ];

                // Make the API call for the job offer
                $response_job_offer = $this->call_openai_api($data_job_offer);
	
				// Get the matching skills from the API response
				$job = $response_job_offer['choices'][0]['message']['content'];

				// Count the skills in the matching skills result
				$count_job = count(explode(" ", strip_tags($job)));
				
				$prompt_cv = $this->read_prompt_cv();
                // Define the data for the API call for the CV
                $data_cv = [
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $prompt_cv,
							],
                        [
                            'role' => 'user',
                            'content' => $cv,
                        ],
                    ],
                    'temperature' => 0,
                    'max_tokens' => 3000,
                    'model' => 'gpt-4',
                ];

                // Make the API call for the CV
                $response_cv = $this->call_openai_api($data_cv);
				
$prompt_match = $this->read_prompt_match();
                // Make an API call to compare job offer and CV responses
			$data_match = [
				'messages' => [
            [
                'role' => 'system',
                'content' => $prompt_match,
			],
            [
                'role' => 'user',
                'content' => $response_job_offer['choices'][0]['message']['content'],
            ],
            [
                'role' => 'system',
                'content' => 'CV',
            ],
            [
                'role' => 'user',
                'content' => $response_cv['choices'][0]['message']['content'],
            ],
        ],
        'temperature' => 0,
        'max_tokens' => 3000,
        'model' => 'gpt-4',
    ];

    $response_match = $this->call_openai_api($data_match);
	
	$prompt_missing = $this->read_prompt_missing();
	// Get the matching skills from the API response
	$matching_skills_result = $response_match['choices'][0]['message']['content'];
	
	                // Make an API call to compare job offer and CV responses
			$data_missing = [
				'messages' => [
            [
                'role' => 'system',
                'content' => $prompt_missing,
			],
            [
                'role' => 'user',
                'content' => $response_job_offer['choices'][0]['message']['content'],
            ],
            [
                'role' => 'system',
                'content' => 'CV',
            ],
            [
                'role' => 'user',
                'content' => $response_match['choices'][0]['message']['content'],
            ],
        ],
        'temperature' => 0,
        'max_tokens' => 3000,
        'model' => 'gpt-4',
    ];

    $response_missing = $this->call_openai_api($data_missing);
	
	// Get the matching skills from the API response
	$missing_skills_result = $response_missing['choices'][0]['message']['content'];

	// Count the skills in the matching skills result
	$count_matching_skills = count(explode(" ", strip_tags($matching_skills_result)));
	$percentage = $count_matching_skills / $count_job *100;
    $afgerond = number_format($percentage, 2);
    // Store the data in the session to access it in the results page
    session_start();
	$jobtxt = $_SESSION['jobtxt'];
    $cvtxt = $_SESSION['cvtxt'];
    $_SESSION['job_offer'] = $response_job_offer['choices'][0]['message']['content'];
    $_SESSION['cv'] = $response_cv['choices'][0]['message']['content'];
    $_SESSION['matching_skills'] = $response_match['choices'][0]['message']['content'];
	$_SESSION['missing_skills'] = $response_missing['choices'][0]['message']['content'];
	$_SESSION['match'] = $afgerond . "%";
	$_SESSION['jobtxt'] = $jobtxt;
    $_SESSION['cvtxt'] = $cvtxt;			
                // Redirect to the results page to display the API response
                //header("Location: results.php");
				echo "<script> location.href='results.php'; </script>";
                exit();
            } else {
                // Als de vereiste velden niet zijn ingevuld, terugsturen naar het formulier met een foutmelding
                header("Location: index.php?error=missing_fields");
                exit();
            }
        }
    }

    // Function to read the API key from the file
    private function read_api_key()
    {
        $file = "Code/api.txt"; // Replace with the path to your api_key.txt file
        $api_key = trim(file_get_contents($file));
        return $api_key;
    }
 private function read_prompt_job()
    {
        $file = "prompt_job.txt"; // Replace with the path to your api_key.txt file
        $prompt_job = trim(file_get_contents($file));
        return $prompt_job;
    }
	 private function read_prompt_cv()
    {
        $file = "prompt_cv.txt"; // Replace with the path to your api_key.txt file
        $prompt_cv = trim(file_get_contents($file));
        return $prompt_cv;
    }
	 private function read_prompt_match()
    {
        $file = "prompt_match.txt"; // Replace with the path to your api_key.txt file
        $prompt_match = trim(file_get_contents($file));
        return $prompt_match;
    }
	 private function read_prompt_missing()
    {
        $file = "prompt_missing.txt"; // Replace with the path to your api_key.txt file
        $prompt_missing = trim(file_get_contents($file));
        return $prompt_missing;
    }
    // Function to make the API call using cURL
    private function call_openai_api($data)
    {
        $api_key = $this->read_api_key();
        $url = 'https://api.openai.com/v1/chat/completions';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            // Display cURL error if any
            echo 'cURL error: ' . curl_error($ch);
        }
        curl_close($ch);

        return json_decode($response, true);
    }

    // Function to get plain text from a URL and remove HTML tags
    private function getPlainTextFromUrl($url)
    {
        $html = file_get_contents($url);
        return strip_tags($html);
    }
}
?>
