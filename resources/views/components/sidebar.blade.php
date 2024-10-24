  <div class="sidebar-wrapper" data-simplebar="true">
      <div class="sidebar-header">
          <div>
              <img src="{{ asset('assets/images/logo_pln2.png') }}" class="logo-icon" alt="logo icon" />
          </div>
          <div>
              <h4 class="logo-text">PLN</h4>
          </div>
          <div class="toggle-icon ms-auto">
              <i class="bx bx-first-page"></i>
          </div>
      </div>
      <!--navigation-->
      <ul class="metismenu" id="menu">
          <li class="{{ request()->routeIs('dashboard.*') ? 'mm-active' : '' }}">
              <a href="{{ route('dashboard.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-home"></i></div>
                  <div class="menu-title">Dashboard</div>
              </a>
          </li>

          {{-- <li class="{{ request()->routeIs('assetHealthReport.*') ? 'mm-active' : '' }}">
              <a href="{{ route('assetHealthReport.index') }}" class="">
                  <div class="parent-icon">
                      <i class="bx bx-briefcase-alt-2"></i>
                  </div>
                  <div class="menu-title">Asset Health Report</div>
              </a>
          </li> --}}

          <li class="{{ request()->routeIs('assetHealthReport.*') ? 'mm-active' : '' }}">
              <a class="has-arrow" href="javascript:;" aria-expanded="false">
                  <div class="parent-icon"><i class="bx bxs-report"></i>
                  </div>
                  <div class="menu-title">Report</div>
              </a>
              <ul class="mm-collapse">
                  <li class="{{ request()->routeIs('assetHealthReport.*') ? 'mm-active' : '' }}">
                   <a href="{{ route('assetHealthReport.index') }}"><i class="bx bx-briefcase-alt-2"></i>Asset Health Report</a>
                  </li>
                   <li class="{{ request()->routeIs('assetHealthReport.assetReport.*') ? 'mm-active' : '' }}"> <a href="{{ route('assetHealthReport.assetReport.index') }}"><i class=" bx bx-cylinder"></i>Asset Report</a>
                  </li>
                 
              </ul>
          </li>
          <li class="{{ request()->routeIs('assetManagement.*') ? 'mm-active' : '' }}">
              <a href="{{ route('assetManagement.location.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-command"></i></div>
                  <div class="menu-title">Asset Management</div>
              </a>
          </li>


          <li {{ request()->routeIs('settings.*') ? 'mm-active' : '' }}>
              <a href="{{ route('settings.index') }}">
                  <div class="parent-icon">
                      <i class="bx bx-cog"></i>
                  </div>
                  <div class="menu-title">Settings</div>
              </a>
          </li>
      </ul>
      <!--end navigation-->
  </div>
