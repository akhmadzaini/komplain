
<?php $this->load->view('umum/header')?>
<?php $this->load->view('umum/nav')?>
<style>
  /* FROM HTTP://WWW.GETBOOTSTRAP.COM
   * Glyphicons
   *
   * Special styles for displaying the icons and their classes in the docs.
   */

  .bs-glyphicons {
    padding-left: 0;
    padding-bottom: 1px;
    margin-bottom: 20px;
    list-style: none;
    overflow: hidden;
  }

  .bs-glyphicons li {
    float: left;
    width: 25%;
    height: 115px;
    padding: 10px;
    margin: 0 -1px -1px 0;
    font-size: 12px;
    line-height: 1.4;
    text-align: center;
    border: 1px solid #ddd;
  }

  .bs-glyphicons .glyphicon {
    margin-top: 5px;
    margin-bottom: 10px;
    font-size: 24px;
  }

  .bs-glyphicons .glyphicon-class {
    display: block;
    text-align: center;
    word-wrap: break-word; /* Help out IE10+ with class names */
  }

  .bs-glyphicons li:hover {
    background-color: rgba(86, 61, 124, .1);
  }

  @media (min-width: 768px) {
    .bs-glyphicons li {
      width: 12.5%;
    }
  }
</style>
<?php $this->load->view('umum/sidebar')?>

<div class="content-wrapper" style="min-height: 1126px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?=$judul?>
    </h1>
  
    <!--berubah-->
    <ol class="breadcrumb">
      <?=$breadcrumb?>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Pilih salah satu unit kerja</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <?=tombol_unit_all()?>
      </div>
      <!-- /.box-body -->

      <div class="overlay" style="display: none;">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
      <!-- /.overlay -->
    </div>
    <!-- /.box -->
    
    <?php if(!empty($komponen)) {$this->load->view('komponen/'.$komponen);}?>

  </section>
  <!-- /.content -->
</div>


<?php $this->load->view('umum/footer')?>