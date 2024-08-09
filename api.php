<?php
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Headers: *");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

class ChuckNorrisAPI {
    private $jokes = [
        "Chuck Norris doesn’t read books. He stares them down until he gets the information he wants.",
        "Time waits for no man. Unless that man is Chuck Norris.",
        "Chuck Norris can divide by zero.",
        "Chuck Norris can do a wheelie on a unicycle.",
        "When Chuck Norris enters a room, he doesn’t turn the lights on. He turns the dark off."
    ];

    private $validUsername = "admin";
    private $validPassword = "password";

    public function __construct() {
        $this->handleRequest();
    }

    private function handleRequest() {
        // Check for basic authentication headers
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            $this->sendResponse(401, "Unauthorized");
            return;
        }

        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        if ($this->authenticate($username, $password)) {
            $this->sendResponse(200, $this->getRandomJoke());
        } else {
            $this->sendResponse(401, "Unauthorized");
        }
    }

    private function authenticate($username, $password) {
        return $username === $this->validUsername && $password === $this->validPassword;
    }

    private function getRandomJoke() {
        return $this->jokes[array_rand($this->jokes)];
    }

    private function sendResponse($statusCode, $message) {
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $statusCode . " " . $this->getStatusMessage($statusCode));
        echo json_encode(["message" => $message]);
        exit();
    }

    private function getStatusMessage($statusCode) {
        $status = [
            200 => "OK",
            401 => "Unauthorized",
            404 => "Not Found"
        ];
        return $status[$statusCode] ?? "Unknown Status";
    }
}

// Instantiate the API to handle the request
new ChuckNorrisAPI();
?>
