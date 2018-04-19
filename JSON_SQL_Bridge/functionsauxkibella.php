<?php
/*
KIBELLA 1.0
Copyright 2016 Frank Vanden berghen
All Right reserved.

Kibella is not a free software. The Kibella software is NOT licensed under the "Apache License". 
If you are interested in distributing, reselling, modifying, contibuting or in general creating 
any derivative work from Kibella, please contact Frank Vanden Berghen at frank@timi.eu.
*/
namespace kibella; require_once "functionsaux.php"; function l37($O2h,$O37) { if (!is_array($O2h) || count($O2h) == 0) { user_error( "The input parameter is not an array or is empty ($O2h)\n" ,E_USER_ERROR); return NULL; } else if ($O37<0 || $O37>=count($O2h)) { error( "The index to extract from the array is out of range ($O37 while size of array is count($O2h))\n" ,E_USER_ERROR); return NULL; } return $O2h[$O37]; } function l38($O38) { $l39=strtotime($O38)-strtotime("00:00"); $O39=time()-strtotime("00:00"); if ($l39<=$O39) { $l3a=strtotime($O38); } else { $l3a=strtotime($O38)-0250600; } return $l3a; } function O3a($l3b) { $date=date_create(strftime("%Y-%m-%d %H:%M:%S",$l3b)); $O3b=(array) $date; $l3c=timezone_offset_get(new \datetimezone($date->timezone),$date); return $l3b-$l3c; } function O3c($l3d,$timezone="UTC") { $O3d=array("s" => "second","m" => "minute","h" => "hour","d" => "day","w" => "week","M" => "month","y" => "year"); $l3e="/^((now)|([\\d\\/-:\\s]+)\\|\\|)([-+])(\\d+)([smhdwMy]{1})\\w*\\/*([smhdwMy])*/"; preg_match($l3e,$l3d,$O3e); if (count($O3e)>0) { assert(count($O3e)>=7,"The preg_match() array has at least 7 elements"); $date=date_create($O3e[2].$O3e[3]); if ($timezone !== NULL && $O3e[2] !== "now") { $date=date_create(strftime("%Y-%m-%d %H:%M:%S",date_timestamp_get($date)),new \datetimezone($timezone)); } $l3f=$O3e[4].$O3e[5]; $O3f=$O3e[6]; date_modify($date,"$l3f ".$O3d[$O3f]); $O3b=(array) $date; if (count($O3e)>=8) { $l3g=$O3e[7]; O3g($date,$l3g); } } else { if ($timezone !== NULL) { $date=date_create($l3d); $date=date_create(strftime("%Y-%m-%d %H:%M:%S",date_timestamp_get($date)),new \datetimezone($timezone)); } else { $date=date_create($l3d); } } return date_timestamp_get($date); } function O3g(&$l3h,$l3g) { switch ($l3g) { case ("s"): date_modify($l3h,strftime("%Y-%m-%d %H:%M:%S",strtotime($l3h->date))); break; case ("m"): date_modify($l3h,strftime("%Y-%m-%d %H:%M",strtotime($l3h->date)).":00"); break; case ("h"): date_modify($l3h,strftime("%Y-%m-%d %H",strtotime($l3h->date)).":00:00"); break; case ("d"): date_modify($l3h,strftime("%Y-%m-%d",strtotime($l3h->date))." 00:00:00"); break; case ("w"): date_modify($l3h,"last monday"); $O3b=(array) $l3h; date_modify($l3h,strftime("%Y-%m-%d",strtotime($l3h->date))." 00:00:00"); break; case ("M"): date_modify($l3h,"first day of this month"); $O3b=(array) $l3h; date_modify($l3h,strftime("%Y-%m-%d",strtotime($l3h->date))." 00:00:00"); break; case ("y"): date_modify($l3h,strftime("%Y",strtotime($l3h->date))."-01-01 00:00:00"); break; default : break; } $O3b=(array) $l3h; } function O3h($l3i) { $O3i=preg_grep("/^\\-/",array($l3i)); $l3j=count($O3i)>0; if ($l3j) $l3i=substr($l3i,1); $O3j=explode("-",$l3i,2); $l3k=$O3j[0]; if ($l3j) $l3k="-".$l3k; $O3k=""; if (count($O3j)>1) { $O3k=$O3j[1]; } return array($l3k,$O3k); } function l3l($O3l) { $l3m=FALSE; $O3m=filemtime($O3l); if (strtolower(CACHEMODE) === CACHEMODE_DAY) { $O38=CACHEDAYCHANGE; $l3a=l38($O38); if ($O3m<$l3a) { $l3m=TRUE; } } else if (time()-$O3m>CACHEHOURS*07020) { $l3m=TRUE; } return $l3m; } function l3n($l2g) { $l3m=FALSE; $l2g=trim($l2g); if (strlen($l2g)>0) { $l2g=preg_replace("/^(\\-|\\+)\\s*/","\$1",$l2g); if (!preg_match("/[^0123456789\\.\\-\\+]/",$l2g)) { if (preg_match("/^.+(\\-|\\+)+/",$l2g)) $l3m=FALSE; else if (preg_match("/^(\\-\\.)|(\\+\\.)/",$l2g) && preg_match("/\\.|\\-|\\+/",substr($l2g,2))) $l3m=FALSE; else if (preg_match_all("/\\./",$l2g)>1) $l3m=FALSE; else $l3m=TRUE; } } return $l3m; } function O3n($l3o,$O3o) { switch (( string) $l3o) { case (l19): $l3o=O19; break; case (O1c): if ($O3o == O1b) $l3o=O1j; break; case (O1m): if ($O3o == l1a) $l3o=O1a; else $l3o=l1g; break; default : break; } return $l3o; } function l3p($O3p,$l3q) { if ($O3p == $l3q) $O3q=""; else $O3q=","; return $O3q; } function l3r($O2l) { if ($O2l<=0) $O3r=""; else $O3r="LIMIT ".$O2l; return $O3r; }