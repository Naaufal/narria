<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="<?= base_url('uploads/profile/' . (session()->get('profile') ?? 'default.png')) ?>" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                <?= session()->get('user_name') ?? 'Guest' ?>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="features-profile.html" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="features-activities.html" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav><div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown">
      <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="<?= base_url('uploads/profile/' . (session()->get('profile') ?? 'default.png')) ?>" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">
          <?= session()->get('user_name') ? session()->get('user_name') : 'Guest' ?>
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <?php if(session()->get('user_name')): ?>
          <a href="features-profile.html" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
          </a>
          <a href="features-activities.html" class="dropdown-item has-icon">
            <i class="fas fa-bolt"></i> Activities
          </a>
          <a href="features-settings.html" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Settings
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item has-icon text-danger" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        <?php else: ?>
          <a href="<?= base_url('login') ?>" class="dropdown-item has-icon">
            <i class="fas fa-sign-in-alt"></i> Login
          </a>
        <?php endif; ?>
      </div>
    </li>
  </ul>
</nav>