<?php
	require_once ('../selconfig.php');
	include_once ($CONFIG_NLADMINPATHBASE . '/houdini_cap.inc');
?>	
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="2" style="padding:15px 30px 0 30px;">
						<h2>Gestionar contingut</h2>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding:15px 30px 15px 30px;">
						<table border="0" cellpadding="0" cellspacing="5" width="100%">
						<tr>
							<td class="items_butlleti">
								<a href="noticies_newsletter/list.php"><img src="../../../../public/media/comu/admin/editora_noticies.jpg" alt="Notícies Butlletí" border="0" style="vertical-align:middle;" /> <?php echo $messages["editoranoticies"]; ?></a>
							</td>
							<td class="items_butlleti">
								<a href="banners_newsletter/list.php"><img src="../../../../public/media/comu/admin/editora_banners.jpg" alt="Banners Butlletí" border="0" style="vertical-align:middle;" /> <?php echo $messages["editorabanners"]; ?></a>
							</td>
							<td class="items_butlleti">
								<a href="caixes_newsletter/list.php"><img src="../../../../public/media/comu/admin/editora_caixes.jpg" alt="Caixes Butlletí" border="0" style="vertical-align:middle;" /> Editora de caixes</a>
							</td>
						</tr>
						<?php if ($_SESSION['access']['level'] == 5) { ?>
						<tr>
							<td class="items_butlleti">
								<a href="origens_rss_noticies/index.php"><img src="../../../../public/media/comu/admin/editora_rss.jpg" alt="Origens RSS" border="0" style="vertical-align:middle;" /> Origens RSS</a>
							</td>
							<td class="items_butlleti">
								<a href="caps_newsletter/list.php"><img src="../../../../public/media/comu/admin/editora_capsalera.jpg" alt="Capçalers Butlletí" border="0" style="vertical-align:middle;" /> Editora de capçaleres</a>
							</td>
							<td class="items_butlleti">
								&nbsp;
							</td>
						</tr>
						<?php } else { ?>
						<tr>
							<td class="items_butlleti">
								<a href="caps_newsletter/list.php"><img src="../../../../public/media/comu/admin/editora_capsalera.jpg" alt="Capçalers Butlletí" border="0" style="vertical-align:middle;" /> Editora de capçaleres</a>
							</td>
							<td class="items_butlleti">
								&nbsp;
							</td>
							<td class="items_butlleti">
								&nbsp;
							</td>
						</tr>
						<?php } ?>
						</table>
					</td>
				</tr>
			</table>
<?php 
    include_once ($CONFIG_NLADMINPATHBASE . '/houdini_peu.inc');
?>