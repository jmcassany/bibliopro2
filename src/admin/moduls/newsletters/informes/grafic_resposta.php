<?php
include_once '../selconfig.php';
require_once($CFG_CAMPANYES['PATH_CHARTS'].'libchart.php');

header("Content-type: image/png");

$errenv = intval($_GET['a']);
$llegits = intval($_GET['b']);
$unsubs = intval($_GET['c']);
$norespo = intval($_GET['d']);
$total = $errenv + $llegits + $unsubs + $norespo;

$width = intval($_GET['width']);
if ($width < 100) $width = 400;
$height = intval($_GET['height']);
if ($height < 100) $height = 250;

$chart = new PieChart($width,$height);
$chart->addPoint(new Point("Sense resposta ($norespo)", $norespo));
$chart->addPoint(new Point("Error enviament ($errenv)", $errenv));
$chart->addPoint(new Point("Llegits ($llegits)", $llegits));
$chart->addPoint(new Point("Unsubscribes ($unsubs)", $unsubs));
//$chart->setTitle("Situació actual dels $total correus enviats");
$chart->setTitle("");
$chart->render();

?>