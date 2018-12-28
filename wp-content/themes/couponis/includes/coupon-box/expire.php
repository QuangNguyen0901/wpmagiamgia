<?php
$expire = couponis_get_the_expire_time();
if( !empty( $expire ) ){
	echo couponis_get_expire_badge( $expire );
}
?>