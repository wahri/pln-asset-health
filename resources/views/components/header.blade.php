  <header>
      <div class="topbar d-flex align-items-center">
          <nav class="navbar navbar-expand gap-3">
              <div class="mobile-toggle-menu"><i class="bx bx-menu"></i></div>
              <div class="top-menu ms-auto">
                  <ul class="navbar-nav align-items-center gap-1">
                      <li class="nav-item dark-mode d-none d-sm-flex">
                          <a class="nav-link dark-mode-icon" href="javascript:;"><i class="bx bx-moon"></i>
                          </a>
                      </li>
                  </ul>
              </div>
              <div class="user-box dropdown px-3">
                  <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                      role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="{{ asset('assets/images/avatars/avatar-2.png')}} "class="user-img" alt="user avatar" />
                      <div class="user-info ps-3">
                          <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                          <p class="designattion mb-0">IT Support</p>
                      </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item" href="javascript:;"><i
                                  class="bx bx-user"></i><span>Profile</span></a>
                      </li>
                      <li>
                          <a class="dropdown-item" href="javascript:;"><i
                                  class="bx bx-cog"></i><span>Settings</span></a>
                      </li>
                      <li>
                          <div class="dropdown-divider mb-0"></div>
                      </li>
                      <li>
                          <form action="{{ route('logout') }}" method="post">
							@csrf
							
                              <button type="submit" class="dropdown-item">
                                  <i class="bx bx-log-out-circle"></i>

                                  <span>Logout</span></button>
                          </form>

                      </li>
                  </ul>
              </div>
          </nav>
      </div>
  </header>
