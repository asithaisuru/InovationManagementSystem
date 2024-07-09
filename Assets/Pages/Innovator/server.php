<?php

// gemini-api-php client library
require_once('../../../vendor/autoload.php');

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;
use Dotenv\Dotenv;

// Load the environment variables from the .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();
$apiKey = $_ENV['API_KEY'];

// Project description sent from the client-side
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['description'])) {
  echo json_encode(array('error' => 'Please provide a project description from server.php'));
  exit;
}

// Gemini client instance
$client = new Client($apiKey);

// prompt for Gemini
$prompt = "Given a project description of: " . $data['description'] . ", Break this into manageable tasks for a person. give me only the task and a brief description paragraph of the task. SEND THE DATA AS IN A DIV TAG. TOPICS IN A H3 TAG AND DISCRIPTION IN A P TAG.";

// Send the prompt and get the response
$response = $client->geminiPro()->generateContent(
  new TextPart($prompt)
);

// Extract the generated tasks from the response (adjust based on format)
$generatedTasks = $response->text();

// Send the generated tasks back to the client-side as JSON
echo json_encode(array('tasks' => $generatedTasks));
