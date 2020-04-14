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
                log_message('debug','['.$key.']'.PHP_EOL.$query .'\n');
            }
        }

    }
}