<?php
/*
 KIBELLA 1.0
 Copyright 2016 Frank Vanden berghen
 All Right reserved.

 Kibella is not a free software. The Kibella software is NOT licensed under the "Apache License".
 If you are interested in distributing, reselling, modifying, contibuting or in general creating
 any derivative work from Kibella, please contact Frank Vanden Berghen at frank@timi.eu.
 */
namespace kibella; function O3y($O2l,&$l3z) { if (array_search($O2l,$l3z["values"]) === FALSE) { $l3z["values"][]=$O2l; } } function O3z($l40,$l2d,$O40,$O2j,&$l41,&$O41) { $l42=array_keys($l2d); $O42=count($l2d); if ($O2j+1<$O42) $l43=TRUE; else $l43=FALSE; if ($l43) $O43=$l42[$O2j+1]; $O2e=$l2d[$l40]["type"]; $l44=$l2d[$l40]["ifield"]; $O44=$l2d[$l40]["interval"]; if (array_key_exists($l44,$l41) === FALSE) { $l41[$l44]=array("type" => $O2e,"values" => array(),"interval" => $O44); } switch ($O2e) { case ("h"): case ("hd"): case ("t"): foreach ($O40 as $l45) { $O2l=$l45["key"]; if ($O2e == "hd") { $O2l=$O2l/01750; } if ($l43) { $O41[$O2l]=array(); if (array_key_exists($O43,$l45)) { $O45=$l45[$O43][l1c]; O3z($O43,$l2d,$O45,$O2j+1,$l41,$O41[$O2l]); } } else { $O41[]=$O2l; } O3y($O2l,$l41[$l44]); } break; case ("r"): case ("rd"): foreach ($O40 as $O2l => $l45) { if ($l43) { $O41[$O2l]=array(); if (array_key_exists($O43,$l45)) { $O45=$l45[$O43][l1c]; O3z($O43,$l2d,$O45,$O2j+1,$l41,$O41[$O2l]); } } else { $O41[]=$O2l; } O3y($O2l,$l41[$l44]); } break; default : break; } } function l46($O46,$l47) { $O47=array(); $l41=array(); $O41=array(); $l48=json_decode($O46,TRUE); assert(array_key_exists("xaggs",$l47),"The parsed query array contains the attribute 'xaggs'"); $O48=$l47["xaggs"]; $l42=array(); foreach ($O48 as $l49) { assert(array_key_exists("ofield",$l49),"The array with the aggregation info contains the attribute 'ofield'"); assert(array_key_exists("type",$l49),"The array with the aggregation info contains the attribute 'type'"); $l42[]=$l49["ofield"]; if ($l49["type"] == "h" || $l49["type"] == "hd") { assert(array_key_exists("interval",$l49),"The array with the aggregation info contains the attribute 'interval'"); $O44=$l49["interval"]; } else { $O44=NULL; } assert(array_key_exists("ifieldname",$l49),"The array with the aggregation info contains the attribute 'ifieldname'"); $O47[$l49["ofield"]]=array("type" => $l49["type"],"ifield" => $l49["ifieldname"],"interval" => $O44); } if (array_key_exists(l19,$l48)) { $O49=$l48[l19]; $O2j=-1; $l40=$l42[0]; $O40=$O49[$l40][l1c]; O3z($l40,$O47,$O40,$O2j+1,$l41,$O41); } $l4a=count($O41); if (0<$l4a && $l4a<=ACCELERATEMAX) { if (DEBUG) { O29( __FUNCTION__ ,"note","Multi-level filter values\n"); O4a($O41); } return array("Fields and Values" => $l41,"Multilevel Values" => $O41); } else { return FALSE; } } function l4b(&$O4b,$l2e,$O2e,$O44,$O2l,$l4c="") { global $O4c; switch ($O2e) { case ("t"): $O4b.=$l4c."{"."\"query\":{"."\"match\":{".$l2e.":{"."\"query\":\"".$O2l."\","."\"type\":\"phrase\""."}"."}"."}"."}"; break; case ("h"): case ("hd"): if ($O2e == "hd") { $l4d=$O2l*01750; } else { $l4d=$O2l; } $O4b.=$l4c."{"."\"range\":{".$l2e.":{"."\"gte\":".$l4d.","; if ($O2e == "h") { assert(is_numeric($O44),"The histogram interval (bin size) is a number or numeric string"); $O4d=$l4d+$O44; $O4b.="\"lt\":".$O4d; } else { $l3f=max(1,round(substr($O44,0,strlen($O44)-1)))*1; $O3f=substr($O44,strlen($O44)-1); $l4e=date_create(gmstrftime("%Y-%m-%d %H:%M:%S",$l4d/01750),new \datetimezone("UTC")); $O4e=(array) $l4e; date_modify($l4e,"$l3f ".$O4c[$O3f]); $O4e=(array) $l4e; $O4d=date_timestamp_get($l4e); $O4b.="\"lte\":".($O4d*01750-1); } $O4b.="}"."}"."}"; break; case ("r"): case ("rd"): $l4f=O3h($O2l); $l4d=$l4f[0]; $O4d=$l4f[1]; $O4b.=$l4c."{"."\"range\":{".$l2e.":{"."\"gte\":".$l4d.","."\"lt\":".$O4d."}"."}"."}"; break; default : break; } } function O4f($l4g,$O4b) { $O4g=FALSE; if ($O4b != NULL && trim($O4b) !== "") { $O4g=TRUE; $l4h=json_decode($O4b,TRUE); } foreach ($l4g["objects"] as $O4h) { $l4i=$O4h["id"]; $O22=$O4h["tableid"]; $O4i=$O4h["query"]; if ($O4i != NULL) { if ($O4g === TRUE) { $l4j=json_decode($O4i,TRUE); if (array_key_exists("query",$l4j)) { $l4j["query"]=$l4h; } $O4i=json_encode($l4j); } $O4j=l4k($O22,$O4i); $O4k=l4($O4j); } if (DEBUG) O29( __FUNCTION__ ,"note","\t\t*********** FILTER QUERY for object $l4i **************\n\t\t$O4i\n"); } } function l4l($l4g,$O4l) { if (DEBUG) { O29( __FUNCTION__ ,"note","Objects in dashboard to be accelerated:\n"); O4a($l4g); O29( __FUNCTION__ ,"note","Filters to apply:\n"); O4a($O4l); } O4f($l4g,""); $l4m="{"."\"filtered\":{"."\"query\":{"."\"query_string\":{"."\"query\":\"*\","."\"analyze_wildcard\":true"."}"."},"."\"filter\":{"."\"bool\":{"."\"must\":["; $O4m=",{"."\"query\":{"."\"query_string\":{"."\"analyze_wildcard\":true,"."\"query\":\"*\""."}"."}"."}"."],"."\"must_not\":[]"."}"."}"."}"."}"; foreach ($O4l as $l4n => $O4n) { $l4o=array(); foreach ($O4n["Fields and Values"] as $l2e => $O4o) { $O2e=$O4o["type"]; $O44=$O4o["interval"]; $l4o[]=array("field" => $l2e,"type" => $O2e,"interval" => $O44); foreach ($O4o["values"] as $O2l) { $O4b=$l4m; l4b($O4b,$l2e,$O2e,$O44,$O2l); $O4b.=$O4m; O4f($l4g,$O4b); } } $l4p=count($l4o); if ($l4p>1) { l2h($O4n["Multilevel Values"],"kibella\\dashAddMultiLevelFilterAndAccelerateObjects",array($l4g,$l4o,$l4m,$O4m)); } } } function dashaddmultilevelfilterandaccelerateobjects($O2l,$l2l,$l2j,$O2j,$l2k,$O2i) { static $O4p; static $l4q; static $O4q; static $l4r; static $O4r; assert(count($O2i) == 4,"The parameters array has exactly 4 elements"); if ($l2j == 0 && $O2j == 0) { $O4p=$O2i[0]; $l4q=$O2i[1]; $l4r=$O2i[2]; $O4q=array($l4r); $O4r=$O2i[3]; } assert(count($l4q)>$O2j,"The number of elements in the aFieldsInfo array is larger than the current level (numel=".count($l4q)."), level=$O2j)"); $l2e=$l4q[$O2j]["field"]; $O2e=$l4q[$O2j]["type"]; $O44=$l4q[$O2j]["interval"]; if (is_array($O2l)) { $l4s=$l2l; $O4q[]=$O4q[$O2j]; if ($O2j == 0) { $l4c=""; } else { $l4c=","; } l4b($O4q[$O2j+1],$l2e,$O2e,$O44,$l4s,$l4c=$l4c); } else { $l4s=$O2l; $O4b=$O4q[$O2j]; l4b($O4b,$l2e,$O2e,$O44,$l4s,$l4c=","); $O4b.=$O4r; O4f($O4p,$O4b); if ($l2j == $l2k-1) { array_pop($O4q); } } } function O4s($O22,$l4t) { $O4t=l4u($O22)["cache"]; if ($O4t) { if (LOG) { O29( __FUNCTION__ ,"note","$O22 - Accelerating dashboard...\n"); } $O4u=array(); if (array_key_exists("panelsJSON",$l4t)) { $l4v=json_decode($l4t["panelsJSON"],TRUE); foreach ($l4v as $O4v) { if (array_key_exists("id",$O4v)) { $l4w=O4w("select * from ".Ov." where ".Ow." <> '".Og."' and ".lq." = '".$O4v["id"]."'",KIBELLADB,TABLESDIR,$l4x="query",$O24="sqlite"); if (count($l4w)>0) { assert(count($l4w) == 1,"There is only one object that matches the searched ID"); $O4i=$l4w[0][Ox]; $O4x["objects"][]=array("id" => $O4v["id"],"tableid" => $O22,"query" => $O4i); if ($O4i != NULL) { $O4j=l4k($O22,$O4i); $l4y=l4($O4j); $l3=$l4y["responseFile"]; $l47=$l4y["parsedQuery"]; if ($l3 !== FALSE) { $O46=file_get_contents($l3); } $O4l=l46($O46,$l47); if ($O4l !== FALSE) { $O4u[$O4v["id"]]=$O4l; } } } } } if (count($O4u)>0) { l4l($O4x,$O4u); } } } } function dashacceleratealldashboards($O22,$O2=FALSE) { $O4t=l4u($O22)["cache"]; if ($O4t) { $O4y=l4z($O22); if ($O4y !== FALSE) { foreach ($O4y as $O4z) { if ($O2) echo "<pre>Accelerating dashboard ".$O4z[lq]."...</pre>"; ob_flush(); $l4t=json_decode($O4z[lx],TRUE); O4s($O22,$l4t); } } } } function dashacceleratetopqueries($O22,$l24=l3v,$O2=FALSE) { $O4t=l4u($O22)["cache"]; if ($O4t && $l24>0) { $l50=O50($O22); if ($l50 !== FALSE) { $l51=0; foreach ($l50 as $O51) { $l51 += $O51["n"]; $l52=$O51["counter"]; } $O52=0; $l53=$l50[0]["counter"]; foreach ($l50 as $O51) { $O52 += $O51["n"]; if ($O52/$l51>$l24/0144) { $l52=$l53; break; } $l53=$O51["counter"]; } if ($O2) echo "<pre>=> Queries to accelerate should have been run at least $l52 times.</pre>"; $O53=l54($O22,$l52); if ($O53 !== FALSE) { $l2v=0; foreach ($O53 as $l4j) { $l2v ++; $O54=$l4j[lz]; $l55=$l4j[l11]; if ($O2) echo "<pre>Running query $l2v with MD5 $O54 (run $l55 times)</pre>"; $O4i=$l4j[O10]; $O4j=l4k($O22,$O4i); l4($O4j); } } } } }