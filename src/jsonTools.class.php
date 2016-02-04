<?php

/**
 * Clase de herramientas b&aacute;sicas para JSON
 * Created by: braren
 * Date: 03/02/16
 * Time: 23:55
 */
class jsonTools
{
    function __construct()
    {
    }

    function sortByDate($json)
    {
        $ltsData = json_decode(json_encode($json), true);

        usort($ltsData, function ($a, $b) {
            return strtotime($b['release_date']) - strtotime($a['release_date']);
        });

        return $ltsData;
    }
}