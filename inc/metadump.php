<?php 
	$myvals = get_post_meta(get_the_ID());
	foreach($myvals as $key=>$val){
		echo $key . ' : ' . $val[0] . '<br/>';
	}
?>