<?php $uri = service('uri'); ?>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?=site_url('author/dashboard')?>">Narria</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?=site_url('author/dashboard')?>">NR</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="<?= ($uri->getSegment(2) == 'dashboard') ? 'active' : '' ?>">
        <a href="<?=site_url('author/dashboard')?>" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <li class="dropdown <?= (in_array($uri->getSegment(2), ['users', 'novels', 'categories', 'chapters'])) ? 'active' : '' ?>">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i> <span>Data</span></a>
        <ul class="dropdown-menu">
          <li class="<?= ($uri->getSegment(2) == 'novels') ? 'active' : '' ?>">
            <a href="<?=site_url('author/novels')?>">Novel</a>
          </li> 
          <li class="<?= ($uri->getSegment(2) == 'categories') ? 'active' : '' ?>">
            <a href="<?=site_url('author/categories')?>">Category</a>
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