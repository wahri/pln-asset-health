  <div class="sidebar-wrapper" data-simplebar="true">
      <div class="sidebar-header">
          <div>
              <img src="assets/images/logo_pln2.png" class="logo-icon" alt="logo icon" />
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
          <li class="menu-label">Health Report</li>
          <li>
              <a href="javascript:;" class="">
                  <div class="parent-icon"><i class="bx bx-spa"></i></div>
                  <div class="menu-title">Report Overview</div>
              </a>
          </li>
          <li>
              <a href="widgets.html">
                  <div class="parent-icon">
                      <i class="bx bx-briefcase-alt-2"></i>
                  </div>
                  <div class="menu-title">Asset Health Report</div>
              </a>
          </li>
          <li class="menu-label">Master Data</li>
            <li class="{{ request()->routeIs('system-engine.index') ? 'mm-active' : '' }}">
              <a href="{{ route('system-engine.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-command"></i></div>
                  <div class="menu-title">System Engine</div>
              </a>
          </li>
           <li class="{{ request()->routeIs('asset.index') ? 'mm-active' : '' }}">
              <a href="{{ route('asset.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-devices"></i></div>
                  <div class="menu-title">Asset</div>
              </a>
          </li>
          <li class="{{ request()->routeIs('unit-engine.index') ? 'mm-active' : '' }}">
              <a href="{{ route('unit-engine.index') }}" class="">
                  <div class="parent-icon"><i class="bx bx-laptop"></i></div>
                  <div class="menu-title">Unit Engine</div>
              </a>
          </li>
          <li class="{{ request()->routeIs('location-unit.index') ? 'mm-active' : '' }}">
              <a href="{{ route('location-unit.index') }}">
                  <div class="parent-icon">
                      <i class="bx bx-shape-polygon"></i>
                  </div>
                  <div class="menu-title">Location Unit</div>
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
