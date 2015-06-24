<?php

function StartTimer ($what='') {
 global $MYTIMER; $MYTIMER=0; //global variable to store time
 //if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') return; //only show for my IP address

 echo '<p style="border:1px solid black; color: black; background: yellow;">';
 echo "About to run <i>$what</i>. "; flush(); //output this to the browser
 //$MYTIMER = microtime (true); //in PHP5 you need only this line to get the time

 list ($usec, $sec) = explode (' ', microtime());
 $MYTIMER = ((float) $usec + (float) $sec); //set the timer
}
function StopTimer() {
 global $MYTIMER; if (!$MYTIMER) return; //no timer has been started
 list ($usec, $sec) = explode (' ', microtime()); //get the current time
 $MYTIMER = ((float) $usec + (float) $sec) - $MYTIMER; //the time taken in milliseconds
 echo 'Took ' . number_format ($MYTIMER, 4) . ' seconds.</p>'; flush();
}

StartTimer ('database query speed');
if (!$link = mysql_connect('192.168.23.4', 'amarthac_mis', 'KWS2014')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db('amarthac_mis', $link)) {
    echo 'Could not select database';
    exit;
}

$sql    = 'SELECT * FROM tbl_clients WHERE deleted = 0';
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    $var .= $row['client_fullname'];
}

mysql_free_result($result);
StopTimer();
?>