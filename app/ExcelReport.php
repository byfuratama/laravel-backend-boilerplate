<?php
namespace App;

// use DB;
use Illuminate\Support\Facades\Storage;
use alhimik1986\PhpExcelTemplator\PhpExcelTemplator;
use alhimik1986\PhpExcelTemplator\params\ExcelParam;
use alhimik1986\PhpExcelTemplator\setters\CellSetterStringValue;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValue;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArray2DValue;
use alhimik1986\PhpExcelTemplator\params\CallbackParam;
use alhimik1986\PhpExcelTemplator\setters\CellSetterArrayValueSpecial;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\IOFactory;

define('SPECIAL_ARRAY_TYPE', CellSetterArrayValueSpecial::class);

class ExcelReport
{  

    // public static function sample($inputs) {
    //     extract($inputs);
    //     $templatePath = "app/excel/template_file.xlsx";

    //     $templateFile = storage_path($templatePath);
    //     $fileName = storage_path("app/excel/exported_file.xlsxx");
    //     $params = [
    //         '{one}' => $one ?? '', // one time only
    //         '[vertical]' => new ExcelParam(SPECIAL_ARRAY_TYPE, $vertical ?? ['']),
    //         '[verticalwStyle]' => new ExcelParam(CellSetterArrayValue::class, $verticalwStyle ?? ['KETERANGAN'], function(CallbackParam $param) {
    //             $sheet = $param->sheet;
    //             $row_index = $param->row_index;
    //             $cell_coordinate = $param->coordinate;
    //             $amount = $param->param[$row_index];
    //             if (substr($amount,0,1) != "-") {
    //                 $sheet->getStyle($cell_coordinate)->getFont()->setBold(true);
    //             }
    //         }),
    //     ];
    
    //     $events = [
    //         PhpExcelTemplator::BEFORE_SAVE => function(Spreadsheet $spreadsheet) use($separator) {
    //             $separator = $separator[0] + 3;
    //             $coor1 = "A" . $separator;
    //             $coor2 = "H" . $separator;
    //             $spreadsheet->getActiveSheet()->getStyle($coor1 . ':' . $coor2)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);  
    //         },
    //     ];
        
    //     PhpExcelTemplator::outputToFile($templateFile, $fileName, $params, [], $events);
    //   }

}