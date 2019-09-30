<?php 

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';
require __DIR__ . '/LogSearcher.php';

if (isset($_FILES['log_file']) && !empty($_FILES['log_file'])) {
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["log_file"]["name"]);
    $uploadOk = 1;
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        exit;
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["log_file"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["log_file"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    
    $search = 'production.ERROR';
    $errors_compiled = new LogSearcher();
    $errors_compiled = $errors_compiled->compile_logs('uploads/'.$_FILES["log_file"]["name"], $search, true);
    
    $client = new Google_Client();
    $client->setApplicationName('Logs To Sheets API');
    // if read only
    // $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    // if update or insert
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
    $client->setAuthConfig(__DIR__.'/credentials/'.env('GOOGLE_SHEETS_CREDENTIAL').'.json');
    $client->setAccessType('offline');
    
    $service = new Google_Service_Sheets($client);
    $spreadsheetId = env('GOOGLE_SHEETS_ID');
    
    $range = env('GOOGLE_SHEETS_NAME')."!A2:F";
    
    // Updating & Inserting Data
    $values = [];
    
    foreach ($errors_compiled as $key => $value) {
        $dateTime = explode(" ", $value['date_time']);
        $date = $dateTime[0];
        $time = $dateTime[1];
        $lines = implode(", ", $value['line_occurence']);
        $values[] = [
            $date,
            $time,
            "",
            $value['error_snippet'],
            $value['count'],
            $lines,
            "",
            "Pending"
        ];
    }
    
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);
    
    $params = [
        "valueInputOption" => "RAW"
    ];
    // Insert
    $insert = [
        "insertDataOption" => "INSERT_ROWS"
    ];
    
    // Insert
        $result = $service->spreadsheets_values->append(
        $spreadsheetId,
        $range,
        $body,
        $params,
        $insert
    );

}




