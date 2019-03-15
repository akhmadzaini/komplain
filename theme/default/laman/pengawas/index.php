<?php $this->load->view('umum/header')?>
<?php $this->load->view('umum/nav')?>
<?php $this->load->view('umum/sidebar')?>
<div class="content-wrapper" style="min-height: 1126px;">
  <!-- Content   Header (Page header) -->
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

    <div class="row hidden-print" >
      <div class="col-md-12">    
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Pilihan Filter Data</h3>
          </div>

          <div class="box-body">
            <form action="" id="frm-filter">

              <div class="form-group">
                <label>Rentang waktu :</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control tgl-range" name="tgl">
                </div>
                <!-- /.input group -->
              </div>

              <div class="form-group">
                <label for="">Unit : </label>
                <?=combo_unit()?>  
              </div>
              
              <button type="submit" class="btn btn-flat btn-primary"><i class="fa fa-filter"></i> Lihat data</button>
              <button type="button" class="btn btn-flat btn-default btn-cetak"><i class="fa fa-print"></i> Cetak data</button>
            </form>
          </div>
            <!-- /.box-body -->

          <div class="overlay" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
          <!-- /.overlay -->
        </div>
        <!-- /.box -->
      </div>


       <!-- /.box --> 
    </div>
    
    <div class="row hidden-print" >
      <div class="col-xs-3">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><span id="summTotalKomplain">...</span></h3>

            <p>Total Komplain</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-xs-3">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><span id="summKomplainTerbuka">...</span></h3>

            <p>Terbuka</p>
          </div>
          <div class="icon">
            <i class="fa fa-folder-open"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-xs-3">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><span id="summKomplainProses">...</span></h3>

            <p>Dalam Proses</p>
          </div>
          <div class="icon">
            <i class="fa fa-hourglass-2"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-xs-3">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><span id="summKomplainTertutup">...</span></h3>

            <p>Tertutup</p>
          </div>
          <div class="icon">
            <i class="fa fa-check-circle"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>    

    <div class="row">
      <div id="areaGrafik"></div>
    </div>

  </section>
</div>

<?php $this->load->view('umum/footer')?>