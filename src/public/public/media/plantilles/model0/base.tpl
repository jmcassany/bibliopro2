<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="|IDIOMA_BUTLLETI|" lang="|IDIOMA_BUTLLETI|">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    
    <title>|TITOL_BUTLLETI|</title>
    
    <style type="text/css">
        body { margin: 0 !important; padding: 0 !important; font-family: Arial, Helvetica, Sans-serif !important; font-size: 14px !important; color: #666666 !important; background: #FFF !important; }
        img { display: block !important; }
        #detall ul {
            list-style: none outside none;
            margin: 0 0 1em;
        }
        #detall ul li {
            background: url("|CONFIG_URLMODEL|img/bg_ul_li.png") no-repeat scroll 0 0.167em transparent;
            height: 1%;
            margin: 0 0 0.5em;
            padding: 0 0 0 20px;
        }
        #detall ul li ul {
            margin: 0.75em 0;
        }
        #detall ul li ul li {
            background: url("|CONFIG_URLMODEL|img/bg_ul_li_ul_li.png") no-repeat scroll 0 0.25em transparent;
            margin: 0 0 0.333em;
            padding: 0 0 0 18px;
        }
        #detall ul li ul li ul li {
            background: url("|CONFIG_URLMODEL|img/bg_ul_li_ul_li_ul_li.png") no-repeat scroll 0 0.5em transparent;
            padding: 0 0 0 15px;
        }
        
    </style>  
</head>
<body style="background:#fff; font-family:Arial, Verdana, sans-serif; color:#666666; text-align:center" link="#19667D" vlink="#19667D" id="top">
    <table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; width:571px; margin:0 auto; background:#fff; border:14px solid #fff; border-width:0 14px; text-align:left">
        <!-- Capçalera -->
        <thead>
            <tr style="height: 2.5em">
                <td style="text-align:right">
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
                    <p style="color:#333; margin: 8px 0 6px 20px">
                        <strong>Nº |IDNL|</strong> - |DESCRIPCIO_BUTLLETI| <span style="text-align:right; color:#FFF;"> <a style="ont-size:0.75em; color:#000; float: right; margin-right: 20px; text-decoration:none;" href="|URL_TORNAR|"><< Volver a la portada</a></span>
                    </p>
                </td>
            </tr>
        </thead>
        <!-- /Capçalera -->
        <!-- Contingut -->
        <tbody>
            <tr>
                <td colspan="3" style="padding: 10px 0;">
                    |CONTINGUT|
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
                            <p>
                            &copy; |ANY| ?> BiblioPRO, todos los derechos reservados
                            - <a href="|URL_LEGAL|" style="color:#19667D;text-decoration:none;">Info legal</a>
                            </p>
                            <p><a href="#!URL_BAIXA!"><span>Darse de baja</span></a></p>
                        </td>
                    </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tfoot>
        <!-- /Peu -->
        <!-- /Contingut -->
    </table>

    |MAPA_IMATGE_CAPÇALERA|
</body>
</html>