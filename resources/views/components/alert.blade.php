 @if (session('success'))
     <div class="alert alert-info border-0 bg-info alert-dismissible fade show">
         <div class="text-dark"> {{ session('success') }}</div>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
 @elseif(session('error'))
     <div class="alert alert-warning border-0 bg-warning alert-dismissible fade show">
         <div class="text-dark"> {{ session('error') }}</div>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
 @endif

 
 @if (session('messages'))
 <div class="row">
     <div class="col-12">
         <div class="alert alert-warning alert-dismissible fade show" role="alert">
             @foreach (session('messages') as $message)
                 <strong>{{ $message }}</strong>
             @endforeach
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
     </div>
 </div>
@endif

