<?php
function _autoload_($classname) {
    $path = str_replace("\\", "/", DIR.$classname).".php";
    include_once($path);
}


function config( $key )
{
    $data = require (DIR. "Src/config/config.php");

    $key = str_replace('.', '"]["',$key);

    eval("\$cnf = \$data[\"$key\"];");

    return $cnf;
}

function timeAgo( $date )
{
    $date = new DateTime( $date );
    $now = new DateTime();
    $interval = $now->diff($date);

    $int = explode( ":", $interval->format('%a:%h:%i'));
    $intp = explode( ":", $interval->format('%ad :%hh :%im'));

    for ($i = 0; $i < 3; $i++ ){if($int[$i])echo $intp[$i];}
}