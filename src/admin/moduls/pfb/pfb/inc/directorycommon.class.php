<?php

class DirectoryCommon
{
	var $dir;
	var $source;

	var $items  = array();

	function DirectoryCommon( $dir, $source )
	{
		$this->dir    = $dir;
		$this->source = $source;

	}

	function isIndexable()
	{
   	$exts = array( 'htm', 'html', 'php', 'phtml', 'php5' );

		if( $this->dir != './' )
		{
			foreach( $exts as $ext )
			{
				if( file_exists( $file = $this->dir . 'index.' . $ext ) )
				{
					return $file;
				}
			}
		}
		return false;
	}

   function splitString( $text, $num = 1 )
   {
      $ret = array();
      $len = strlen( $text ) / $num;

      for( $i = 0; $i < $len; $i++ )
      {
         $ret[] = substr( $text, $num * $i, $num );
      }

      return $ret;
   }

	function isSourceable( $file )
	{
   	//return in_array( $file, $this->source );
   	$info = pathinfo($file);
   	if (!isset($info['extension'])) {
   	  return false;
   	}
   	return in_array( $info['extension'], $this->source );
	}

	function showSize( $file )
	{
      $sizes  = array( 'B', 'kB', 'MB', 'GB', 'TB' );

		$size = filesize( $this->dir . '/' . $file );
		$pos  = 0;

		while( $size >= 1024 )
		{
      	$size /= 1024;
			$pos++;
		}

		return round( $size, 2 ) . ' ' . $sizes[ $pos ];
	}

	function getExtension( $fileName )
	{
		$ext = strtolower( pathinfo( $fileName, PATHINFO_EXTENSION ) );
  	return file_exists( dirname(__FILE__).'/../ico/' . $ext . '.gif' ) ? $ext : 'blank';
	}

	function getURL( $item )
	{
		return ( $item[ 'type' ] == 'dir' ) ? '?d=' . $this->dir . $item[ 'name' ] . '/' : $this->dir . $item[ 'name' ];
	}

	function getPerms( $file )
	{
      $list = array( '---', '--x', '-w-', '-wx', 'r--', 'r-x', 'rw-', 'rwx' );
   	$ret  = array();

		$perms = substr( sprintf( '%o', fileperms( $this->dir . '/' . $file ) ), -3 );

      if( function_exists( 'str_split' ) )
      {
   		foreach( str_split( $perms, 1 ) as $perm )
	   	{
   	   	$ret[] = $list[ $perm ];
   		}
      }
      else
      {
   		foreach( $this->splitString( $perms, 1 ) as $perm )
	   	{
   	   	$ret[] = $list[ $perm ];
   		}
      }

		return $ret;
	}

   function deleteDir( $dir )
   {
      if( substr( $dir, -1 ) != '/' )
      {
         $dir = $dir . '/';
      }

      if( $dh = @opendir( $dir ) )
      {
         while( $file = readdir( $dh ) )
         {
            if( ( $file != '.' ) and ( $file != '..' ) )
            {
               if( is_dir( $dir . $file ) )
               {
                  if( $this->deleteDir( $dir . $file . '/' ) == false )
                  {
                     return false;
                  }
               }
               else
               {
                  if( @unlink( $dir . $file ) == false )
                  {
                     return false;
                  }
               }
            }
         }
         closedir( $dh );

         if( @rmdir( $dir ) )
         {
            return true;
         }
      }
      return false;
   }

	function dirUp()
	{
		return '?d=' . implode( '/', array_slice( explode( '/', $this->dir ), 0, -2 ) ) . '/';
	}
}

?>