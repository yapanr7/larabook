<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($value)
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    function rupiah($value)
    {
        return number_format($value, 0, ',', '.');
    }
}

?>
