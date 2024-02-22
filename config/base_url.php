<?php
function base_url($url = null)
{
    $base_url = 'http://10.29.254.234/gis/petaQ';
    if ($url != null) {
        # code...
        return $base_url . '/' . $url;
    } else {
        return $base_url;
    }
}
