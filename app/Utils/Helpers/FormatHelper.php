<?php

if (!function_exists('rupiah')) {
    function rupiah($number)
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }
}

if (!function_exists('tanggal')) {
    function tanggal_dan_waktu($datetime)
    {
        return date('d F Y H:i:s', strtotime($datetime));
    }
}
