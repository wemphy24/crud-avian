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

class TransaksiTemplateExport implements
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
            [1, 1500.00],
            [2, 2000.50],
        ];
    }

    public function headings(): array
    {
        return ['kode_toko', 'nominal_transaksi'];
    }

    public function title(): string
    {
        return 'Template Transaksi';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 22,
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

                $sheet->getStyle('A1:B3')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FFD1D5DB'],
                        ],
                    ],
                ]);

                $sheet->getStyle('A2:B3')->applyFromArray([
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFFEFCE8'],
                    ],
                ]);

                $sheet->setCellValue('A5', 'CATATAN:');
                $sheet->getStyle('A5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFB45309']],
                ]);

                $sheet->setCellValue('A6', '1. Hapus baris contoh (baris 2-3) sebelum upload.');
                $sheet->setCellValue('A7', '2. kode_toko wajib ada di data master toko.');
                $sheet->setCellValue('A8', '3. nominal_transaksi maksimal 999999.99.');
                $sheet->setCellValue('A9', '4. nominal_transaksi gunakan titik (.) sebagai desimal.');

                $sheet->getStyle('A6:A9')->applyFromArray([
                    'font' => ['color' => ['argb' => 'FF6B7280'], 'size' => 10],
                ]);

                $sheet->freezePane('A2');
            },
        ];
    }
}
