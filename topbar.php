    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
      <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand waves-effect" href="./">
          <strong class="blue-text">Library Management System</strong>
        </a>

        <!-- Collapse -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="navbar-nav mr-auto"></div>
          <!-- Left -->
          <!-- <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link waves-effect" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul> -->

          <!-- Right -->
          <ul class="navbar-nav nav-flex-icons">
            <li class="nav-item">
            <a href="ajax.php?action=logout" class="text-dark" style="cursor:pointer"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
            </li>
          </ul>

        </div>

      </div>
    </nav>