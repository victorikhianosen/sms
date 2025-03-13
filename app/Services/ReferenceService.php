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

    public function referenceWithDetails($data)
    {
        $adminID = $data['id'];
        $firstCharFirstName = strtoupper(substr($data['first_name'], 0, 1));
        $firstCharLastName = strtoupper(substr($data['last_name'], 0, 1));
        $randomLetters = Str::random(4);
        $randomNumbers = mt_rand(1000000, 9999999);

        return "{$randomLetters}{$randomNumbers}/{$adminID}{$firstCharFirstName}{$firstCharLastName}";
    }
}
