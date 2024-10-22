  <header>
      <div class="topbar d-flex align-items-center">
          <nav class="gap-3 navbar navbar-expand">
              <div class="mobile-toggle-menu"><i class="bx bx-menu"></i></div>
              <div class="top-menu ms-auto">
                  <ul class="gap-1 navbar-nav align-items-center">
                      <li class="nav-item dark-mode d-none d-sm-flex">
                          <a class="nav-link dark-mode-icon" href="javascript:;"><i class="bx bx-moon"></i>
                          </a>
                      </li>
                  </ul>
              </div>
              <div class="px-3 user-box dropdown">
                  <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                      role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="{{ asset('assets/images/avatars/avatar-2.png')}} "class="user-img" alt="user avatar" />
                      <div class="user-info ps-3">
                          <p class="mb-0 user-name">{{ Auth::user()->name ?? 'Login' }}</p>
                          <p class="mb-0 designattion">IT Support</p>
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
                          <div class="mb-0 dropdown-divider"></div>
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
