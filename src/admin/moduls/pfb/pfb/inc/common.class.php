<?php

class Common
{
   var $start  = 0;
   var $config = array();
   
   function Common( $cfg )
   {
      $this->config = $cfg;
      $this->start  = $this->getUtime();
   }
   
	function getUtime()
	{
		$time = explode( ' ', microtime() );
		$usec = (double)$time[ 0 ];
		$sec  = (double)$time[ 1 ];
	
		return $sec + $usec;
	}
	
	function getTime( $round = 4 )
	{
   	return round( $this->getUtime() - $this->start, $round );
	}

	function showDate()
	{
  		return $this->config[ 'days' ][ date( 'w' ) ] . ', ' . date( 'j' ) . ' ' . $this->config[ 'months' ][ date( 'n' ) - 1 ] . ' ' . date( 'Y, G:i' );
	}
}

?>