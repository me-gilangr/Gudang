<nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
  <div class="container">
    <a href="{{ route('main') }}" class="navbar-brand">
      <img src="{{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    
    <button class="navbar-toggler order-2" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">Contact</a>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="#" class="dropdown-item">Some action </a></li>
            <li><a href="#" class="dropdown-item">Some other action</a></li>

            <li class="dropdown-divider"></li>

            <li class="dropdown-submenu dropdown-hover">
              <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
              <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                <li>
                  <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                </li>

                <li class="dropdown-submenu">
                  <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                  <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                    <li><a href="#" class="dropdown-item">3rd level</a></li>
                    <li><a href="#" class="dropdown-item">3rd level</a></li>
                  </ul>
                </li>

                <li><a href="#" class="dropdown-item">level 2</a></li>
                <li><a href="#" class="dropdown-item">level 2</a></li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>

      <form class="form-inline ml-0 ml-md-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <a href="{{ route('admin.main') }}" class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </a>
          </div>
        </div>
      </form>
    </div> 
  </div>
</nav>