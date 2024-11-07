<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\Element\TextRun;
use App\Exports\ConvertedFileExport;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;
use PhpOffice\PhpWord\IOFactory;
//use PhpOffice\PhpWord\PhpWord;

class FileController extends Controller
{
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,docx',
            'conversion_type' => 'required|in:latin_to_cyrillic,cyrillic_to_latin',
        ]);

        $file = $request->file('file');
        $conversionType = $request->input('conversion_type');

        $extension = $file->getClientOriginalExtension();

        if ($extension === 'xlsx' || $extension === 'xls') {
            return $this->processExcel($file, $conversionType);
        } elseif ($extension === 'docx') {
            return $this->processWord($file, $conversionType);
        }

        return response()->json(['error' => 'Fayl turi qo‘llab-quvvatlanmaydi. Faqat Excel va Word fayllarini yuklash mumkin.']);
    }

    private function processExcel($file, $conversionType)
    {
        $spreadsheet = SpreadsheetIOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $value = $cell->getValue();
                $convertedValue = $this->convertText($value, $conversionType);
                $cell->setValue($convertedValue);
            }
        }

        $convertedFileName = 'converted_file_' . time() . '.xlsx';
        $convertedFilePath = 'public/converted_files/' . $convertedFileName;

        $writer = SpreadsheetIOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save(storage_path('app/' . $convertedFilePath));

        $downloadLink = url('storage/converted_files/' . $convertedFileName);

        return redirect()->back()
            ->with('success', 'Fayl tayyor yuklab olishingiz mumkin')
            ->with('download_link', $downloadLink)
            ->with('auto_download', true);
    }

    private function processWord($file, $conversionType)
{
    $phpWord = IOFactory::load($file);
    $text = '';

    // Stil yaratish
    $fontStyle = ['name' => 'Arial', 'size' => 12, 'bold' => true];
    $paragraphStyle = ['align' => 'both'];

    // Har bir bo'limni tekshirib chiqamiz
    foreach ($phpWord->getSections() as $section) {
        foreach ($section->getElements() as $element) {
            // TextRun elementlaridan matnni olamiz
            if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                $text .= $element->getText();
            }
        }
    }

    // Matnni konvertatsiya qilish
    $convertedText = $this->convertText($text, $conversionType);

    // Yangi Word faylini yaratamiz
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Stilni saqlab matnni qo'shamiz
    $section->addText($convertedText, $fontStyle, $paragraphStyle);

    // Fayl nomini yaratish
    $convertedFileName = 'converted_file_' . time() . '.docx';
    $convertedFilePath = 'public/converted_files/' . $convertedFileName;

    // Konvertatsiya qilingan Word faylini saqlash
    $phpWord->save(storage_path('app/' . $convertedFilePath), 'Word2007');

    // Yuklab olish linkini yaratish
    $downloadLink = url('storage/converted_files/' . $convertedFileName);

    return redirect()->back()->with('success', 'Fayl tayyor yuklab olishingiz mumkin.')
                             ->with('download_link', $downloadLink)
                             ->with('auto_download', true);
}

    private function convertText($text, $conversionType)
    {
        $latinToCyrillic = [
            'a' => 'а', 'b' => 'б', 'v' => 'в', 'g' => 'г', 'd' => 'д',
            'e' => 'е', 'yo' => 'ё', 'j' => 'ж', 'z' => 'з', 'i' => 'и',
            'y' => 'й', 'k' => 'к', 'l' => 'л', 'm' => 'м', 'n' => 'н',
            'o' => 'о', 'p' => 'п', 'r' => 'р', 's' => 'с', 't' => 'т',
            'u' => 'у', 'f' => 'ф', 'h' => 'х', 'ts' => 'ц', 'ch' => 'ч',
            'sh' => 'ш', 'yu' => 'ю', 'ya' => 'я', 'e' => 'е',
            'A' => 'А', 'B' => 'Б', 'V' => 'В', 'G' => 'Г', 'D' => 'Д',
            'E' => 'Е', 'Yo' => 'Ё', 'J' => 'Ж', 'Z' => 'З', 'I' => 'И',
            'Y' => 'Й', 'K' => 'К', 'L' => 'Л', 'M' => 'М', 'N' => 'Н',
            'O' => 'О', 'P' => 'П', 'R' => 'Р', 'S' => 'С', 'T' => 'Т',
            'U' => 'У', 'F' => 'Ф', 'H' => 'Ҳ', 'Ts' => 'Ц', 'Ch' => 'Ч',
            'Sh' => 'Ш', 'Yu' => 'Ю', 'Ya' => 'Я', 'SH' => 'Ш',
            "o'" => 'ў', "g'" => 'ғ', "h'" => 'ҳ', 'q' => 'қ',
            "O'" => 'Ў', "G'" => 'Ғ', 'Q' => 'Қ', "'" => 'ъ'
        ];

        $cyrillicToLatin = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'j', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'x', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'ю' => 'yu', 'я' => 'ya', 'е' => 'e', 'ъ' => "'",
            'э' => 'e',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'J', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'X', 'Ц' => 'TS', 'Ч' => 'CH',
            'Ш' => 'SH', 'Ю' => 'YU', 'Я' => 'YA', 'Э' => 'E', 'Ъ' => "'",
            'ў' => "o'", 'ғ' => "g'", 'ҳ' => "h'", 'қ' => 'q',
            'Ў' => "O'", 'Ғ' => "G'", 'Ҳ' => "H", 'Қ' => 'Q'
        ];

        return $conversionType === 'latin_to_cyrillic' ? strtr($text, $latinToCyrillic) : strtr($text, $cyrillicToLatin);
    }
}
