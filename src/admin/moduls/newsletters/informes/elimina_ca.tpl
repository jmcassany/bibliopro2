    <div id="contenidor" class="informes">
        <div id="contingut" >
            
            <h2 class="esq">Eliminar butlletí enviat</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>Nom del butlletí</th>
                        <th>Destinataris</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><a href="resum.php?IdCam=|ID|">|NOM|</a> <!--|PREVIEW|--></th>
                        <td>|NUM_SUBSCRITS|</td>
                    </tr>
                </tbody>
            </table>
            <form action="elimina.php" method="post" id="eliminar" style="border-bottom:solid #fff 10px;">
                <input type="hidden" name="accio" value="desar" />
                <input type="hidden" name="idCam" value="|ID|" />
                <p>Estàs segur de voler eliminar definitivament aquest butlletí?</p>
                <div id="botons">
                    <a href="javascript:history.go(-1);" class="boto cancel">Cancel·lar</a>
                    <input type="submit" value="Eliminar" class="boto elimin" />
                </div>
            </form>
            
        </div>
    </div>

                        <!-- BLOCK_BEGIN_PREVIEW_1  -->
                         (preview <a href="mostra.php?IdCam=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=1')">HTML</a>)
                        <!-- BLOCK_END_PREVIEW_1  -->
    
                        <!-- BLOCK_BEGIN_PREVIEW_2  -->
                        (preview <a href="mostra.php?IdCam=|ID|&amp;fmt=1" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=1')">HTML</a> 
                        <a href="mostra.php?id=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=2')">TEXT</a>)
                        <!-- BLOCK_END_PREVIEW_2  -->
    
                        <!-- BLOCK_BEGIN_PREVIEW_3  -->
                        (preview <a href="mostra.php?IdCam=|ID|&amp;fmt=2" onclick="javascript:return launchPreview('mostra.php?IdCam=|ID|&amp;fmt=2')">TEXT</a>)
                        <!-- BLOCK_END_PREVIEW_3  -->

