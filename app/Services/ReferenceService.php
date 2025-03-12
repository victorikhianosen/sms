<?php

namespace App\Services;

use Illuminate\Support\Str;

class ReferenceService
{
    public function generateReference($data)
    {
        $adminID = $data['id'];
        $firstTwoFirstName = strtoupper(substr($data->first_name, 0, 1));
        $firstTwoLastName = strtoupper(substr($data->last_name, 0, 1));
        $uniqueNumber = Str::uuid()->toString();
        return "{$uniqueNumber}/{$adminID}{$firstTwoFirstName}{$firstTwoLastName}";
    }
}
