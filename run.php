<?php 

define('ISCLI', PHP_SAPI === 'cli');

function error_handler($error_no, $error_msg) {
    echo "<pre>php setup.php</pre>";
}

if (ISCLI) {
    $env = '.env';

    if (!file_exists($env)) {
        $handle = fopen($env, 'w') or die('Cannot open file:  '.$env);
        $env_variables = [
            'GOOGLE_SHEETS_ID' => '',
            'GOOGLE_SHEETS_CREDENTIAL' => 'credentials',
            'GOOGLE_SHEETS_NAME' => 'Sheet', 
        ];
        $data = '';
        foreach ($env_variables as $key => $value) {
            $data .= $key.'='.$value."\n";
        }
        fwrite($handle, $data);
        fclose($handle);
    }

    return true;
}
else {
    // set_error_handler('error_handler');
    throw new Exception("Warning! You cannot execute this file using the browser. Use PHP CLI  by running php setup.php");
}