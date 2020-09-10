<?php

class DirectoryListing
{
	var $dir;
	var $hidden;
	var $Common;

	var $items  = array();

	function DirectoryListing( $dir, $cfg )
	{
		$this->dir    = str_replace( array( '../', '..\\' ), '', $dir );
		$this->hidden = $cfg[ 'dontShow' ];

		if( !is_dir( getcwd() . '/' . $this->dir ) )
		{
			die( 'Podany katalog nie istnieje!<br/><a href="javascript:history.go(-1);">wr��</a>' );
		}

		$this->Common = new DirectoryCommon( $this->dir, $cfg[ 'source' ] );
	}

   function readDirectory()
	{
		$items = array();

		if( $dir = @opendir( getcwd() . '/' . $this->dir ) )
		{
			while( ( $file = readdir( $dir ) ) !== false )
			{
				if( substr( $file, 0, 1 ) != '.' and !in_array( $file, $this->hidden ) and ( $file != 'pfb' ) )
				{
					if( is_dir( $this->dir . '/' . $file ) )
					{
						$items[ 'dir' ][] = $file;
					}
					elseif( substr( $file, 0, 5 ) != 'index' )
					{
						$items[ 'file' ][] = $file;
					}
				}
			}
			closedir( $dir );
		}

		if(isset($items[ 'dir' ])) {
		  $this->fillItems( $items[ 'dir' ], 'dir' );
		}
		if(isset($items[ 'file' ])) {
		  $this->fillItems( $items[ 'file' ], 'file' );
		}
		return $this->items;
	}

	function fillItems( $array, $type )
	{
   	if( is_array( $array ) )
   	{
   		natsort( $array );

   		foreach( $array as $item )
   		{
   			$this->items[] = array(
   											'name'  => $item,
   											'size'  => ( $type == 'file' ) ? $this->Common->showSize( $item ) : 'dir',
   											'time'  => filemtime( $this->dir . '/' . $item ),
   											'perms' => $this->Common->getPerms( $item ),
   											'type'  => ( $type == 'dir' ) ? 'dir' : $this->Common->getExtension( $item ),
   											'urle'  => urlencode( $item ),
   											'path'  => $this->dir . $item,
   											'issrc' => $this->Common->isSourceable( $this->dir . $item )
   								 		 );
   		}
		}
	}

	function countItems( $what = '' )
	{
		$num = 0;

		if( $what == 'dir' )
		{
			foreach( $this->items as $item )
			{
				if( $item[ 'type' ] == 'dir' )
				{
					$num++;
				}
			}
		}
		elseif( $what == 'file' )
		{
			foreach( $this->items as $item )
			{
				if( $item[ 'type' ] != 'dir' )
				{
					$num++;
				}
			}
		}
		else
		{
			$num = count( $this->items );
		}

		return $num;
	}
}

?>