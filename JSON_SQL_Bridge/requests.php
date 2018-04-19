<?php
/*
KIBELLA 1.0
Copyright 2016 Frank Vanden berghen
All Right reserved.

Kibella is not a free software. The Kibella software is NOT licensed under the "Apache License". 
If you are interested in distributing, reselling, modifying, contibuting or in general creating 
any derivative work from Kibella, please contact Frank Vanden Berghen at frank@timi.eu.
*/
namespace kibella; require_once "config.php"; ob_start(); l9t("200 OK"); $Oa0=$_SERVER["REQUEST_URI"]; $Oal=$_SERVER["REQUEST_METHOD"]; $O9d=file_get_contents("php://input"); $l6f=json_decode($O9d,TRUE); $lam=O7; if (preg_match( "/$lam%2C/" ,$Oa0)) { if (array_key_exists("docs",$l6f)) { O2f("{\"docs\":["); for ($l2v=0; $l2v<count($l6f["docs"]); $l2v ++) { $Oam=$l6f["docs"][$l2v]; if ($l2v>0) O2f(","); l5x("","",1,lo,"false"); } O2f("]}"); } } else if (preg_match("/_msearch/i",$Oa0)) { l9d($O9d); $l6f=explode("\n",$O9d); if (count($l6f)>1) { $O4i=$l6f[1]; l9y(O12,$O4i); } } else if (preg_match("/_mapping\\/field\\//i",$Oa0)) { $lan=la0($Oa0,ESDIRNAME,"begin"); $O28=$lan["object"]; O6o($O28); } else if (preg_match("/index-pattern\\/\$/i",$Oa0)) { $lan=la0($Oa0,ESDIRNAME,"begin"); $l22=$lan["object"]; l5x("index-pattern",$l22,1,lo,"true"); } else if (preg_match("/index-pattern\\/_search/i",$Oa0)) { O70(lr,lh,"*"); } else if (preg_match("/index-pattern/i",$Oa0)) { $lan=la0($Oa0,ESDIRNAME,"end"); $O28=$lan["object"]; if ($Oal == "POST") { l5x("index-pattern",$O28,1,lo,"true"); } else if ($Oal == "DELETE") { O5u(lr,lh,$O28); } } else if (preg_match("/_update\$/i",$Oa0)) { l9y(l12,$l6f["doc"]["defaultIndex"],$O9y="raw"); } else if (preg_match("/(dashboard|search|visualization)\\/_search/i",$Oa0,$O3e)) { assert(count($O3e)>=2,"Variable \$matches with the matched pattern has at least 1 element (found ".count($O3e).")"); $Oan=$O3e[1]; assert(array_key_exists("query",$l6f),"Attribute 'query' exists in the request array"); if (array_key_exists("simple_query_string",$l6f["query"]) && array_key_exists("query",$l6f["query"]["simple_query_string"])) { $O4n=$l6f["query"]["simple_query_string"]["query"]; } else { $O4n="*"; } O70(Ov,$Oan,$O4n); } else if (preg_match("/\\/dashboard|\\/search|\\/visualization/i",$Oa0,$O3e)) { assert(count($O3e)>=1,"Variable \$matches with the matched pattern has at least 1 element (found ".count($O3e).")"); $Oan=substr($O3e[0],1); $lan=la0($Oa0,ESDIRNAME,"end"); $O28=$lan["object"]; if ($Oal == "POST") { $l6w=$O9d; O6v($Oan,$l6w); } else if ($Oal == "GET") { $O28=la8($O28); l6g($Oan,$O28,$O6g=FALSE); } else if ($Oal == "DELETE") { $O28=la8($O28); O5u(Ov,$Oan,$O28); } } else if (preg_match("/\\/_search/i",$Oa0,$O3e)) { $lao=str_replace($O3e[0],"",$Oa0); $lan=la0($lao,ESDIRNAME,"end"); $O22=$lan["object"]; if (count($l6f["query"]["ids"]["values"])>0) { $O6j=$l6f["query"]["ids"]["values"][0]; O6i($O22,$O9d,$O6j); } } else if (preg_match("/_mget/i",$Oa0)) { assert(array_key_exists("docs",$l6f),"Attribute 'docs' exists in the request array"); assert(count($l6f["docs"] == 1),"There is only one request in the request array"); if (array_key_exists(lk,$l6f["docs"][0])) { $O28=$l6f["docs"][0][lk]; } else { $O28=""; } if (array_key_exists(Oj,$l6f["docs"][0])) { $O2e=$l6f["docs"][0][Oj]; switch ($O2e) { case (lg): l9u(); break; case (Og): case (Oh): case (Oi): l6g($O2e,$O28); break; case (lh): l6o($O28); break; default : break; } } } else { $Oa4=la5($Oa0); $Oa5=$Oa4["URI"]; $Oao=str_replace("/".ESDIRNAME,"",$Oa5); $Oao=str_replace(O7,"_kibana_4",$Oao); $Oao=preg_replace("/[\\/\\-\\.\\*]/","_",$Oao); if (function_exists( "kibella\\$Oao")) { call_user_func( "kibella\\$Oao"); } } ob_end_flush(); if (LOG) { fclose($O79); } exit;