<?php
/* application/hooks/LogQueryHook.php */
class LogQueryHook {

    function log_queries() {


        $CI =& get_instance();
        $times = $CI->db->query_times;
        $dbs    = array();
        $output = NULL;
        $queries = $CI->db->queries;

        if (count($queries) == 0){
            $output .= "no queries\n";
        }else{
            foreach ($queries as $key=>$query){
                if($query == 'SHOW TABLES FROM `beatsomeone`') continue;
                if(preg_match('/FROM `cb_member`/i',$query)) continue;
                $output .= ($output . '['.$key.']================================================'.PHP_EOL);
                $output .= $query . "\n";
            }
            $took = round(doubleval($times[$key]), 3);
            $output .= "===[took:{$took}]\n\n";
        }


        log_message('debug',$output);

    }
}