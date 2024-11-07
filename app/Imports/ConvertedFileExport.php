<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Sheet;

class ConvertedFileExport implements FromArray, WithStyles, WithProperties
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    // Excelning stillarini saqlash
    public function styles(Sheet $sheet)
    {
        return [
            // Ushbu qismda stil sozlamalarini saqlashingiz mumkin
            // Misol: 1-qatordagi barcha hujayralar uchun stil
            1    => ['font' => ['bold' => true]],
            'A'  => ['font' => ['italic' => true]],
        ];
    }

    // Faylning xususiyatlarini saqlash
    public function properties(): array
    {
        return [
            'creator'        => 'Your Name',
            'lastModifiedBy' => 'Your Name',
            'title'          => 'Converted Excel File',
            'subject'        => 'Conversion',
            'description'    => 'Converted from Latin to Cyrillic and vice versa.',
            'keywords'       => 'conversion, excel',
            'category'       => 'Conversion',
            'manager'        => 'Your Name',
        ];
    }
}
