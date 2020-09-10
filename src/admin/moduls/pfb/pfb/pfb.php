<?php

/****************************************
*                                      *
*        PHP File Browser v3.27        *
*                                      *
*                                      *
*                 crash <crash@os.pl>  *
*                                      *
****************************************/

function pfb ($baseDir, $baseUrl, $permFile = 0600, $permDir = 0700) {
  chdir($baseDir);
  require_once( dirname(__FILE__).'/inc/config.inc.php' );

  require_once( dirname(__FILE__).'/inc/directorylisting.class.php' );
  require_once( dirname(__FILE__).'/inc/directorycommon.class.php' );

  require_once( dirname(__FILE__).'/inc/common.class.php' );
  require_once( dirname(__FILE__).'/lng/' . $cfg[ 'lang' ] . '.php' );

  $cmn = new Common( array( 'days' => $lng[ 'days' ], 'months' => $lng[ 'mont' ] ) );

  //require_once( dirname(__FILE__).'/smarty/Smarty.class.php' );
  require_once( dirname(__FILE__).'/template.php' );

  $_Dir = !empty( $_GET[ 'd' ] ) ? $_GET[ 'd' ] : './';
  $_Act = !empty( $_GET[ 'a' ] ) ? $_GET[ 'a' ] : '';

  $dir = new DirectoryListing( $_Dir, $cfg );
  //$tpl = new Smarty;
  $tpl = new template();

  //$tpl->compile_dir   = dirname(__FILE__).'/cache/';
  //$tpl->template_dir  = dirname(__FILE__).'/tpl/';
  //$tpl->compile_check = true;

  $tpl->assign( array(
  'cfg'        => $cfg,
  'maxUplSize' => (int)ini_get( 'upload_max_filesize' ),
  'act'        => $_Act,
  'd'          => $_Dir,
  'common'     => $cmn,
  'baseDir'    => $baseDir,
  'baseUrl'    => $baseUrl
  ) );

  //$tpl->register_modifier( 'addslash', 'addslashes' );
  //$tpl->register_modifier( 'bname', 'basename' );

  $move    = !empty( $_SESSION[ 'move' ] ) ? $_SESSION[ 'move' ] : time();

  $_SESSION[ 'move' ] = time();

  if( substr( $_Dir, 0, 2 ) != './' or $_Dir == './pfb/' )
  {
    header( 'Location: ' . $_SERVER[ 'PHP_SELF' ] );
  }

  if( ( $file = $dir->Common->isIndexable() ) != false )
  {
    header( 'Location: ' . $file );
  }

  if( !empty( $_Act ))
  {
    if( $_Act == 'upload' and !empty( $_POST[ 'upload' ] ) )
    {
      $file = $_FILES[ 'uploadFile' ];

      if( $file[ 'error' ] == 0 )
      {
        $ext = explode( '.', $file[ 'name'] );
        $ext = strtolower( array_pop( $ext ) );

        $wrong = $cfg['wrong'];

        if( !in_array( $ext, $wrong ) )
        {
          @move_uploaded_file( $file[ 'tmp_name' ], getcwd() . '/' . $_Dir . '/' . $file[ 'name' ] );
          @chmod(getcwd() . '/' . $_Dir . '/' . $file[ 'name' ], $permFile);
        }
      }
    }
    elseif( $_Act == 'paste' and !empty( $_SESSION[ 'cutedFile' ] ) and !empty( $_POST[ 'pasteName' ] ) )
    {
      @rename( getcwd() . '/' . $_SESSION[ 'cutedFile' ], getcwd() . '/' . $_Dir . '/' . basename( $_POST[ 'pasteName' ] ) );
      unset( $_SESSION[ 'cutedFile' ] );
    }
    elseif( $_Act == 'delete' )
    {
      $file = urldecode( $_GET[ 'f' ] );
      $file = getcwd() . '/' . $_Dir . '/' . $file;

      if( !empty( $_GET[ 'f' ] ) and file_exists( $file ) )
      {
        if( is_dir( $file ) )
        {
          $dir->Common->deleteDir( $file );
        }
        else
        {
          @unlink( $file );
        }
      }
    }
    elseif( $_Act == 'cut' )
    {
      $f = urldecode( $_GET[ 'f' ] );

      if( !empty( $f ) and file_exists( getcwd() . '/' . $_Dir . '/' . $f ) )
      {
        $_SESSION[ 'cutedFile' ] = $_Dir . '/' . $f;
      }
    }
    elseif( $_Act == 'mkdir' and !empty( $_POST[ 'dirName'] ) and !empty( $_POST[ 'create' ] ) )
    {
      @mkdir( getcwd() . '/' . $_Dir . '/' . $_POST[ 'dirName' ] );
      @chmod( getcwd() . '/' . $_Dir . '/' . $_POST[ 'dirName' ], $permDir );
    }

    header( 'Location: ' . $_SERVER[ 'PHP_SELF' ] . ( !empty( $_Dir ) ? '?d=' . $_Dir : '' ) );
  }


  $tpl->assign_by_ref( 'lng', $lng );
  $tpl->assign_by_ref( 'dir', $dir );

  //return $tpl->fetch( 'main.htm' );
  return $tpl->fetch( 'main.php' );
}
?>