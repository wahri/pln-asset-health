<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;

class MultipleSheetsExport implements WithMultipleSheets
{

    protected $bulan;
    protected $lokasi;
    protected $unit;
    protected $detailWarnings;
    protected $detailFaults;
    protected $namaUnit;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($bulan, $lokasi, $unit, $detailWarnings, $detailFaults, $namaUnit)
    {
        $this->bulan = $bulan;
        $this->lokasi = $lokasi;
        $this->unit = $unit;
        $this->detailWarnings = $detailWarnings;
        $this->detailFaults = $detailFaults;
        $this->namaUnit = $namaUnit;
    }
    public function sheets(): array
    {
        return [
            'unit' =>
            new UnitSheetExport($this->unit),
            'detailWarning' =>
            new WarningSheetExport($this->detailWarnings),
            'detailFault' =>
            new FaultSheetExport($this->detailFaults),

        ];
    }
}
