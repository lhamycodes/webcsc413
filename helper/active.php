<?php
function active($currentPage)
{
    $bn = basename($_SERVER['PHP_SELF']);
    if ($bn == $currentPage) {
        echo 'active';
    }
}
