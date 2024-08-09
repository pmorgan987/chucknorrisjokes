<?php
class ChuckNorrisAPIClient {
    private $apiUrl = "https://www.patrick-morgan.com/chucknorris/api.php"; // Replace with the actual URL of the API
    private $username = "admin";
    private $password = "password";

    public function getJoke() {
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);

        // Set the basic authentication headers
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);

        // Return the response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Check if the request was successful
        if (curl_errno($ch)) {
            echo "Request Error: " . curl_error($ch);
        } else {
            // Parse and display the response
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode == 200) {
                $data = json_decode($response, true);
                echo "Random Chuck Norris Joke: " . $data['message'];
            } else {
                echo "Failed to get joke. HTTP Status Code: " . $httpCode;
            }
        }

        // Close the cURL session
        curl_close($ch);
    }
}

// Instantiate the client and fetch a joke
$client = new ChuckNorrisAPIClient();
$client->getJoke();
?>