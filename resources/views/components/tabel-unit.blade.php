 <h1>unit</h1>

 <table class="table mt-4">
     <thead>
         <tr>
             <th scope="col">#</th>
             <th scope="col">System</th>
             <th scope="col">No Asset</th>
             <th scope="col">Equipment</th>
             <th>Status</th>
         </tr>
     </thead>
     <tbody>
         @foreach ($unit as $u)
             <tr>
                 <th scope="row">{{ $loop->iteration }}</th>
                 <td>{{ $u['system'] }}</td>
                 <td>{{ $u['noAsset'] }}</td>
                 <td>{{ $u['equipment'] }}</td>
                 <td>{{ $u['status'] }}</td>
             </tr>
         @endforeach


     </tbody>
 </table>
