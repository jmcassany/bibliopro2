<?php

/*restriccions al pujar imatges*/
$UPLOAD_imgsize = 1000000; // 1MB (0 desactiva)
$UPLOAD_imgtype = array(
	'image/png',
	'image/x-png',
	'image/jpeg',
	'image/gif',
	'image/pjpeg',
	'application/x-shockwave-flash'
);
//tipus mime suportats per les imatges

/*restriccions al pujar fitxers*/
$UPLOAD_filesize = 10000000; // 10MB (0 desactiva)
$UPLOAD_filetype = array(
	'application/pdf',
	'application/x-mspowerpoint',
	'application/msword',
	'application/x-zip-compressed',
	'application/zip',
	'application/x-gzip',
	'application/x-msexcel',
	'application/excel',
	'application/x-excel',
	'application/vnd.ms-excel',
	'application/mspowerpoint',
	'application/powerpoint',
	'application/vnd.ms-powerpoint',
	'application/x-download',
);
//tipus mime suportats pels fitxers

/*restriccions al pujar plantilles*/
$UPLOAD_templatesize = 0; //mida màxima de les plantilles, 0 desactiva
$UPLOAD_templatetype = array('text/html', 'text/plain');
//tipus mime suportats per les plantilles

?>
