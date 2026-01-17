<?php

$download_link = "https://github.com/D00MK1D/DDON-Launcher-WPF/releases/latest/download/DDO_Launcher.exe";
$github_url = "https://api.github.com/repos/D00MK1D/DDON-Launcher-WPF/releases/latest";

// Initialize cURL
$ch = curl_init($github_url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'PHP');

// Execute the cURL request
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Decode the JSON data
$data = json_decode($response, true);

tassign_array(["PAGE_TITLE" => "Download", "page_active" => "Download", "DOWNLOAD_LINK" => $download_link, "LAUNCHER_VERSION" => $data['tag_name']]);
tdisplay('download');

?>