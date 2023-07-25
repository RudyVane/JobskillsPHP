<?php
class ApiHandler
{
    private function readApiKey()
    {
        $file = "api.txt"; // Replace with the path to your api_key.txt file
        $api_key = trim(file_get_contents($file));
        return $api_key;
    }

    public function callOpenAI_API($data)
    {
        $api_key = $this->readApiKey();
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
        curl_close($ch);

        return json_decode($response, true);
    }
}
?>
