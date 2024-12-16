<table>
    <thead>
        <tr>
            <th>Status</th>
            <th>System</th>
            <th>Asset</th>
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
        @foreach ($assets as $ra)
            @foreach ($ra->reportAssets as $item)
                @foreach ($item->detailReports as $index => $detail)
                    <tr>
                        @if ($loop->first)
                            @if ($item->status == 'normal')
                                <td style="font-weight: bolder" rowspan="{{ $item->detailReports->count() }}">{{ $item->status }}
                                </td>
                            @elseif($item->status == 'abnormal')
                                <td style="font-weight: bolder" rowspan="{{ $item->detailReports->count() }}">
                                    {{ $item->status }}</td>
                            @else
                                <td style="font-weight: bolder" rowspan="{{ $item->detailReports->count() }}">{{ $item->status }}
                                </td>
                            @endif

                            <td rowspan="{{ $item->detailReports->count() }}">{{ $ra->assetGroup->name }}</td>
                            <td rowspan="{{ $item->detailReports->count() }}">{{ $ra->name }}</td>
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
            @endforeach
        @endforeach
    </tbody>
</table>
