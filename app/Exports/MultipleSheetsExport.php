<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;

class MultipleSheetsExport implements WithMultipleSheets
{

    protected $bulan;
    protected $lokasi;
    protected $overview;
    protected $unit;
    protected $detailWarnings;
    protected $detailFaults;
    protected $namaUnit;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($bulan, $lokasi, $overview, $unit, $detailWarnings, $detailFaults, $namaUnit)
    {
        $this->bulan = $bulan;
        $this->lokasi = $lokasi;
        $this->overview = $overview;
        $this->unit = $unit;
        $this->detailWarnings = $detailWarnings;
        $this->detailFaults = $detailFaults;
        $this->namaUnit = $namaUnit;
    }

    public function sheets(): array
    {
        return [
            'overview' =>
            new OverviewSheetExport($this->overview),
            'detailWarning' =>
            new WarningSheetExport($this->detailWarnings),
            'detailFault' =>
            new FaultSheetExport($this->detailFaults),
            'unit' =>
            new UnitSheetExport($this->unit),

        ];
    }
}
