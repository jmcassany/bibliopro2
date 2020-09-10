<?php
include_once '../selconfig.php';
require_once('generar_butlleti.php');

$contingut = '';
if(isset($_GET['IdCam'])){
    $idCam = $_GET['IdCam'];
    $queryButlleti = db_query('SELECT * FROM ' . TAULA_NEWSLETTERS . ' WHERE IdCam = ' . $idCam);
    $dadesButlleti = db_fetch_array($queryButlleti);
    if(file_exists($CONFIG_PATHBASE . '/public/butlletins/butlleti' . $dadesButlleti['ID'] . '.html')){
        if(generarButlleti($idCam)){
            $contingut = file_get_contents($CONFIG_PATHBASE . '/public/butlletins/butlleti' . $dadesButlleti['ID'] . '.html');
        } else {
            htmlNewsletterError('No s\'ha pogut generar el butlletí');
        }
    }
    echo $contingut;
} else {
    htmlNewsletterError('L\'identificador no es correspon a cap butlletí');
}

?>