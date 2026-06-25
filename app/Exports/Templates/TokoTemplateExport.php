<?php

namespace App\Exports\Templates;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TokoTemplateExport implements
    FromArray,
    WithHeadings,
    WithTitle,
    WithStyles,
    WithColumnWidths,
    WithEvents
{
    public function array(): array
    {
        return [
            [10, 15, 'A'],
            [11, '',  'B'],
            [12, 20, 'A'],
        ];
    }

    public function headings(): array
    {
        return [
            'kode_toko_baru',
            'kode_toko_lama',
            'area_sales',
        ];
    }

    public function title(): string
    {
        return 'Template Master Toko';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 15,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [

            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2563EB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();


                $sheet->getStyle('A1:C4')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FFD1D5DB'],
                        ],
                    ],
                ]);


                $sheet->getStyle('A2:C4')->applyFromArray([
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFEFCE8'],
                    ],
                ]);


                $sheet->setCellValue('A6', 'CATATAN:');
                $sheet->getStyle('A6')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFB45309']],
                ]);

                $sheet->setCellValue('A7', '1. Hapus baris contoh (baris 2-4) sebelum upload.');
                $sheet->setCellValue('A8', '2. kode_toko_baru wajib diisi dan harus unik.');
                $sheet->setCellValue('A9', '3. kode_toko_lama boleh dikosongkan.');
                $sheet->setCellValue('A10', '4. area_sales diisi dengan huruf area yang valid (contoh: A atau B).');


                $sheet->getStyle('A7:A10')->applyFromArray([
                    'font' => ['color' => ['argb' => 'FF6B7280'], 'size' => 10],
                ]);


                $sheet->freezePane('A2');
            },
        ];
    }
}
