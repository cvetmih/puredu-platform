<?php

use Illuminate\Support\Facades\File;

function svg($path)
{
    $fullPath = public_path($path);
    return File::exists($fullPath) ? File::get($fullPath) : '!!!' . $fullPath . '!!!';
}

function format_money($value, $prefix = '$', $suffix = '')
{
    return $prefix . number_format($value, 2) . $suffix;
}
