<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Excel;

class SedekahExport implements ShouldAutoSize, FromCollection, WithStyles, WithMapping, WithHeadings, Responsable
{
    use Exportable;

    protected $sedekah;

    public function __construct(object $sedekah)
    {
        $this->sedekah = $sedekah;
    }

    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'sedekah.xlsx';
    
    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;
    
    /**
    * Optional headers
    */
    private $headers = [
        'Content-Type' => 'text/plain',
    ];

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }

    public function collection()
    {
        return $this->sedekah;
    }

    public function map($sedekah): array
    {
        return [
            $sedekah->user->nik,
            $sedekah->user->nama,
            $sedekah->user->jenkel,
            $sedekah->user->telp,
            $sedekah->tanggal,
            $sedekah->jumlah,
            $sedekah->harga,
            $sedekah->harga * $sedekah->jumlah,
            $sedekah->keterangan,
            $sedekah->user->alamat,
            $sedekah->penjemputan->petugas->nama,
            $sedekah->penjemputan->petugas->telp,
            $sedekah->penjemputan->tanggal,
            $sedekah->penjemputan->berangkat,
            $sedekah->penjemputan->sampai
        ];
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Jenis_Kelamin',
            'No. Telepon',
            'Tanggal',
            'Jumlah Mijel',
            'Harga',
            'Jumlah Menabung',
            'Keterangan',
            'Alamat',
            'Petugas',
            'No. Telepon',
            'Tanggal Jemput',
            'Berangkat',
            'Sampai'
        ];
    }

}
