<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ConvertedFileExport implements FromArray
{
    // Faylni eksport qilish uchun kerakli ma'lumotlarni olish
    protected $data;

    // Konstruktor orqali ma'lumotlarni olish
    public function __construct($data)
    {
        $this->data = $data;
    }

    // `FromArray` interfeysidan keladigan `array()` metodini yozish
    public function array(): array
    {
        return $this->data;
    }
}
