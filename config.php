<?php

if (!function_exists('env')) {
    function env($key=null) {
        $env = [];
        $contents = file_get_contents('.env');
        $lines = array_filter(explode("\n", $contents));
        foreach($lines as $line) {
            $keypair = explode("=", $line);
            $env[$keypair[0]] = $keypair[1];
        }

        if (is_null($key)) {
            return $env;
        }
        else {
            return trim($env[$key]);
        }
    }
}