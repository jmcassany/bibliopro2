
<ul class="menu menu_horitzontal nav clearfix menu_normal">
<li class="<?php
          if("/index.html"== $rutaplana or "/index.html" == $_SERVER["REQUEST_URI"]){
            ?>current<?php
            }
        ?>"><a href="/index.html">Inicio</a></li>
<li class="<?php
        if (isset($directori) && in_array("2", $directoris)) {
        ?>current<?php
        }
        ?>"><a href="/que-es/index.html">Qué es BiblioPRO</a></li>
<li class="<?php
        if (isset($directori) && in_array("4", $directoris)) {
        ?>current<?php
        }
        ?>"><a href="/cuestionarios">Cuestionarios PRO y CVRS</a></li>
<li class="<?php
        if (isset($directori) && in_array("3", $directoris)) {
        ?>current<?php
        }
        ?>"><a href="/servicios/index.html">Servicios</a></li>

</ul>
