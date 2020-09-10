<?php

require_once( './inc/config.inc.php' );

$path = !empty( $_GET[ 'src' ] ) ? $_GET[ 'src' ] : null;

if( !is_null( $path ) and file_exists( '../' . $path ) and in_array( $path, $cfg[ 'source' ] ) )
{

   ?>
   <html>
   <head>
      <title>Source :: <?= $path; ?></title>
      <style type="text/css">
         * {
            white-space: nowrap;
         }
      </style>
   </head>
   <body>
   <?php

   highlight_file( '../' . $path );

   ?>
   </body>
   </html>
   <?php

}
else
{
   header( 'Location: ../index.php' );
}

?>