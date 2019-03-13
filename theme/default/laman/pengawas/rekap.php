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

    <div class="row">
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
              
              <button type="button" class="btn btn-flat btn-primary btn-cetak"><i class="fa fa-print"></i> Cetak data</button>
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

  </section>
</div>

<?php $this->load->view('umum/footer')?>