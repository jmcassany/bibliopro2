<!-- Web by: Can Antaviana SL. www.antaviana.com. 2005 -->
<!-- Antaviana �s una empresa especialitzada en el desenvolupament de projectes web i edici� de continguts digitals. -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ca" lang="ca">
<head>
|METAS|
<link rel="STYLESHEET" type="text/css" href="|CONFIG_NOMCARPETA|/media/css/estils.css" />
</head>

<body>

<!-- *******************************************  CAP�ALERA ************************************** -->
<table id="pagina" border="0" cellpadding="0" cellspacing="0" summary="pagina">
<tr>
  <td colspan="3" style="text-align:center">
  |BANNERSUPERIOR|
  |MENUSUPERIOR|
  </td>
</tr>
<tr>
  <td rowspan="2" id="logo"><img src="|CONFIG_NOMCARPETA|/media/comu/titol_hgroup.gif" alt="HGroup" width="134" height="73" /></td>
  <td colspan="2" style="background-color:#FF9900; vertical-align:top"><img src="|CONFIG_NOMCARPETA|/media/gif/barra_int.gif" width="640" height="50" alt="" usemap="#barra_dalt" /></td>
</tr>
<tr>
  <td colspan="2" id="etsa"><img src="|CONFIG_NOMCARPETA|/media/comu/ico_ruta.gif" width="21" height="21" alt="Ets a" align="absmiddle" /> |SITUACIO|</td>
</tr>
<!-- *******************************************  /CAP�ALERA ************************************* -->



<!-- *******************************************  PART CENTRAL ************************************* -->
  <tr>
    <td id="menu-esquerra">
    |MENUESQUERRA|
    <div id="banner-esquerra">
      |BANNERESQUERRA|
    </div>
    </td>
    <td id="contingut">
      <h3 id="titol">|Titol Grafic|</h3>
      <div id="degradat"><img src="|CONFIG_NOMCARPETA|/media/comu/degradat_text.jpg" width="250" height="14" alt="" /></div>


<?php
$idioma= '|IDIOMA_PAG|';
function text_no_result () {
?>
|no resultats|
<?php
}
$text_resultats = "|resultats|";
$text_total = "|total|";
$text_utilitzant = "|utilitzant|";
$text_anterior = "|anterior|";
$text_seguent = "|seguent|";
@include_once('|CONFIG_PATHBASE|/media/php/cercador.inc');
?>



    |PEU|
    </td>
    <td id="menu-dreta">
    |MENUDRETA|
      <div id="banner-dreta">
      |BANNERDRETA|
    </div>
    </td>
  </tr>
</table>
<!-- *******************************************  /PART CENTRAL ************************************* -->


<map name="barra_dalt">
<area coords="477,1,516,19" alt="Catal�" href="|CONFIG_NOMCARPETA|/index.html" />
<area coords="524,1,568,19" alt="English" href="|CONFIG_NOMCARPETA|/en_index.html" />
<area coords="574,1,637,19" alt="Castellano" href="|CONFIG_NOMCARPETA|/es_index.html" />
</map>

</body>
</html>
