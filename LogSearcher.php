<?php

class LogSearcher {

    public $error_count = 0;
 
    public function find_logs($filename, $search, $case_sensitive=false) {
        $line_number = [];
        $re = '/([^{}()]*)/m';
        if ($file_handler = fopen($filename, "r")) {
            $i = 0;
            while ($line = fgets($file_handler)) {
                $i++;
                //case sensitive is false by default
                if($case_sensitive == false) {	
                    $search = strtolower($search);  //convert file and search string
                    $line = strtolower($line); 		//to lowercase
                }
                //find the string and store it in an array
                if(strpos($line, $search) !== false){
                    preg_match($re, $line, $match);
                    preg_match('#\[(.*?)\]#', $match[0], $date_time);
                    preg_match('/^.+?\](.+)$/is', $match[0], $error_snippet);
                    $line_number[] = [
                        "line" => $i,
                        "date_time" => $date_time[1],
                        "error_snippet" => $error_snippet[1],
                    ];
                }
            }
            fclose($file_handler);
        }else{
            return "File not exists, Please check the file path or filename";
        }
        //if no match found
        if(count($line_number)){
            // return substr($line_number, 0, -1);
            return $line_number;
        }else{
            return "No match found";
        }
    }

    public function compile_logs($filename, $search, $case_sensitive=false) {

        $arr = $this->find_logs($filename, $search, $case_sensitive);

        $curr_error = null;
        $error_compiled = [];
        foreach ($arr as $key => $value) {
            if (!array_key_exists($value['error_snippet'], $error_compiled)) {
                
                if (is_null($curr_error)) {
                    $curr_error = $value['error_snippet'];
                    $error_compiled[$curr_error] = [
                        "date_time" => $value['date_time'],
                        "error_snippet" => $value['error_snippet'],
                        "line_occurence" => [],
                        "count" => 0,
                    ]; 
                    foreach ($arr as $err_key => $err_val) {
                        if ($err_val['error_snippet'] == $curr_error) {
                            $error_compiled[$curr_error]['line_occurence'][] = $err_val['line'];
                        }
                    };
                    $error_compiled[$curr_error]['count'] = count($error_compiled[$curr_error]['line_occurence']);
                }
                else if ($curr_error != $value['error_snippet']) {
                    $curr_error = $value['error_snippet'];
                    $error_compiled[$curr_error] = [
                        "date_time" => $value['date_time'],
                        "error_snippet" => $value['error_snippet'],
                        "line_occurence" => [],
                        "count" => 0,
                    ];
                    foreach ($arr as $err_key => $err_val) {
                        if ($err_val['error_snippet'] == $curr_error) {
                            $error_compiled[$curr_error]['line_occurence'][] = $err_val['line'];
                        }
                    }; 
                    $error_compiled[$curr_error]['count'] = count($error_compiled[$curr_error]['line_occurence']);
                }
        
            }
            continue;
        }

        $this->error_count = $this->errors_count($error_compiled);

        return $error_compiled;
        
    }
    
    public function errors_count($arr) {
        $count = 0;
        foreach ($arr as $item) {
            $count = $count + $item['count'];
        }
        return $count;
    }

}
	