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
          <li class="{{ request()->routeIs('dashboard.index') ? 'mm-active' : '' }}">
              <a href="{{ route('dashboard.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-home"></i></div>
                  <div class="menu-title">Dashboard</div>
              </a>
          </li>
         
          <li class="{{ request()->routeIs('assetHealthReport.index') ? 'mm-active' : '' }}">
              <a href="{{ route('assetHealthReport.index') }}" class="">
                  <div class="parent-icon">
                      <i class="bx bx-briefcase-alt-2"></i>
                  </div>
                  <div class="menu-title">Asset Health Report</div>
              </a>
          </li>
            <li class="{{ request()->routeIs('assetManagement.*') ? 'mm-active' : '' }}">
              <a href="{{ route('assetManagement.location.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-command"></i></div>
                  <div class="menu-title">Asset Management</div>
              </a>
          </li>
          
          <li>
              <a href="widgets.html">
                  <div class="parent-icon">
                      <i class="bx bx-cog"></i>
                  </div>
                  <div class="menu-title">Settings</div>
              </a>
          </li>
      </ul>
      <!--end navigation-->
  </div>
