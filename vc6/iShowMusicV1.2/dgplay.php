<?php
require("global.php");
$subtitle='µã¸èÐÅÏ¢';

$diange = file("$datadir/diange.php");
$count= count($diange);
for ($i=0;$i<$count;$i++) {
		$detail = explode("|", $diange[$i]);
		if($time==$detail[4]){ 
	      $user=$detail[0];
	      $user2=$detail[1];
		  $songname=$detail[2];
		  $songid=$detail[3];
	      $say=$detail[5];
		  $diangetime=date("Y-m-d H:i",$detail[4]);
		}
}

require("header.php");
include_once PrintEot('dgplay');
footer();
?>
