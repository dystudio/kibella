<?php
/*
JSON_SQL_Bridge 1.1
Copyright 2016 Frank Vanden berghen
All Right reserved.

JSON_SQL_Bridge is not a free software. The JSON_SQL_Bridge software is NOT licensed under the "Apache License". 
If you are interested in distributing, reselling, modifying, contibuting or in general creating 
any derivative work from JSON_SQL_Bridge, please contact Frank Vanden Berghen at frank@timi.eu.
*/
namespace kibella; function O95($l96) { $O65=explode("\n",$l96); if (count($O65)<2) { O2f( __FILE__ ,"error","The request body of the POST data is not valid. It should have at least 2 elements but ".count($O65)." were found.\nProgram aborts.\n"); } else { $O96=floor(count($O65)/2); echo "{\"responses\":["; for ($l97=0; $l97<$O96; $l97 ++) { if ($l97>0) echo ","; $l63=json_decode($O65[2*$l97],TRUE); $l1x=$l63["index"]; $O69=$O65[2*$l97+1]; $O4m=O48($l1x,$O69); $l4n=$O4m["responseFile"]; l6h($l1x,$O69,O97($l4n)); if ($l4n !== FALSE) { $l98=l6e($l4n); if ($l98 === FALSE) { O2f( __FUNCTION__ ,"warning","The response file could not be read.\nCheck permissions on the file '".$l4n."'.\n"); } } } echo "]}"; } } function O48($l1x,$O69,$O1y=FALSE) { $l63=l4i($l1x); if ($l63 === FALSE) { if ($O1y) O2f("",l6,"Table with table ID '$l1x' was not found in the registered tables information."); O81(NULL,0); l20("[]}}"); return FALSE; } $O1w=$l63["table"]; $l1w=$l63["db"]; $O4h=$l63["cache"]; $l7x=l75($O69,$O1w,$l1w); $O98=O7v($l7x); $O6a=l6b($l1x,$O98); if (!O6o(l4) && (time()-O6o(O3))>O4 && file_exists(O6o(l3)) === TRUE) { @unlink(O6o(l3)); } $O6b=l6c($O6a,$O4h); if ($O6b === FALSE) { if (file_exists($O6a["responseFileTmp"])) { l99($O6a["responseFile"]); } else { l6d($O1w,$l1w,$l7x,$O6a["responseFileTmp"]); O6d($O6a,$O4h); if ($O1y) { echo "--------------------\n"; echo "Result from parseEsJsonRequest():\n"; print_r($l7x); echo "--------------------\n"; echo "Result from generateEsJsonResponse():\n"; l6e($O6a["responseFile"]); } } } return array("responseFile" => $O6a["responseFile"],"parsedQuery" => $l7x); }