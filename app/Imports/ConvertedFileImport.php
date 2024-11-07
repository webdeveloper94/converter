<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;

class ConvertedFileImport implements ToArray
{
    protected $conversionType;

    public function __construct($conversionType)
    {
        $this->conversionType = $conversionType;
    }

    public function array(array $array)
    {
        // Fayldagi ma'lumotlarni o'zgartirish
        foreach ($array as &$row) {
            foreach ($row as &$value) {
                $value = $this->convertText($value, $this->conversionType);
            }
        }

        return $array;
    }

    private function convertText($value, $conversionType)
    {
        // Burada sizning matnni konvertatsiya qilish logikangiz bo'lishi kerak
        // Misol uchun, lotindan kirilga yoki kirildan lotinga o'zgartirish
        if ($conversionType === 'latin_to_cyrillic') {
            return $this->convertLatinToCyrillic($value);
        } elseif ($conversionType === 'cyrillic_to_latin') {
            return $this->convertCyrillicToLatin($value);
        }
        return $value;
    }

    private function convertLatinToCyrillic($text)
    {
        // Lotin harflaridan Kirilga o'zgartirish logikasi
        // Misol uchun:
        $conversionMap = [
            'a' => 'а', 'b' => 'б', 'v' => 'в', // va boshqalar
        ];
        return strtr($text, $conversionMap);
    }

    private function convertCyrillicToLatin($text)
    {
        // Kiril harflaridan Lotinga o'zgartirish logikasi
        // Misol uchun:
        $conversionMap = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', // va boshqalar
        ];
        return strtr($text, $conversionMap);
    }
}
