<?php
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    $url = $protocol.'://'.$_SERVER['HTTP_HOST'] . "/meedoen/oirschot-vooruit";

    header("Location: $url");