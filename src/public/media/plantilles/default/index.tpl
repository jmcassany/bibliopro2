<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_BUTLLETI|" lang="|IDIOMA_BUTLLETI|">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    
    <title>|TITOL_BUTLLETI|</title>
    
    <style type="text/css">
        body { margin: 0 !important; padding: 0 !important; font-family: Arial, Helvetica, Sans-serif !important; font-size: 1em !important; color: #6a6a6a !important; background: #FFF !important; }
        img { display: block !important; }
    </style>  
</head>
<body style="background:#fff; font-family:Arial, Verdana, sans-serif; font-size:100%; color:#333; text-align:center" link="#19667D" vlink="#19667D" id="top">
    <table border="0" cellspacing="4" cellpadding="0" style="border-collapse:collapse; width:571px; margin:0 auto; background:#fff; border:14px solid #fff; border-width:0 14px; text-align:left">
        <!-- Capçalera -->
        <thead>
            <tr style="height: 2.5em">
                <td style="font-size:.75em;">&nbsp;</td>
                <td style="width:19px"></td>
                <td style="font-size:.75em; text-align:right">
                    <a href="|URL_ANTERIORS|" style="width: 300px; text-decoration:none;color:#28537e; background: url('|CONFIG_URLMODEL|img/icon_ed_anteriors.gif') 0 0 no-repeat; padding-left: 20px;"> Ediciones anteriores</a>
                </td>
            </tr>
            <tr>
                <th colspan="3">
                    <h1 style="margin:0">
                        <img |CAPÇALERA| width="571" style="display: block;" usemap="#m_capsalera_bibliopro"  />
                    </h1>
                </th>
            </tr>
            <tr>
                <td colspan="3" style="background:#fcad56">
                    <p style="font-weight:normal; color:#333; font-size:.75em; margin: 8px 0 6px 20px">
                        <strong>Nº |IDNL|</strong> - |DESCRIPCIO_BUTLLETI|
                    </p>
                </td>
            </tr>
        </thead>
        <!-- /Capçalera -->
        <!-- Contingut -->
        <tbody>
            <tr>
                <td colspan="3">
                    <table border="0" cellspacing="0" cellpadding="0" style="width:571px; display:block; border-collapse:collapse;">
                        <tr>
                            <td width="423" valign="top">
                                <table cellspacing="10" cellpadding="0" width="408" style="width: 408px; display:block; overflow:hidden;"> 
                                    <!-- BLOCK_BEGIN_BLOC0 -->
                                    |CONTINGUT|
                                    <!-- BLOCK_END_BLOC0 -->
                                </table>
                            </td>
                            <!-- Lateral -->
                            <td width="148" valign="top" align="center" cellspacing="0" cellpadding="0" border="0" style="background-color: #feead3">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="font-size:.7em; font-weight:bold; width: 130px; list-style:none;text-align: left">
                                            <a style="text-decoration:none;color:#28537e; background:url('|CONFIG_URLMODEL|/img/icon_subscriu.gif') 0 0 no-repeat; padding-left: 20px;" href="|URL_ALTA|">Suscribirse</a>
                                            <br/><br/><a href="#!URL_BAIXA!" style="margin: 8px 2px; padding-left: 20px; background-image: url(|CONFIG_URLMODEL|img/ico-baixa.gif); background-repeat: no-repeat; text-decoration:none; color:#28537e;"><span>Darse de baja</span></a></li>
                                        </td>
                                    </tr>
                                    <tr>
                                        <img src="|CONFIG_URLMODEL|/img/ombra_separalateral_.gif" alt="" border="0" /><br />
                                        <!-- BLOCK_BEGIN_BLOC1 -->
                                            |CONTINGUT|
                                        <!-- BLOCK_END_BLOC1 -->
                                    </tr>
                                </table>
                            </td>
                            <!-- /Lateral -->
                        </tr>
                    </table>
                </td>
            </tr>
            
        </tbody>
         <!-- Peu -->
        <tfoot>
            <tr>
                <td colspan="3">
                    <table cellspacing="0" cellpadding="0" border="0" width="571" align="center" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 11px;color: #333;background-color:#fdc17f">
                    <tr>
                        <td style="padding:10px;text-align:center">
                            <p> &copy; <?php echo date('Y'); ?> BiblioPRO, todos los derechos reservados - <a href="|URL_LEGAL|" style="color:#19667D;text-decoration:none;">Info legal</a>
                            </p>
                            <p><a href="#!URL_BAIXA!"><span>Darse de baja</span></a></p>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            <tr>
        </tfoot>
        <!-- /Peu -->
        <!-- /Contingut -->
    </table>

    <!-- control de lectura e-mail -->
    |LECTURA|
    |MAPA_IMATGE_CAPÇALERA|
</body>
</html>