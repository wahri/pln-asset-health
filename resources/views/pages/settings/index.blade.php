@extends('layouts.main')
@section('content')
 
    <div class="page-content">
        <!--breadcrumb-->
       <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Settings</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <!-- Home Icon and Link -->
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.index') }}">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>
                <!-- Settings Page -->
                <li class="breadcrumb-item">
                    <a href="javascript:;">Account Settings</a>
                </li>
                <!-- Active Page: Change Email & Password -->
                <li class="breadcrumb-item active" aria-current="page">
                    Change Email & Password
                </li>
            </ol>
        </nav>
    </div>
</div>

        <!--end breadcrumb-->

        <hr />
       
       <div class="card border-top border-0 border-4 border-primary">
  <div class="card-body p-5">
    <div class="card-title d-flex align-items-center">
      <div><i class="bx bxs-user me-1 font-22 text-primary"></i></div>
      <h5 class="mb-0 text-primary">Change Email & Password</h5>
    </div>
    <hr>
   <form action="{{ route('settings.updateAccount') }}" class="row g-3" method="POST">
  @csrf
  <!-- Input Email -->
  <div class="col-md-12">
    <label for="inputEmail" class="form-label">New Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" name="email" placeholder="Enter your new email" value="{{ old('email', Auth::user()->email) }}" required>
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <!-- Input Password Baru -->
  <div class="col-md-6">
    <label for="inputPassword" class="form-label">New Password</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" name="password" placeholder="Enter new password" required>
    @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <!-- Konfirmasi Password Baru -->
  <div class="col-md-6">
    <label for="confirmPassword" class="form-label">Confirm New Password</label>
    <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" placeholder="Confirm new password" required>
  </div>

  <!-- Tombol submit -->
  <div class="col-12">
    <button type="submit" class="btn btn-primary px-5">Update Account</button>
  </div>

  <!-- Display success message -->
  @if(session('success'))
    <div class="alert alert-success mt-3">
      {{ session('success') }}
    </div>
  @endif
</form>

  </div>
</div>

    </div>
@endsection



