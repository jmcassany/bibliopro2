
<ul class="menu menu_vertical nav clearfix menu_normal">
<li class="<?php
          if("/sobre_empro/index.html"== $rutaplana or "/sobre_empro/index.html" == $_SERVER["REQUEST_URI"]){
            ?>current<?php
            }
        ?>"><a href="/sobre_empro/index.html">Herramienta EMPRO</a></li>
<li class="<?php
          if("/sobre_empro/procedimiento-evaluacion.html"== $rutaplana or "/sobre_empro/procedimiento-evaluacion.html" == $_SERVER["REQUEST_URI"]){
            ?>current<?php
            }
        ?>"><a href="/sobre_empro/procedimiento-evaluacion.html">Procedimiento de evaluación</a></li>
<li class="<?php
          if("/sobre_empro/evaluadores.html"== $rutaplana or "/sobre_empro/evaluadores.html" == $_SERVER["REQUEST_URI"]){
            ?>current<?php
            }
        ?>"><a href="/sobre_empro/evaluadores.html">Evaluadores</a></li>
<li class="<?php
        if (isset($directori) && in_array("11", $directoris)) {
        ?>current<?php
        }
        ?>"><a href="http://www.bibliopro.org/sobre_empro/taller-empro-2017.html">Taller EMPRO</a></li>
<li class="<?php
          if("/sobre_empro/webinar-empro-2016.html"== $rutaplana or "/sobre_empro/webinar-empro-2016.html" == $_SERVER["REQUEST_URI"]){
            ?>current<?php
            }
        ?>"><a href="/sobre_empro/webinar-empro-2016.html">Webinar sobre EMPRO</a></li>

</ul>
