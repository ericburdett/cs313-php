<?php
function emptyToNull($string) {
    if (is_string($string) && strlen($string) == 0) {
        $string = NULL;
    }
    return $string;
}
?>