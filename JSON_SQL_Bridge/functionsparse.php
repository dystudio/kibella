<?php
/*
KIBELLA 1.0
Copyright 2016 Frank Vanden berghen
All Right reserved.

Kibella is not a free software. The Kibella software is NOT licensed under the "Apache License". 
If you are interested in distributing, reselling, modifying, contibuting or in general creating 
any derivative work from Kibella, please contact Frank Vanden Berghen at frank@timi.eu.
*/
namespace kibella; function l7a($l6j,$l22,$O21) { $O2h=json_decode($l6j,TRUE); $O22=l23($l22,$O21); $l5r=O2d($O22); $O27=l2h($O2h,"kibella\\parseEsJsonQueryElement",array("fieldtypes" => $l5r)); return $O27; } function parseesjsonqueryelement($O2l,$l3o,$l2j,$O2j,$l2k,$O2i) { static $O7a; static $l7b; static $O7b; static $l7c; static $O7c; static $l7d; static $O7d; static $l7e; static $O7e; static $l7f; static $O7f; static $l7g; static $O7g; static $l7h; static $O7h; static $l7i; static $O7i; static $l7j; static $O7j; static $l7k; static $O7k; static $l7l; static $O7l; static $l7m; static $O7m; static $l7n; static $O7n; static $l7o; static $O7o; static $l7p; static $O7p; static $l7q; static $O7q; static $l7r; static $O7r; static $l7s; static $O7s; static $l7t; static $O7t; static $l7u; static $O7u; static $l7v; global $O7v; global $l7w; if ($l2j == 0 && $O2j == 0) { $O7a=array(); $l7b=array(); $O7b=array(); $l7c=array("level" => 0,"context" => array(O1n),"idx" => array(-1),"size" => array($l2k)); $l7d=array(); $O7d=FALSE; $l7e=FALSE; $O7e=FALSE; $l7f=-1; $O7f=NULL; $l7g=NULL; $O7g=NULL; $l7h=NULL; $O7h=NULL; $l7i=NULL; $O7i=DISCOVERSIZE; $l7j=NULL; $O7j=NULL; $l7k=NULL; $l7l=NULL; $O7k=NULL; $O7l=NULL; $l7m=NULL; $O7m=NULL; $l7n=""; $O7n=l15; $l7o=""; $O7o=NULL; $l7p=NULL; $O7p=NULL; $l7q=""; $O7q=""; $l7r=NULL; $O7r=""; $l7s=NULL; $O7s=NULL; $l7t=NULL; $O7t=NULL; $l7u=NULL; $O7u=NULL; $l7v=""; if (array_key_exists("fieldtypes",$O2i)) $O7a=$O2i["fieldtypes"]; } if ($O2j>$l7c["level"]) { return $O7c; } $l7c["idx"][$l7c["level"]]++; if (is_array($O2l) && count($O2l)>0) { $l7c["level"]++; $O3o=$l7c["context"][$l7c["level"]-1]; $l3o=O3n($l3o,$O3o); if (array_search(NULL,$O7v[$O3o]) !== FALSE || array_search(( string) $l3o,$O7v[$O3o]) !== FALSE || $O3o == l1a && array_search(( string) $l3o,$O7v[l1a][0]) !== FALSE) { if ($l3o === O19) { $l7f ++; } else if ($l3o === l1i) { $O7d=TRUE; } switch ($O3o) { case (O19): $l7m=$l3o; $l7c["context"][]=l1a; $O7s="(CASE"; break; case (l1a): if ($l2l=array_search($l3o,$O7v[l1a][0]) !== FALSE) { $l7u=$l7w[$l3o]; $l7c["context"][]=l1p; } else if ($l2l=array_search($l3o,array_slice($O7v[l1a],1)) !== FALSE) { $l7c["context"][]=$l3o; } else l73($l3o,$O3o,$O7v,"COMPOUND",2); break; case (O1b): if ($l3o === O1j) $l7o=""; else if ($l3o === l1k) $l7o=" not "; $l7c["context"][]=$l3o; break; case (l1f): if (strpos($l3o,"(CASE WHEN ") === 0) { $O7k=$l3o; } else { $O7k=O2x($l3o); } $l7c["context"][]=O1f; break; case (l1g): $l7l=O2x($l3o); $l7c["context"][]=O1g; break; case (l1d): $O7w=O2x($l3o); $l7x=O36($l3o); $O7j=O2x($l7x."_".l1u); $l7k=O2x($l7x."_".O1t); $l7c["context"][]=l1e; break; case (l1e): switch (( string) $l3o) { case (O1d): case (O1e): $l7c["context"][]=$l3o; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; default : if (gettype($l3o) == "integer") { $O7x=end($l7c["size"]); reset($l7c["size"]); if ($O7x>1) { $l2j=$l3o; if ($l2j == $O7x-1) { $O7q=")"; } if ($l2j == 0) { $l7q="("; } else { $O7n=" and "; $l7q=""; if ($l2j<$O7x-1) $O7q=""; } } $l7c["context"][]=$O3o; } else $l7c["context"][]=$l3o; break; } } else { l73($l3o,$O3o,$O7v,"COMPOUND",1); $l7c["context"][]=$O3o; } if (DEBUG) { echo "CONTEXT history\n"; print_r($l7c["context"]); } $l7c["idx"][]=-1; $l7c["size"][]=count($O2l); $O3o=$l7c["context"][$l7c["level"]]; if (DEBUG) echo "Keyword: $l3o => Entering context ".$O3o."... (field aggregation level is $l7f)\n"; } else { $O2j=$l7c["level"]; $O37=$l7c["idx"][$O2j]; $O7x=$l7c["size"][$O2j]; $O3o=$l7c["context"][$O2j]; $l3o=O3n($l3o,$O3o); switch ($O3o) { case (O1i): case (l1j): $l7b[$l7f]["ofield"]=$l7m; if ($O3o == O1i) $l7b[$l7f]["type"]="h"; else $l7b[$l7f]["type"]="hd"; $l7b[$l7f]["order"]=O2x($l7m); $l7b[$l7f]["limit"]=""; switch (( string) $l3o) { case (O1r): $O7l=O2x($O2l); $l7b[$l7f]["ifieldname"]=$O7l; $l7b[$l7f]["ifield"]=$O7l; break; case (O1v): $l7b[$l7f]["interval"]=$O2l; break; case (O1x): break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1h): $l7b[$l7f]["ofield"]=$l7m; $l7b[$l7f]["type"]="g"; $l7b[$l7f]["order"]=O2x($l7m); $l7b[$l7f]["limit"]=""; switch (( string) $l3o) { case (O1r): $O7l=$O2l; $l7b[$l7f]["ifieldname"]=O2x(O36($O7l)); break; case (O1y): $l7b[$l7f]["ifield"]=O2x(O36($O7l)."_geohash".$O2l); break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1d): switch (( string) $l3o) { case (O1t): $l7h=$O2l; break; case (l1u): $O7f=$O2l; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1e): switch (( string) $l3o) { case (O1t): $O7g=$O2l; break; case (l1u): $l7g=$O2l; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1f): switch (( string) $l3o) { case (l1y): $O7n=$O2l; break; case (l1z): $O7u=$O2l; break; case (l21): if ($O2l === "phrase") $O7r="'"; else $O7r=""; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (l1l): if ($l3o === l1q) { $O7p=$l7w[l17]."(*)"." ".$O2l; } else { $O7p=O2x($l3o)." ".$O2l; } $l7b[$l7f]["order"]=$O7p; break; case (l1m): switch (( string) $l3o) { case (O1p): break; case (l1z): if ($O2l === "*") $l7r=1; else $l7r=$O2l; $l7d[]=trim($l7r); break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1a): case (l1b): $l7b[$l7f]["ofield"]=$l7m; if ($O3o == O1a) { $l7b[$l7f]["type"]="r"; } else { $l7b[$l7f]["type"]="rd"; } $l7b[$l7f]["order"]=O2x($l7m); $l7b[$l7f]["limit"]=""; switch (( string) $l3o) { case (O1r): $O7l=O2x($O2l); $l7b[$l7f]["ifieldname"]=$O7l; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1g): switch (( string) $l3o) { case (O1s): $O7m=$O2l; break; case (O1u): case (l1v): $l7i=$O2l; if ($l3o === O1w) $O7o=">"; else $O7o=">="; break; case (O1w): case (l1x): $O7h=$O2l; if ($l3o === O1w) $l7p="<"; else $l7p="<="; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (l1n): switch (( string) $l3o) { case (l1t): if ($l7b[$l7f]["type"] == "rd") { $O2l=O3c($O2l); } $l7s=$O2l; $l7t=$O2l."-"; break; case (O20): if ($l7b[$l7f]["type"] == "rd") { $O2l=O3c($O2l); } $O7t=$O2l; $l7t.=$O2l; $O7s.="\n\tWHEN ".$l7s." <= ".$O7l." AND ".$O7l." < ".$O7t." THEN "."'".$l7t."'"; $l7b[$l7f]["ranges"][]=$l7t; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1n): if ($l3o === l20) { $O7i=$O2l; $l7n=l3r($O7i); } else l73($l3o,$O3o,$O7v,"LEAF"); break; case (l1p): switch (( string) $l3o) { case (O1r): $l7j=O2x($O2l); break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; case (O1o): $l7b[$l7f]["ofield"]=$l7m; $l7b[$l7f]["type"]="t"; switch (( string) $l3o) { case (O1r): $O7l=O2x($O2l); $l7b[$l7f]["ifieldname"]=$O7l; $l7b[$l7f]["ifield"]=$O7l; break; case (l20): $l7n=l3r($O2l); $l7b[$l7f]["limit"]=$l7n; break; default : l73($l3o,$O3o,$O7v,"LEAF"); break; } break; default : O75($O3o,"LEAF"); break; } while ($O37 == $O7x-1 && $O2j>=0) { if (DEBUG) echo "\tRemoving data from level: ".$O2j."\n"; $O2j --; $l7c["level"]=$O2j; foreach (array_slice($l7c,1) as $l7y => $O7y) { array_pop($l7c[$l7y]); } assert($O2j>=-1,"\$level >= -1"); if ($O2j>=0) { switch ($O3o) { case (l1a): $l7j=NULL; $l7m=NULL; $l7u=NULL; break; case (O1a): case (l1b): assert(!is_null($O7s) && !is_null($l7m),"C_AGGS_RANGE: Range grouping ($O7s), FieldOut ($l7m) are not null"); $O7s.="\nEND)"; $l7b[$l7f]["ifield"]=$O7s; break; case (O1d): case (O1e): case (O1f): case (O1g): case (l1m): if ($O3o == O1d && !is_null($O7j) && !is_null($l7k) && !is_null($O7f) && !is_null($l7h)) { if (!$O7e) { $l7z="("; $O7z=""; } else { $l7z=""; $O7z=")"; } $l7r=$l7z.$l7h." <= ".$l7k." and ".$O7j." <= ".$O7f.$O7z; $l7e=TRUE; } else if ($O3o == O1e && !is_null($O7j) && !is_null($l7k) && !is_null($l7g) && !is_null($O7g)) { if (!$l7e) { $l7z="("; $O7z=""; } else { $l7z=""; $O7z=")"; } $l7r=$l7z.$l7g." <= ".$O7j." and ".$l7k." <= ".$O7g.$O7z; $O7e=TRUE; } else if ($O3o == O1f && !is_null($O7k) && !is_null($O7u)) { $l7r=$O7k." = ".$O7r.O2z($O7u).$O7r; } else if ($O3o == O1g && !is_null($l7i) && !is_null($O7h)) { if (array_key_exists($l7l,$O7a) && $O7a[$l7l] === "date") { $l7l=$l7l."*1000"; } $l7r= "$l7l $O7o $l7i and $l7l $l7p $O7h"; } $l80=$l7q.$l7o; if ($l7v == "") $l7v="WHERE"; else { if (($l7e+$O7e)<2) $l80=$O7n.$l7q.$l7o; else $l80=$O7n.$l7q; } if (!is_null($l7r)) { $l7v.="\n".$l80."(".$l7r.")".$O7q; } $l7d[]=trim($l7o.$l7r); $l7q=""; $O7q=""; $O7n=l15; $O7o=NULL; $l7p=NULL; if ($l7e && $O7e) { $O7j=NULL; $l7k=NULL; $l7e=FALSE; $O7e=FALSE; } $O7f=NULL; $l7g=NULL; $O7g=NULL; $l7h=NULL; $O7h=NULL; $l7i=NULL; $O7k=NULL; $l7l=NULL; $O7u=NULL; $l7r=NULL; break; case (l1l): assert(!is_null($O7p),"C_ORDER: Order statistic ($O7p) is not null"); break; case (l1p): assert(!is_null($l7j) && !is_null($l7m) && !is_null($l7u),"C_STATISTIC: Field ($l7j), FieldOut ($l7m), Statistic ($l7u) are not null"); $O7z=str_repeat(")",substr_count($l7u,"(")); $O7b[$l7m]=$l7u."(".$l7j.")".$O7z; $l7j=NULL; break; case (O1o): assert(!is_null($O7l) && !is_null($l7m),"C_TERMS: Grouping field ($O7l), FieldOut ($l7m) are not null"); break; default : break; } $O37=$l7c["idx"][$O2j]; $O7x=$l7c["size"][$O2j]; if ($O3o == O19) { $l7f --; } $O3o=$l7c["context"][$O2j]; } else { if (DEBUG) echo "REACHED LAST KEY-VALUE PAIR\n"; if ($O7d === TRUE) { $l7n=l3r(DISCOVERSIZE); } $O7c=array("xaggs" => $l7b,"yaggs" => $O7b,"filterArray" => $l7d,"filter" => $l7v,"discover" => array("tab" => $O7d,"limit" => $l7n)); return $O7c; } } } } function O80($l81) { $O81=array(); foreach ($l81["xaggs"] as $l49) { $O81[]=l2m($l49); } $O81[]=l2m($l81["yaggs"]); $O81[]=$l81["filterArray"]; sort($O81[count($O81)-1]); $O81[]=l2m($l81["discover"]); return $O81; } function O6m($l22,$O21,$l82,$l3) { $O48=$l82["xaggs"]; $O82=$l82["yaggs"]; $l83=$l82["filter"]; $O83=$l82["discover"]; $l84=fopen($l3,"wt"); if (!$l84) { O29( __FUNCTION__ ,lc,"Error opening or creating file $l3\n. An empty response will be returned.\n"); return ""; } $O84="sqlite"; $l85=dbdbhcreate($O21,$O2r=DATADIR,$l4x=$O84,$O5g=array("dbtype" => "sqlite","attributes" => array( \pdo::ATTR_PERSISTENT => TRUE,\pdo::ATTR_STRINGIFY_FETCHES => FALSE)),$l5h=array("flags" => SQLITE3_OPEN_READONLY)); $O85= "SELECT count(*) from $l22"."\n".$l83; $l86=dbdbhexecutesqlquery($l85,$O85); if ($l86 === FALSE) { $O86=0; } else { $O86=$l86[0]["count(*)"]; } if (DEBUG) { echo "\nTotal Hits:\n"; print_r($l86); } l87($l84,$O86); if ($O83["tab"] === TRUE && count($O48) == 0 && count($O82) == 0) { O2f("[",$O2g=$l84); $O22=l23($l22,$O21); $l5r=O2d($O22); $O87="SELECT rowid as _id"; $l5o=array(); foreach ($l5r as $l2e => $O2e) { if ($O2e === "date") { $O87.=", ".$l2e." as ".$l2e; $l5o[]=str_replace("\"","",$l2e); } else if ($O2e === "geo_point") { if (l5c($l2e,$l22,$O21,$O2r,$O24="sqlite") === TRUE) $O87.=", ".$l2e; } else { $O87.=", ".$l2e; } } $l5k=$O87."\nFROM ".$l22."\n".$l83."\nORDER BY _id"."\n".$O83["limit"]; $l5l=l6p($l85,$l5k); if ($l5l !== FALSE) { $l88=""; while ($O51=O6p($l5l)) { $O28=$O51["_id"]; foreach ($l5o as $O88) { $l89=date_create(strftime("%Y-%m-%d %H:%M:%S",$O51[$O88])); $O3b=(array) $l89; $l3c=timezone_offset_get(new \datetimezone($l89->timezone),$l89); $O51[$O88]=($O51[$O88]-$l3c)*01750; } $O89=($O86-$O28)/$O86; $l8a=$l88."{"."\"".lj."\":\"".$O22."\","."\"".Oj."\":\"row\","."\"".lk."\":\"".$O28."\","."\"".ll."\":".$O89.","."\"".lm."\":".json_encode($O51)."}"; O2f($l8a,$O2g=$l84); $l88=","; } unset ($O51); } unset ($l5l); O2f("]}",$O2g=$l84); } else { O2f("[]}",$O2g=$l84); if (count($O48)>0 || count($O82)>0) { O2f(",\"aggregations\":{",$O2g=$l84); if (count($O48) == 0) { $l88=""; $O8a=""; foreach ($O82 as $l8b => $O8b) { $O8a.= "\n\t$l88".$O8b." as ".O2x($l8b); $l88=","; } $l5k="SELECT".$O8a."\nFROM ".$l22."\n".$l83; $l8c=dbdbhexecutesqlquery($l85,$l5k,$l4x="query"); if ($l8c !== FALSE) { O8c($l84,$l8c[0],0); } } else { $l8d=":memory:"; $O8d=dbdbhcreate($l8d,$O2r="",$l4x=$O84); $l8e="attach database '".$l8d."' as ".Op; dbdbhexecutesqlquery($l85,$l8e,$l4x="exec"); $O2e=$O48[0]["type"]; $O8e="T".l68(); $l8f=$O8e."_T0"; $O8f=l8g($O48[0],$O82,Op.".$l8f" ,$l22,$l83,$l85); if (DEBUG) { echo "Output filename: $l3\n"; echo "\nCreating temporary table $l8f in the temporary database located at ".$l8d."...\n"; echo $O8f; } $l5k=$O8f; $O8g=dbdbhexecutesqlquery($l85,$l5k,$l4x="exec"); if ($O8g !== FALSE) { if (count($O48)>1) { if (DEBUG) echo "\nRecurring to the lower grouping level...\n"; l8h($l84,$l22,$l85,$l83,$l8f,1,$O48,array(),$O82,$O8e,""); } else { $l5k="select * from ".Op.".$l8f"; if (DEBUG) echo "\nSQLQUERY: $l5k\n"; $O8h=array("sqlquery" => $l5k,"db" => $l85,"dbtype" => "sqlite","dir" => TABLESDIR); $l8i=O8i($l84,$O2e,0,$O48,$O8h); if ($l8i>0) l8j($l84,$O2e); } } $O8j=array("dbh" => $O8d,"attachname" => Op); O5d($l85,$l4x=$O84,$l5e=TRUE,$O5e=$l8d,$l5f=$O8j); } O2f("}",$O2g=$l84); } } O2f("}",$O2g=$l84); O5d($l85,$l4x=$O84,$l5e=FALSE); fclose($l84); } function l8h($O3w,$l8k,$l85,$l83,$O8k,$O2j,$O48,$l8l,$O82,$O8l,$l8m) { assert($O2j>0,"Grouping level is larger than 0"); assert(count($O48)>$O2j,"The xaggs array has more than \$level elements (count(\$xaggs)=".count($O48).", level=$O2j)"); assert(count($l8l) == $O2j-1,"The aGroupValuesAndTypes array has \$level-1 elements (count(\$aGroupValuesAndTypes)=".count($l8l).", level-1=$O2j-1)"); $O8m=$O48[$O2j-1]["ofield"]; $l8n=$O48[$O2j-1]["type"]; $l5k="select * from ".Op.".$O8k"; $l5l=l6p($l85,$l5k); $O8n=TEMPDIR."/$O8k"; $l8o=fopen($O8n,"wt"); if (!$l8o) { O29( __FUNCTION__ ,lc,"Cannot open temporary file $O8n for writing. Check directory permissions.\n"); } while ($O51=O6p($l5l)) { $O8o=array_keys($O51); $l8p=implode("|",$O51); fwrite($l8o,$l8p."\n"); } fclose($l8o); unset ($O51); unset ($l5l); $l8o=fopen($O8n,"r"); if (!$l8o) { user_error( "Cannot open temporary file $O8n for reading" ,E_USER_ERROR); } $O8p=-1; $l88=""; while (($l8p=fgets($l8o)) !== FALSE) { $O8p ++; if (DEBUG) echo "Reading row $O8p...\n"; $l8p=preg_replace("/[\n\r]\$/","",$l8p); $l8q=explode("|",$l8p); $O51=array_combine($O8o,$l8q); $O8q=$O51[$O8m]; if ($O8p == 0) { l8r($O3w,$l8n,$O2j-1,$O8m); $l8m.= "_$O8p"; $l8l[]=array("value" => $O8q,"type" => $l8n); } else { $l8m=substr_replace($l8m,$O8p,strrpos($l8m,"_")+1); $l8l[$O2j-1]=array("value" => $O8q,"type" => $l8n); } O8r($O3w,$l8n,$O51,$l88); $l8s=""; for ($O8s=0; $O8s<$O2j; $O8s ++) { $l8t=$O48[$O8s]["ifield_parsed"]; $O8t=$l8l[$O8s]["value"]; $l8u=$l8l[$O8s]["type"]; if ($l8u == "t" || $l8u == "r" || $l8u == "rd") $O8u="'".O2z($O8t)."'"; else $O8u=$O8t; $l8s.=" and ".$l8t." = ".$O8u; } if (strstr($l83,"WHERE") === FALSE) { $l8s=preg_replace("/[ ]+and[ ]+/","WHERE ",$l8s,1); } $l8v=$l83.$l8s; $l8f=$O8l."_S$l8m"; if (DEBUG) echo "Output table name: $l8f\n"; $O8f=l8g($O48[$O2j],$O82,Op.".$l8f" ,$l8k,$l8v,$l85); if (DEBUG) { echo "\n".str_repeat("\t",$O2j)."SQLQUERY Level $O2j:\n"; echo "\nCreating temporary table $l8f in temporary database...\n"; echo $O8f; } $l5k=$O8f; dbdbhexecutesqlquery($l85,$l5k,$l4x="exec"); if ($O2j<count($O48)-1) { if (DEBUG) echo "Recurring again...\n"; l8h($O3w,$l8k,$l85,$l83,$l8f,$O2j+1,$O48,$l8l,$O82,$O8l,$l8m); } else { $O2e=$O48[$O2j]["type"]; $l5k="select * from ".Op.".$l8f"; if (DEBUG) { echo "\n****** END OF RECURSION (level = $O2j, last table ID: $l8m)\n"; echo "The table is for group combo:\n"; for ($O8s=0; $O8s<$O2j; $O8s ++) { $l8t=$O48[$O8s]["ifield"]; $O8t=$l8l[$O8s]["value"]; echo "$l8t = '$O8t'\n"; } echo "****** END OF RECURSION\n"; } $O8h=array("sqlquery" => $l5k,"db" => $l85,"dbtype" => "sqlite","dir" => TABLESDIR); $l8i=O8i($O3w,$O2e,$O2j,$O48,$O8h); if ($l8i>0) { if (DEBUG) echo "Closing Lowest level $O2j...\n"; l8j($O3w,$O2e); } } if (DEBUG) echo "Closing Group value $O8p at level (".$O2j-1 .")...\n"; O2f("}",$O2g=$O3w); $l88=","; } fclose($l8o); if (!unlink($O8n)) { user_error( "Could not delete temporary file $O8n" ,E_USER_WARNING); } if ($O8p>=0) l8j($O3w,$l8n); } function O8v($l8w,$O8w="_count") { return str_ireplace("count(*)",$O8w,$l8w); } function l8g(&$O48,$O82,$l8f,$O8k,$l83,$l5b) { global $O4c; $l40=$O48["ofield"]; $l8x=O2x($l40); $O2e=$O48["type"]; $l44=$O48["ifield"]; $l8w=$O48["order"]; $O8x=$O48["limit"]; switch ($O2e) { case ("r"): case ("rd"): assert(count($O48["ranges"])>0,"There is at least one RANGE value"); $l8y=Op."._ranges"; $l5k= "CREATE TABLE $l8y (_range TEXT, _range_from NUMBER);"; foreach ($O48["ranges"] as $O8y) { $l8z=O3h($O8y); $O8z=$l8z[0]; if ($O8z === "") $O8z="NULL"; $l5k.= "\nINSERT INTO $l8y values ('$O8y', $O8z);"; } if (DEBUG) { echo "SQL for _RANGES:\n"; echo $l5k."\n"; } O5j($l5b,$l8y); dbdbhexecutesqlquery($l5b,$l5k,$l4x="exec"); if (DEBUG) { echo "RESULT _ranges:\n"; $O5k=dbdbhexecutesqlquery($l5b,"select * from $l8y"); print_r($O5k); } $l8w="_range_from"; $l90=$l44; $O48["ifield_parsed"]=$l90; break; case ("h"): case ("hd"): $O44=$O48["interval"]; $l5k= "SELECT min($l44) as _min, max($l44) as _max FROM $O8k $l83"; $O90=dbdbhexecutesqlquery($l5b,$l5k,$l4x="query"); if ($O90 === FALSE || count($O90) == 0) { $l90=""; } else { if ($O90[0]["_min"] === "" || $O90[0]["_max"] === "") { $l90="(CASE WHEN 1 THEN null END)"; } else { if ($O2e == "h") { assert($O44>0,"The histogram interval value (bin size) is positive"); $l91=floor($O90[0]["_min"]/$O44)*$O44; $O91=$O90[0]["_max"]; $l92=floor(($O91-$l91)/$O44)+1; if ($l92 == 0) $O92=1; $l93="(CASE"; $O93=$l91; for ($l2v=0; $l2v<$l92; $l2v ++) { $l94=$O93+$O44; $l93.= "\n\tWHEN $O93 <= $l44 AND $l44 < $l94 THEN $O93"; $O93=$l94; } } else { $l4e=date_create(gmstrftime("%Y-%m-%d %H:%M:%S",$O90[0]["_min"]),new \datetimezone("UTC")); $O4e=(array) $l4e; $l3f=max(1,round(substr($O44,0,strlen($O44)-1)))*1; $O3f=substr($O44,strlen($O44)-1); assert($l3f>0,"The step is positive (value given: $l3f)\n"); assert(array_key_exists($O3f,$O4c) !== FALSE,"The period definition is one of the 7 valid one (value given: $O3f)\n"); $O94=$O90[0]["_max"]-$O90[0]["_min"]; if ($O3f === "s" && $O94>01274) { $l3f=1; $O3f="m"; } if ($O3f === "m" && $O94/074>01274) { $l3f=1; $O3f="h"; } $O48["interval"]=$l3f.$O3f; O3g($l4e,$O3f); $l91=date_timestamp_get($l4e); $O91=$O90[0]["_max"]; $l93="(CASE"; $O93=$l91; while ($O93<=$O91) { date_modify($l4e,"$l3f ".$O4c[$O3f]); $O4e=(array) $l4e; $l94=date_timestamp_get($l4e); $l95=$O93; $l93.= "\n\tWHEN $O93 <= $l44 AND $l44 < $l94 THEN $l95"; $O93=$l94; } } $l90=$l93."\nEND)"; } $O48["ifield_parsed"]=$l90; } break; default : $l90=$l44; $O48["ifield_parsed"]=$l90; break; } $O95=$l90." as ".$l8x; $O8a=""; $l96=""; foreach ($O82 as $l8b => $O8b) { $O8a.="\n\t,".$O8b." as ".O2x($l8b); $l96.="\n\t,".O2x($l8b); } $O87="SELECT"."\n\t".$O95."\n\t,count(*) as _count".$O8a."\nFROM ".$O8k."\n".$l83."\nGROUP BY ".$l90; $l5k= "CREATE TABLE $l8f as"; if ($O2e == "r" or $O2e == "rd") { $l5k.="\nSELECT"."\n\ta._range as ".$l8x."\n\t,IFNULL(b._count,0) as _count".$l96."\nFROM $l8y a"."\nLEFT JOIN ("."\n\t".$O87."\n\t\t) b"."\nON a._range = b.".$l8x; } else { $l5k.="\n".$O87; } assert($l8w != NULL && $l8w != "","Order variable is not null nor empty"); $l8w=O8v($l8w); $l5k.="\nORDER BY ".$l8w."\n".$O8x; return $l5k; } function l87($O3w,$O86) { assert($O86 !== NULL,"The number of total hits is not null"); $O96="{"; $l97="\"took\":0,"."\"timed_out\":false,"."\"_shards\":{"."\"total\":5,"."\"successful\":5,"."\"failed\":0"."},"; $O97="\"hits\":{"."\"total\":".$O86.","."\"max_score\":0,"."\"hits\":"; O2f($O96.$l97.$O97,$O2g=$O3w); } function l8r($O3w,$O2e,$O2j,$l40) { $l98=""; $l88=","; if ($O2j == 0) $l88=""; $l2g=$l88.O2x($l40).":{"; switch ($O2e) { case ("t"): $l2g.="\"doc_count_error_upper_bound\":0,"; $l2g.="\"sum_other_doc_count\":0,"; $l98="["; break; case ("g"): case ("h"): case ("hd"): $l98="["; break; case ("r"): case ("rd"): $l98="{"; break; default : break; } $l2g.="\"".l1c."\":".$l98; O2f($l2g,$O2g=$O3w); } function O8r($O3w,$O2e,$O98,$l88) { l99($O3w,$O2e,$O98,$l88); O8c($O3w,$O98); } function O8i($O3w,$O2e,$O2j,$O48,$O8h) { $O21=$O8h["db"]; $l5k=$O8h["sqlquery"]; $l5l=l6p($O21,$l5k); $O51=O6p($l5l); $l88=""; $l8i=0; if ($O51) { l8r($O3w,$O2e,$O2j,$O48[$O2j]["ofield"]); do { $l8i ++; l99($O3w,$O2e,$O51,$l88); O8c($O3w,$O51); O2f("}",$O2g=$O3w); $O51=O6p($l5l); $l88=","; } while ($O51); } unset ($O51); unset ($l5l); return $l8i; } function l99($O3w,$O2e,$O98,$l88="") { $l2n=array_keys($O98); $O2l=$O98[$l2n[0]]; $l2g=$l88; switch ($O2e) { case ("t"): case ("g"): case ("h"): case ("hd"): $l2g.="{"; if (l3n($O2l) === FALSE) $O99=O2x($O2l); else { if ($O2e == "hd") { if (PHP_SAPI !== "cli") { $O2l=O3a($O2l); } $O99=$O2l*01750; } else $O99=$O2l; } $l2g.="\"key\":".$O99.","; break; case ("r"): case ("rd"): $l2g.=O2x($O2l).":{"; $l4f=O3h($O2l); $l3k=$l4f[0]; $O3k=$l4f[1]; if ($O2e == "rd") { if (PHP_SAPI !== "cli") { $l3k=O3a($l3k); $O3k=O3a($O3k); } $l3k=$l3k*01750; $O3k=$O3k*01750; } $l2g.="\"from\":".$l3k.","; $l2g.="\"from_as_string\":".O2x($l3k).","; $l2g.="\"to\":".$O3k.","; $l2g.="\"to_as_string\":".O2x($O3k).","; break; default : break; } $l2g.="\"doc_count\":".$O98["_count"]; O2f($l2g,$O2g=$O3w); } function O8c($O3w,$O98,$l9a=2) { $l2n=array_keys($O98); $O9a=count($O98); if ($l9a == 0) { $l88=""; } else { $l88=","; } $l2g=""; for ($l2v=$l9a; $l2v<$O9a; $l2v ++) { $l2e=$l2n[$l2v]; $O2l=$O98[$l2n[$l2v]]; $l2g.=$l88.O2x($l2e).":{"; if ($O2l === NULL || $O2l === "") $l2g.="\"value\":null"; else $l2g.="\"value\":".$O2l; $l2g.="}"; $l88=","; } O2f($l2g,$O2g=$O3w); } function l8j($O3w,$O2e) { $l9b=""; switch ($O2e) { case ("t"): case ("g"): case ("h"): case ("hd"): $l9b="]"; break; case ("r"): case ("rd"): $l9b="}"; break; default : break; } $l2g=$l9b."}"; O2f($l2g,$O2g=$O3w); }