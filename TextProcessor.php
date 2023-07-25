<?php
class TextProcessor
{
    public function getPlainTextFromUrl($url)
    {
        $html = file_get_contents($url);
        return strip_tags($html);
    }

    public function prepareDataForApi($vacaturetekst, $cv)
    {
        return [
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Extract the required skills and tools from the following job offer:',
                ],
                [
                    'role' => 'user',
                    'content' => $vacaturetekst,
                ],
                [
                    'role' => 'system',
                    'content' => 'and the candidate\'s CV:',
                ],
                [
                    'role' => 'user',
                    'content' => $cv,
                ],
                [
                    'role' => 'system',
                    'content' => 'Compare them and return a table of required skills and tools(use just one word for a skill or tool), a table of resume skills and tools (use just one word for a skill or tool), and a table of matching skills and tools found in both texts(use just one word for a skill or tool)',
                ],
            ],
            'temperature' => 0,
            'max_tokens' => 3000,
            'model' => 'gpt-3.5-turbo-16k',
        ];
    }
}
?>
