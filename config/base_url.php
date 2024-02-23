<?php
function base_url($url = null)
{
    $base_url = 'http://localhost/sig-kalselteng';
    if ($url != null) {
        # code...
        return $base_url . '/' . $url;
    } else {
        return $base_url;
    }
}
