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

    <div class="notif">
    </div>
    
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Pilihan Filter Data</h3>
      </div>
      <div class="box-body">
        <form action="" id="frm-filter">

          
          <div class="form-group">
            
            <input type="hidden" name="pemohon" value="<?=$this->session->login?>">

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
            <label>Unit : </label>
            <?=combo_unit()?>
          </div>
          
          <button type="submit" class="btn btn-flat btn-primary"><i class="fa fa-filter"></i> Lihat data</button>
        </form>
      </div>
      <!-- /.box-body -->

      <div class="overlay" style="display: none;">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
      <!-- /.overlay -->


    </div>
    <!-- /.box -->
    
  	<div class="box box-primary">
  		<div class="box-header with-border">
  			<h3 class="box-title">Daftar komplain</h3>
  		</div>
  		<div class="box-body">
  			<table class="table table-hover" id="table-status">
  				<thead>
  					<tr>
              <th>No.</th>              
  						<th>Unit</th>
              <th>Kategori</th>
  						<th>Tgl. Komplain</th>
  						<th>Status</th>
  						<th>Tindakan</th>
  					</tr>
  				</thead>
  				<tbody>
  				</tbody>
  			</table>
  		</div>
      <!-- /.box-body -->
      
      <div class="overlay" style="display: none;">
        <i class="fa fa-refresh fa-spin"></i>
      </div>
      <!-- /.overlay -->

  	</div>
  	<!-- /.box -->
  </section>
</div>

<?php $this->load->view('umum/footer')?>