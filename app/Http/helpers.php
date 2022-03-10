<?php
function format_money($value, $prefix = '$', $suffix = '')
{
    return $prefix . number_format($value, 0) . $suffix;
}
