 <h1>detail Warning</h1>

 <table class="table mt-4">
     <thead>
         <tr>
             <th scope="col">#</th>
             <th scope="col">Unit Pembangkit</th>
             <th scope="col">No Asset</th>
             <th scope="col">No SR</th>
             <th scope="col">No WO</th>
             <th scope="col">Tanggal Identifikasi</th>
             <th scope="col">Status Saat ini</th>
             <th scope="col">Kondisi Asset</th>
             <th scope="col">Action Plan</th>
             <th scope="col">Target Selesai</th>
             <th scope="col">Progres Saat Ini</th>
             <th scope="col">Realisasi Selesai</th>
             <th scope="col">Main Issue / Kendala</th>
             <th scope="col">Keterangan</th>
         </tr>
     </thead>
     <tbody>
        @foreach($detailWarnings as $d)
         <tr>
             <th scope="row">{{ $loop->iteration }}</th>
             <td>{{ $d['unit'] }}</td>
             <td>{{ $d['noAsset'] }}</td>
             <td>{{ $d['noSR'] }}</td>
             <td>{{ $d['noWO'] }}</td>
             <td>{{ $d['tanggalIdentifikasi'] }}</td>
             <td>{{ $d['statusSaatIni'] }}</td>
             <td>{{ $d['kondisiAsset'] }}</td>
             <td>{{ $d['actionPlan'] }}</td>
             <td>{{ $d['targetSelesai'] }}</td>
             <td>{{ $d['progresSaatIni'] }}</td>
             <td>{{ $d['realisasiSelesai'] }}</td>
             <td>{{ $d['issue'] }}</td>
             <td>{{ $d['keterangan'] }}</td>
         </tr>
         @endforeach
        
     </tbody>
 </table>
