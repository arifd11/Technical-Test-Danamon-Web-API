<?php

use App\Models\Menu;
use App\Models\User;
use App\Models\Setting;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


if (!function_exists('validateKey')) {
    function validateKey($key)
    {
        $isValid = DB::table('keys')->where('api_key', $key)->first();
        return ($isValid == null) ? false : true;
    }
}

if (!function_exists('isValidJsonFields')) {
    function isValidJsonFields($data, $fields)
    {
        $valid = true;
        foreach ($data as $key => $value) {
            if (!in_array($key, $fields)) {
                $valid = false;
            }
        }
        return $valid;
    }
}

if (!function_exists('validMimeType')) {
    function validMimeType($type)
    {
        $types = ["image/jpeg", "image/jpg", "image/png", "application/pdf", "text/csv", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/msexcel", "application/x-msexcel", "application/x-ms-excel", "application/x-excel", "application/x-dos_ms_excel", "application/xls", "application/x-xls", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
        $valid = true;
        if (!in_array($type, $types)) {
            $valid = false;
        }
        return $valid;
    }
}

if (!function_exists('validImageMimeType')) {
    function validImageMimeType($type)
    {
        $types = ["image/jpeg", "image/jpg", "image/png"];
        $valid = true;
        if (!in_array($type, $types)) {
            $valid = false;
        }
        return $valid;
    }
}
