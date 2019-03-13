<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="height: auto;">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <!--
      <div class="pull-left image">
        <img src="<?=base_url()?>/theme/default/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
      </div>
      -->
      <div class="pull-left">
        <p><?=$this->session->nama?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu tree" data-widget="tree">
      <li class="header">NAVIGASI UTAMA</li>
      
      <li>
        <a href="<?=site_url('dashboard')?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <li class="treeview">
        <a href=""><i class="fa fa-book"></i> <span>Komplain Saya</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="<?=site_url('komplain/pengajuan')?>"><i class="fa fa-child"></i> Pengajuan</a></li>
          <?php if($this->session->jenis == 'doskar'): ?>
          <li><a href="<?=site_url('komplain/status')?>"><i class="fa fa-check-circle-o"></i> Status dan Tanggapan</a></li>
          <?php endif ?>
        </ul>
      </li>
  
      <?php if($this->session->jenis == 'doskar'): ?>
        <?php if($this->session->akses == 2): ?>
          <li><a href="<?=site_url('respon')?>"><i class="fa fa-bolt"></i> Respon</a></li>
          <li><a href="<?=site_url('respon/mhs')?>"><i class="fa fa-graduation-cap"></i> Komplain Mhs</a></li>
        <?php endif?>
        <?php if($this->session->akses== 1): ?>
          <li class="treeview">
            <a href=""><i class="fa fa-area-chart"></i> <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?=site_url('pengawas')?>"> Komplain Doskar</a></li>
              <li><a href="<?=site_url('pengawas/mhs')?>"> Komplain Mahasiswa</a></li>
              <li><a href="<?=site_url('pengawas/rekap')?>"> Rekapitulasi</a></li>
            </ul>
          </li>

          <li class="treeview">
            <a href=""><i class="fa fa-gears"></i> <span>Pengaturan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?=site_url('pengaturan/unit')?>"> Unit</a></li>
              <li><a href="<?=site_url('pengaturan/pengawas')?>"> Pengawas</a></li>
            </ul>
          </li>

        <?php endif ?>
      <?php endif ?>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>