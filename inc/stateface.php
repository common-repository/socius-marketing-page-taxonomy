<?php 
function smct_determine_stateface($taxonomyName,$optional_class = null) {

	$font_class = 'stateface';

	switch ($taxonomyName)
	{
	    case 'alabama':
	        $stateface = 'B'; break;
	    case 'alaska':
	        $stateface = 'A'; break;
	    case 'arizona':
	        $stateface = 'D'; break;
	    case 'arkansas':
	        $stateface = 'C'; break;
	    case 'california':
	        $stateface = 'E'; break;
	    case 'colorado':
	        $stateface = 'F'; break;
	    case 'connecticut':
	        $stateface = 'G'; break;
	    case 'delaware':
	        $stateface = 'H'; break;
	    case 'florida':
	        $stateface = 'I'; break;
	    case 'georgia':
	    	$stateface = 'J'; break;
	    case 'hawaii':
	        $stateface = 'K'; break;
	    case 'idaho':
	        $stateface = 'M'; break;
	    case 'illinois':
	        $stateface = 'N'; break;
	    case 'indiana':
	        $stateface = 'O'; break;
	    case 'iowa':
	        $stateface = 'L'; break;
	    case 'kansas':
	        $stateface = 'P'; break;
	    case 'kentucky':
	        $stateface = 'Q'; break;
	    case 'louisiana':
	        $stateface = 'R'; break;
	    case 'maine':
	        $stateface = 'U'; break;
	    case 'maryland':
	        $stateface = 'T'; break;
	    case 'massachusetts':
	        $stateface = 'S'; break;
	    case 'michigan':
	        $stateface = 'V'; break;
	    case 'minnesota':
	        $stateface = 'W'; break;
	    case 'mississippi':
	        $stateface = 'Y'; break;
	    case 'missouri':
	        $stateface = 'X'; break;
	    case 'montana':
	        $stateface = 'Z'; break;
	    case 'nebraska':
	        $stateface = 'c'; break;
	    case 'nevada':
	        $stateface = 'g'; break;
	    case 'new-hampshire':
	        $stateface = 'd'; break;
	    case 'new-jersey':
	        $stateface = 'e'; break;
	    case 'new-mexico':
	        $stateface = 'f'; break;
	    case 'new-york':
	        $stateface = 'h'; break;
	    case 'north-carolina':
	        $stateface = 'a'; break;
	    case 'north-dakota':
	        $stateface = 'b'; break;
	    case 'ohio':
	        $stateface = 'i'; break;
	    case 'oklahoma':
	        $stateface = 'j'; break;
	    case 'oregon':
	        $stateface = 'k'; break;
	    case 'pennsylvania':
	        $stateface = 'l'; break;
	    case 'rhode-island':
	        $stateface = 'm'; break;
	    case 'south-carolina':
	        $stateface = 'n'; break;
	    case 'south-dakota':
	        $stateface = 'o'; break;
	    case 'tennessee':
	        $stateface = 'p'; break;
	    case 'texas':
	        $stateface = 'q'; break;
	    case 'utah':
	        $stateface = 'r'; break;
	    case 'vermont':
	        $stateface = 't'; break;
	    case 'virginia':
	        $stateface = 's'; break;
	    case 'washington':
	        $stateface = 'u'; break;
	    case 'washington-dc':
	        $stateface = 'y'; break;
	    case 'west-virginia':
	        $stateface = 'w'; break;
	    case 'wisconsin':
	        $stateface = 'v'; break;
	    case 'wyoming':
	        $stateface = 'x'; break;
	    case 'united-states':
			$stateface = 'z'; break;
		default :
			$stateface = '';
	}

	$internationl_locations = array('africa','asia','australia','caribbean','canada','central-america','europe','mexico','middle-east','south-america');
	if($stateface == '') {
		$stateface = '';
		$font_class = 'worldface icon-'.$taxonomyName;
	}

	/* 06/12/18 Removed deprecated is_taxonomy()
	if(is_archive() && is_taxonomy( 'smct_areas' ) ) {
		$optional_class = ' cities';
	} */

	if(is_archive() && taxonomy_exists( 'smct_areas' ) ) {
		$optional_class = ' cities';
	}

	$stateface_wrap = '<span class="' . $font_class . $optional_class . '">' . $stateface . '</span>';

	return $stateface_wrap;
}