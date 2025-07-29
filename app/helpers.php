<?php
function RefgenerateCode($table, $init, $key)
{
    $latest = $table::orderBy('id', 'desc')->first();
    if (!$latest) {
        $code = $init . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(10, 99);
        return $code;
    }

    $string = preg_replace("/[^0-9\.]/", '', $latest->$key);
    $code = $init . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(10, 99);
    return $code;
} 

function Refgenerate($table,$init,$key)
{
    $latest = $table::latest()->first();
    if (! $latest) {
        return $init.'-00001';
    }

    $string = preg_replace("/[^0-9\.]/", '', $latest->$key);

    return $init.'-' . sprintf('%05d',$string+1);
}