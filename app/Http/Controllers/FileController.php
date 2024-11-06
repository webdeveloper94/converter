<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\TextRun;
use App\Exports\ConvertedFileExport;

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
        $data = Excel::toArray([], $file);
        $sheet = $data[0];

        foreach ($sheet as &$row) {
            foreach ($row as &$value) {
                $value = $this->convertText($value, $conversionType);
            }
        }

        $convertedFileName = 'converted_file_' . time() . '.xlsx';
        $convertedFilePath = 'public/converted_files/' . $convertedFileName;

        Excel::store(new ConvertedFileExport($sheet), $convertedFilePath);

        $downloadLink = url('storage/converted_files/' . $convertedFileName);

        return redirect()->back()->with('success', 'Excel fayli muvaffaqiyatli konvertatsiya qilindi.')
                             ->with('download_link', $downloadLink)
                             ->with('auto_download', true);
    }

    private function processWord($file, $conversionType)
    {
        $phpWord = IOFactory::load($file);
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof TextRun) {
                    $text .= $element->getText();
                }
            }
        }

        $convertedText = $this->convertText($text, $conversionType);

        $convertedFileName = 'converted_file_' . time() . '.txt';
        $convertedFilePath = 'public/converted_files/' . $convertedFileName;

        file_put_contents(storage_path('app/' . $convertedFilePath), $convertedText);

        $downloadLink = url('storage/converted_files/' . $convertedFileName);

        return redirect()->back()->with('success', 'Word fayli muvaffaqiyatli konvertatsiya qilindi.')
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
        
            // Additions for o', g', and h (apostrophes)
            "o'" => 'ў', "g'" => 'ғ', "h'" => 'ҳ', 'q' => 'қ',
            // Uppercase versions
            "O'" => 'Ў', "G'" => 'Ғ', 'Q' => 'Қ'
        ];
        
        $cyrillicToLatin = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'yo', 'ж' => 'j', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'x', 'ц' => 'ts', 'ч' => 'ch',
            'ш' => 'sh', 'ю' => 'yu', 'я' => 'ya', 'е' => 'e', 'ъ'=>'\'',
            'э' => 'e',
            
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
            'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'J', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
            'У' => 'U', 'Ф' => 'F', 'Х' => 'X', 'Ц' => 'TS', 'Ч' => 'CH',
            'Ш' => 'SH', 'Ю' => 'YU', 'Я' => 'YA', 'Э' => 'E', 'Ъ' => "'",
        
            // Additions for o', g', and h (apostrophes)
            'ў' => "o'", 'ғ' => "g'", 'ҳ' => "h'", 'қ' => 'q',
            // Uppercase versions
            'Ў' => "O'", 'Ғ' => "G'", 'Ҳ' => "H" , 'Қ' => 'Q'
        ];

        if ($conversionType === 'latin_to_cyrillic') {
            return strtr($text, $latinToCyrillic);
        } else {
            return strtr($text, $cyrillicToLatin);
        }
    }
}
