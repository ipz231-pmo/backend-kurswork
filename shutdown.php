<?php

register_shutdown_function(function () {
    $error = error_get_last();
    $code = http_response_code();
    
    if ($error >= 400) {
        echo "<div> Error $code</div>";
    }
});