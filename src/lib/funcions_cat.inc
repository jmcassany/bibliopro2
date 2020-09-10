<?php

if (!is_callable('cat2items')) {
	function cat2items($carpetaid, $id = null, $prefix = '') {

		$entrades = array();
		if ($id != null) {
			$result = db_query('select ID, NOM from DIN_CATEGORIES where PARE = '.$id.' AND DINAMICA = '.$carpetaid);
		}
		else {
			$result = db_query('select ID, NOM from DIN_CATEGORIES where PARE is null AND DINAMICA = '.$carpetaid);
		}
		while($row = db_fetch_array($result)) {
			$entrades[] = $row['ID'].'_'.$prefix.$row['NOM'];
			$fills = cat2items($carpetaid, $row['ID'], $prefix.$row['NOM'].' > ');
			$entrades = array_merge($entrades, $fills);
		}
		return ($entrades);
	}
}


/*****************************************************
 * FUNCIONS PER A OBTENIR ARRAY DE CATEGORIES
*****************************************************/

function getArrayCategories($carpetaid, $args='' )
{
	$carpetaid = (int) $carpetaid;

	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);

	$defaults = array('levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'camps' => 'ID, NOM, DESCRIPCIO, IMATGE, PARE' , 'category_id' => 0);
	$r = array_merge($defaults, $r);

	$r['category_id'] = (int) $r['category_id'];
	$output = array();

	if ($r['category_id'] != 0)
	{
		$result = db_query('select '.$r['camps'].' from DIN_CATEGORIES where PARE = '.$r['category_id'].' AND DINAMICA = '.$carpetaid.' ORDER BY '.$r['category_orderby'].' '.$r['category_order']);
	}
	else
	{
		$result = db_query('select '.$r['camps'].' from DIN_CATEGORIES where PARE is null AND DINAMICA = '.$carpetaid.' ORDER BY '.$r['category_orderby'].' '.$r['category_order']);
	}

	while(($row = db_fetch_array($result)) && $r['levels'] > 0 )
	{
		$r_next = $r;
		$r_next['levels'] --;
		$r_next['category_id'] = $row['ID'];
		$fills = getArrayCategories($carpetaid, $r_next);
		$row['CHILDS'] = $fills;
		$output[] = $row;
	}

	return $output;
}

/*****************************************************
 * FUNCIONS PER A LLISTATS DE CATEGORIES
*****************************************************/

function getLlistaCategories($carpetaid, $args = '')
{
	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);


	$defaults = array('parent_category' => 0, 'levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'link_to' => 'index.php', 'link_params' => '', 'link_param_name_category' => 'CATEGORY2', 'display_childs' => false, 'display_childs_from_category' => 0, 'category_title_before' => '', 'category_title_after' => '');
	$r = array_merge($defaults, $r);

	$output = '';

	$array_categories = getArrayCategories($carpetaid, "category_id=".$r['parent_category']."&amp;levels=".$r['levels']."&amp;category_orderby=".$r['category_orderby']."&amp;category_order=".$r['category_order']);


	foreach($array_categories as $categoria)
	{
		$url_params = ($r['link_params'] != '') ? $r['link_params']."&amp;".$r['link_param_name_category']."=" : $r['link_param_name_category']."=";
		$subcategories = '';

		if( ( cat_es_Ascendent($r['display_childs_from_category'], $categoria['ID']) || $r['display_childs_from_category'] == $categoria['ID'] || $r['display_childs'] == true || $r['levels'] > 1 )  )
		{
			$r_next = $r;
			$r_next['levels'] --;
			$r_next['parent_category'] = $categoria['ID'];

			$subcategories = recorrer_LlistaSubcategories($carpetaid, $r_next);
		}
		$output .= '<li><a href="'.$r['link_to'].'?'.$url_params.$categoria['ID'].'">'.$r['category_title_before'].$categoria['NOM'].$r['category_title_after'].'</a>'.$subcategories.'</li>';
	}
	return $output;
}

function recorrer_LlistaSubcategories($carpetaid, $args = '')
{

	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);

	$defaults = array('parent_category' => 0, 'levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'link_to' => 'index.php', 'link_params' => '', 'link_param_name_category' => 'CATEGORY2', 'display_childs' => false, 'display_childs_from_category' => 0, 'category_title_before' => '', 'category_title_after' => '');
	$r = array_merge($defaults, $r);

	$output = '';


	$array_categories = getArrayCategories($carpetaid, "category_id=".$r['parent_category']."&amp;levels=".$r['levels']."&amp;category_orderby=".$r['category_orderby']."&amp;category_order=".$r['category_order']);


	foreach($array_categories as $categoria)
	{
		$url_params = ($r['link_params'] != '') ? $r['link_params']."&amp;".$r['link_param_name_category']."=" : $r['link_param_name_category']."=";
		$subcategories = '';

		if( ( cat_es_Ascendent($r['display_childs_from_category'], $categoria['ID']) || $r['display_childs_from_category'] == $categoria['ID'] || $r['display_childs'] == true || $r['levels'] > 1 )  )
		{
			$r_next = $r;
			$r_next['levels'] --;
			$r_next['parent_category'] = $categoria['ID'];

			$subcategories = recorrer_LlistaSubcategories($carpetaid, $r_next);
		}

		$output .= '<li><a href="'.$r['link_to'].'?'.$url_params.$categoria['ID'].'">'.$r['category_title_before'].$categoria['NOM'].$r['category_title_after'].'</a>'.$subcategories.'</li>';
	}

	if($output != '')
	{
		$output = '<ul>'.$output.'</ul>';
	}
	return $output;
}

function cat_es_Descendent($fill, $pare)
{
	$pare = (int) $pare;
	$result = db_query("SELECT PARE FROM DIN_CATEGORIES WHERE ID=" . (int) $fill);
	if($result && db_num_rows($result)>0 )
	{
		$row = db_fetch_array($result);
		if($row['PARE'] == $pare)
		{
			return true;
		}
		else if($row['PARE'] != null)
		{
			if(cat_es_Descendent($row['PARE'], $pare))
			{
				return true;
			}
		}
	}
	return false;
}
function cat_es_Ascendent($fill, $pare)
{
	$fill = (int) $fill;

	$result = db_query("SELECT ID FROM DIN_CATEGORIES WHERE PARE=" . (int) $pare);
	if($result && db_num_rows($result)>0 )
	{
		while($row = db_fetch_array($result))
		{
			if($row['ID'] == $fill)
			{

				return true;
			}
			if(cat_es_Ascendent($fill, $row['ID']))
			{
				return true;
			}
		}
	}
	return false;
}

function cat_te_Descendents($pare)
{
	$result = db_query("SELECT ID FROM DIN_CATEGORIES WHERE PARE=" . (int) $pare);
	if($result && db_num_rows($result)>0 )
	{
		return true;
	}
	return false;
}

function cat_num_Descendents($carpetaid, $args='')
{

	$carpetaid = (int) $carpetaid;

	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);

	$defaults = array('levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'category_id' => 0);
	$r = array_merge($defaults, $r);

	$r['category_id'] = (int) $r['category_id'];

	$output = 0;

	if ($r['category_id'] != 0)
	{
		$result = db_query('select ID from DIN_CATEGORIES where PARE = '.$r['category_id'].' AND DINAMICA = '.$carpetaid.' ORDER BY '.$r['category_orderby'].' '.$r['category_order']);
	}
	else
	{
		$result = db_query('select ID from DIN_CATEGORIES where PARE is null AND DINAMICA = '.$carpetaid.' ORDER BY '.$r['category_orderby'].' '.$r['category_order']);
	}
	$output += db_num_rows($result);
	while(($row = db_fetch_array($result)) && $r['levels'] > 0 )
	{
		$r_next = $r;
		$r_next['levels'] --;
		$r_next['category_id'] = $row['ID'];
		$n_fills = cat_num_Descendents($carpetaid, $r_next);
		$output += $n_fills;
	}

	return $output;
}

function cat_num_Items($carpetaid, $args='')
{

	$carpetaid = (int) $carpetaid;

	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);

	$defaults = array('levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'category_id' => 0);
	$r = array_merge($defaults, $r);

	$r['category_id'] = (int) $r['category_id'];
	$output = 0;

	$array_ids_fills_categoria = cat_get_IdDescendents($carpetaid, $r);
	$sql_categories_filles = implode(" OR CATEGORY2=", $array_ids_fills_categoria);
	if($sql_categories_filles != '')
	{
		$sql_categories_filles = " OR CATEGORY2=".$sql_categories_filles;
	}
	$filtre_w ="(STATUS='1') and ((VISIBILITY='1') or (VISIBILITY='2' and START_TIME < NOW() and NOW() < END_TIME)) AND ( CATEGORY2 = ".$r['category_id']." $sql_categories_filles )";

	$TAULA=staticFolderTableName($carpetaid);
	$result = db_query("SELECT COUNT(*) AS N_ITEMS FROM $TAULA WHERE $filtre_w");
	if($result)
	{
		$row = db_fetch_array($result);
		return $row['N_ITEMS'];
	}
  	return $output;
}

function cat_get_IdDescendents($carpetaid, $args ='')
{
	$carpetaid = (int) $carpetaid;
	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);

	$defaults = array('levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'category_id' => 0);
	$r = array_merge($defaults, $r);

	$r['category_id'] = (int) $r['category_id'];

	$output = array();

	if ($r['category_id'] != 0)
	{
		$result = db_query('select ID from DIN_CATEGORIES where PARE = '.$r['category_id'].' AND DINAMICA = '.$carpetaid.' ORDER BY '.$r['category_orderby'].' '.$r['category_order']);
	}
	else
	{
		$result = db_query('select ID from DIN_CATEGORIES where PARE is null AND DINAMICA = '.$carpetaid.' ORDER BY '.$r['category_orderby'].' '.$r['category_order']);
	}

	while(($row = db_fetch_array($result)) && $r['levels'] > 0 )
	{
		$r_next = $r;
		$r_next['levels'] --;
		$r_next['category_id'] = $row['ID'];
		$fills = cat_get_IdDescendents($carpetaid, $r_next);
		$output[] = $row['ID'];
		$output = array_merge($output, $fills);
	}

	return $output;
}

function cat_get_PrimerPare($idcategoria)
{
	$result = db_query("SELECT ID, PARE FROM DIN_CATEGORIES WHERE ID=" . (int) $idcategoria);
	if($result && db_num_rows($result)>0 )
	{
		$row = db_fetch_array($result);

		if($row['PARE'] == null)
		{
			return $row['ID'];
		}
		else
		{
			$cat = cat_get_PrimerPare($row['PARE']);
			if( $cat != $idcategoria)
			{
				return $cat;
			}
		}
	}
	return $idcategoria;
}

/*****************************************************
 * FUNCIONS PER A OPTIONS DELS INPUTS SELECT
*****************************************************/

function getSelectOptionsCategories($carpetaid, $args = '')
{
	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);


	$defaults = array('parent_category' => 0, 'levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'prefix_sub_categoria' => ' >', 'value_prefix' =>'', 'category_title_before' => '', 'category_title_after' => '', 'default_option_active'=>true, 'default_option_text' =>'Tria una categoria', 'default_option_value' =>'0', 'selected_category' => '0', 'inherit_parent_category' => true );
	$r = array_merge($defaults, $r);


	$output = '';

	$array_categories = getArrayCategories($carpetaid, "category_id=".$r['parent_category']."&amp;levels=".$r['levels']."&amp;category_orderby=".$r['category_orderby']."&amp;category_order=".$r['category_order']);


	foreach($array_categories as $categoria)
	{

		$subcategories = '';
		if( $r['levels'] > 1  )
		{
			$r_next = $r;
			$r_next['levels'] --;
			$r_next['parent_category'] = $categoria['ID'];
			if($r['inherit_parent_category'])
			{
				$r_next['parent_category_name'] = $categoria['NOM'];
			}

			$subcategories = recorrer_OpcionsSubcategories($carpetaid, $r_next);
		}
		$selected = ($r['selected_category'] == $categoria['ID']) ? ' selected="selected" ' : '';
		$output .= '<option value="'.$categoria['ID'].'" '.$selected.'>'.$r['category_title_before'].$categoria['NOM'].$r['category_title_after'].'</option>'.$subcategories;
	}
	if($r['default_option_active'])
	{
		$selected = ($r['selected_category'] == $r['parent_category']) ? ' selected="selected" ' : '';
		$output = '<option selected="selected" value="'.$r['default_option_value'].'">'.$r['default_option_text'].'</option>'.$output;
	}
	return $output;
}


function recorrer_OpcionsSubcategories($carpetaid, $args = '')
{

	if ( is_array($args) )
		$r = &$args;
	else
		parse_str($args, $r);


	$defaults = array('parent_category' => 0, 'levels' => 99999, 'category_orderby' => 'NOM', 'category_order' => 'ASC', 'prefix_sub_categoria' => ' > ', 'value_prefix' =>'', 'category_title_before' => '', 'category_title_after' => '', 'default_option_active'=>true, 'default_option_text' =>'Tria una categoria', 'default_option_value' =>'0', 'selected_category' => '0', 'parent_category_name' => '', 'inherit_parent_category' => true );
	$r = array_merge($defaults, $r);

	$output = '';

	$array_categories = getArrayCategories($carpetaid, "category_id=".$r['parent_category']."&amp;levels=".$r['levels']."&amp;category_orderby=".$r['category_orderby']."&amp;category_order=".$r['category_order']);


	foreach($array_categories as $categoria)
	{
		$subcategories = '';
		if( $r['levels'] > 1  )
		{
			$r_next = $r;
			$r_next['levels'] --;
			$r_next['parent_category'] = $categoria['ID'];
			if($r['inherit_parent_category'])
			{
				$r_next['parent_category_name'] .= $r['prefix_sub_categoria'].$categoria['NOM'];
			}
			$subcategories = recorrer_OpcionsSubcategories($carpetaid, $r_next);
		}
		$selected = ($r['selected_category'] == $categoria['ID']) ? ' selected="selected" ' : '';
		$output .= '<option value="'.$categoria['ID'].'" '.$selected.'>'.$r['category_title_before'].$r['parent_category_name'].$r['prefix_sub_categoria'].$categoria['NOM'].$r['category_title_after'].'</option>'.$subcategories;
	}

	return $output;
}

/*****************************************************
 * FUNCIONS PER A OBTENIR INFORMACIÓ D'UNA CATEGORIA
*****************************************************/

function getInfoCategoria($idcategoria)
{
	$info_categoria = array();
	$result = db_query('select ID, NOM, DESCRIPCIO, IMATGE, PARE from DIN_CATEGORIES where ID = '. (int) $idcategoria);
	if($result)
	{
		$info_categoria = db_fetch_array($result);
	}
  	return $info_categoria;
}

function getNomCategoria($idcategoria)
{
	$nom = '';
	$info_categoria = getInfoCategoria($idcategoria);
	$nom = $info_categoria['NOM'];
	return $nom;
}

function getPareCategoria($idcategoria)
{
	$info_categoria = getInfoCategoria($idcategoria);
	if($info_categoria['PARE'] != null)
	{
		return $info_categoria['PARE'];
	}
	return 0;
}

function getDescripcioCategoria($idcategoria)
{
	$nom = '';
	$info_categoria = getInfoCategoria($idcategoria);
	$nom = $info_categoria['DESCRIPCIO'];
	return $nom;
}


?>
