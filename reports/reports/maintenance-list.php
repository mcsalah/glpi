<?php
/*
 
  ----------------------------------------------------------------------
GLPI - Gestionnaire libre de parc informatique
 Copyright (C) 2002 by the INDEPNET Development Team.
 Bazile Lebeau, baaz@indepnet.net - Jean-Mathieu Dol�ans, jmd@indepnet.net
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------
 Based on:
IRMA, Information Resource-Management and Administration
Christian Bauer, turin@incubus.de 

 ----------------------------------------------------------------------
 LICENSE

This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ----------------------------------------------------------------------
 Original Author of file:
 Purpose of file:
 ----------------------------------------------------------------------
*/
 

include ("_relpos.php");
include ($phproot . "/glpi/includes.php");

checkAuthentication("normal");
commonHeader("Reports",$_SERVER["PHP_SELF"]);

$item_db_name[0] = "glpi_computers";
$item_db_name[1] = "glpi_printers";
$item_db_name[2] = "glpi_monitors";
$item_db_name[3] = "glpi_networking";

$db = new DB;


# Titre
echo "<big><b><strong>".$lang["reports"][4]."</strong></b></big><br><br>";

# Construction  la requete, et appel de la fonction affichant les valeurs.
if($_POST["item_type"] != 'tous')
{

		$query = "select * from ".$_POST["item_type"]."  where maintenance = 1 ";
		
		if($_POST["annee_achat"] != 'toutes')
		{
			$query.= "  and YEAR(achat_date) = '".$_POST["annee_achat"]."' ";
		}
		$query.= " order by ".$_POST["tri_par"]." asc";
		report_perso($_POST["item_type"],$query);
}
else
{
	$query=array();
		for($i=0;$i<4;$i++)
		{
			$query[$i] = "select * from ".$item_db_name[$i]." where maintenance = 1";
		
			if($_POST["annee_achat"] != 'toutes')
			{
				$query[$i].= " and YEAR(achat_date) = '".$_POST["annee_achat"]."'";
			}
			$query[$i].=" order by ".$_POST["tri_par"]." asc";
		

			report_perso($item_db_name[$i],$query[$i]);
		 }		
}
commonFooter();
?>
