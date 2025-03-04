<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class NumberExtractorService
{



    public function extractNumbersFromCsv(string $filePath): array
    {
        $numbers = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                foreach ($data as $value) {
                    // Ensure it's numeric and handle missing leading zero
                    $value = preg_replace('/\D/', '', $value); // Remove non-numeric characters

                    if (strlen($value) == 10) {
                        $value = '0' . $value; // Prepend 0 if it's 10 digits
                    }

                    if (strlen($value) == 11 && str_starts_with($value, '0')) {
                        $numbers[] = $value;
                    }
                }
            }
            fclose($handle);
        }

        return array_unique($numbers);
    }

    public function extractNumbersFromExcel(string $filePath): array
    {
        $numbers = [];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->toArray() as $row) {
            foreach ($row as $value) {
                if (!empty($value)) {
                    $value = preg_replace('/\D/', '', $value); // Remove non-numeric characters

                    if (strlen($value) == 10) {
                        $value = '0' . $value; // Prepend 0 if it's 10 digits
                    }

                    if (strlen($value) == 11 && str_starts_with($value, '0')) {
                        $numbers[] = $value;
                    }
                }
            }
        }

        return array_unique($numbers);
    }



    public function extractNumbersAsJson(string $filePath, string $extension): string
    {
        $numbers = [];
        if ($extension === 'csv') {
            $numbers = $this->extractNumbersFromCsv($filePath);
        } elseif (in_array($extension, ['xls', 'xlsx'])) {
            $numbers = $this->extractNumbersFromExcel($filePath);
        }

        // Ensure the numbers are unique before encoding them to JSON
        $uniqueNumbers = array_unique($numbers);

        return json_encode($uniqueNumbers);
    }
}
