<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class NumberExtractorService
{
    /**
     * Extract numbers from a CSV file, filter out non-11-digit numbers, and ensure uniqueness.
     */
    public function extractNumbersFromCsv(string $filePath): array
    {
        $numbers = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                foreach ($data as $value) {
                    // Ensure the value is numeric and exactly 11 digits
                    if (is_numeric($value) && strlen($value) == 11) {
                        $numbers[] = $value;
                    }
                }
            }
            fclose($handle);
        }

        // Ensure the numbers are unique
        return array_unique($numbers);
    }

    /**
     * Extract numbers from an Excel file, filter out non-11-digit numbers, and ensure uniqueness.
     */
    public function extractNumbersFromExcel(string $filePath): array
    {
        $numbers = [];
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->toArray() as $row) {
            foreach ($row as $value) {
                // Ensure the value is numeric and exactly 11 digits
                if (is_numeric($value) && strlen($value) == 11) {
                    $numbers[] = $value;
                }
            }
        }

        // Ensure the numbers are unique
        return array_unique($numbers);
    }

    /**
     * Determine the file type, extract numbers, and return them as a JSON-encoded string.
     */
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
