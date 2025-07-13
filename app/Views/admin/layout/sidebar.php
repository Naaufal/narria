<?php $uri = service('uri'); ?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?=site_url('admin/dashboard')?>">Narria</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?=site_url('admin/dashboard')?>">NR</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="<?= ($uri->getSegment(2) == 'dashboard') ? 'active' : '' ?>">
        <a href="<?=site_url('admin/dashboard')?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <li class="dropdown <?= (in_array($uri->getSegment(2), ['users', 'novels', 'categories'])) ? 'active' : '' ?>">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i> <span>Data</span></a>
        <ul class="dropdown-menu">
          <li class="<?= ($uri->getSegment(2) == 'users') ? 'active' : '' ?>">
            <a href="<?=site_url('admin/users') ?>">User</a>
          </li> 
          <li class="<?= ($uri->getSegment(2) == 'novels') ? 'active' : '' ?>">
            <a href="<?=site_url('admin/novels')?>">Novel</a>
          </li> 
          <li class="<?= ($uri->getSegment(2) == 'categories') ? 'active' : '' ?>">
            <a href="<?=site_url('admin/categories')?>">Category</a>
          </li> 
        </ul>
      </li>
      <li class="dropdown <?= (strpos($uri->getSegment(2), 'errors') !== false) ? 'active' : '' ?>">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-exclamation"></i> <span>Errors</span></a>
        <ul class="dropdown-menu">
          <li class="<?= ($uri->getPath() == 'errors-503.html') ? 'active' : '' ?>">
            <a class="nav-link" href="errors-503.html">503</a>
          </li> 
          <li class="<?= ($uri->getPath() == 'errors-403.html') ? 'active' : '' ?>">
            <a class="nav-link" href="errors-403.html">403</a>
          </li> 
          <li class="<?= ($uri->getPath() == 'errors-404.html') ? 'active' : '' ?>">
            <a class="nav-link" href="errors-404.html">404</a>
          </li> 
          <li class="<?= ($uri->getPath() == 'errors-500.html') ? 'active' : '' ?>">
            <a class="nav-link" href="errors-500.html">500</a>
          </li> 
        </ul>
      </li>
    </ul>

    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
      <a href="/" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <i class="fas fa-rocket"></i> Homepage
      </a>
    </div>        
  </aside>
</div>

<div class="main-content">
  <section class="section">