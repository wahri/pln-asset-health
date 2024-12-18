<table>
    <thead>
        <tr>
            <th>Lokasi</th>
            <th>Unit</th>
            <th>No Asset</th>
            <th>Nama Asset</th>
            <th>Group Asset</th>
            <th>Status</th>
            <th>No SR</th>
            <th>No WO</th>
            <th>Tanggal Identifikasi</th>
            <th>Status WO</th>
            <th>Kondisi Asset</th>
            <th>Action Plan</th>
            <th>Target Selesai</th>
            <th>Progres Saat Ini</th>
            <th>Realisasi Selesai</th>
            <th>Main Issue</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportAsset as $ra)
            @if ($ra->detailReports->count() > 0)
                @foreach ($ra->detailReports as $key => $detail)
                    <tr>
                        @if ($key === 0)
                            <td rowspan="{{ $ra->detailReports->count() }}">{{ $ra->unit->location->name }}</td>
                            <td rowspan="{{ $ra->detailReports->count() }}">{{ $ra->unit->name }}</td>
                            <td rowspan="{{ $ra->detailReports->count() }}">{{ $ra->asset->no_asset }}</td>
                            <td rowspan="{{ $ra->detailReports->count() }}">{{ $ra->asset->name }}</td>
                            <td rowspan="{{ $ra->detailReports->count() }}">{{ $ra->asset->assetGroup->name }}</td>
                            <td style="font-weight: bolder" rowspan="{{ $ra->detailReports->count() }}">
                                {{ $ra->status }}</td>
                        @endif
                        <td>{{ $detail->no_sr }}</td>
                        <td>{{ $detail->no_wo }}</td>
                        <td>{{ $detail->tanggal_identifikasi }}</td>
                        <td>{{ $detail->status_sr }}</td>
                        <td>{{ $detail->kondisi_asset }}</td>
                        <td>{{ $detail->action_plan }}</td>
                        <td>{{ $detail->target_selesai }}</td>
                        <td>{{ $detail->progress_saat_ini }}</td>
                        <td>{{ $detail->realisasi_selesai }}</td>
                        <td>{{ $detail->issue }}</td>
                        <td>{{ $detail->keterangan }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{{ $ra->unit->location->name }}</td>
                    <td>{{ $ra->unit->name }}</td>
                    <td>{{ $ra->asset->no_asset }}</td>
                    <td>{{ $ra->asset->name }}</td>
                    <td>{{ $ra->asset->assetGroup->name }}</td>
                    <td style="font-weight: bolder">{{ $ra->status }}</td>
                    <td colspan="11"></td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
