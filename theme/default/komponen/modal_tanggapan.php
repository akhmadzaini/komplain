<style>
  .stars {
    margin: 20px 0;
    font-size: 24px;
    color: #d17581;
  }
</style>
<div class="modal fade" id="modal-tanggapan" style="display: none;">
  <div class="modal-dialog">
    
    <form action="" id="frm-tanggapan">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Tanggapan Penanganan Komplain</h4>
        </div>

        <div class="modal-body">  
          <div class="alert alert-info">
            Luangkan sejenak waktu anda untuk memberikan tanggapan dan penilaian terhadap penanganan komplain ini. 
            Tanggapan anda sangat berharga bagi unit dalam rangka peningkatan kualitas pelayanan.
          </div>
          <div class="box box-primary">
            <div class="box-body">
              
              <div class="form-group">
                <div class="text-center">
                  <input type="hidden" name="id_komplain" id="id_komplain" value="">
                  <input type="hidden" name="rating" id="ratingsField" value="" required="">
                  <div class="stars starrr" data-rating="0"></div>
                </div>
              </div>

              <div class="form-group">
                <textarea class="form-control" id="isi-tanggapan" name="isi_tanggapan" placeholder="Tulis tanggapan anda disini (max. 150 Karakter)" rows="3" maxlength="150" required=""></textarea>
              </div>


            </div>
            <!-- /.box-body -->
    
            <div class="overlay" style="display: none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
            <!-- /.overlay -->
    
          </div>
          <!--/.box-primary-->
        </div>
        <!--/.modal-body-->


        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-flat btn-primary btn-ajukan">Tanggapi</button>
        </div>
      </div>
      <!-- /.modal-content -->

    </form>
  </div>
  <!-- /.modal-dialog -->
</div>

<script>

var __slice=[].slice;(function(e,t){var n;n=function(){function t(t,n){var r,i,s,o=this;this.options=e.extend({},this.defaults,n);this.$el=t;s=this.defaults;for(r in s){i=s[r];if(this.$el.data(r)!=null){this.options[r]=this.$el.data(r)}}this.createStars();this.syncRating();this.$el.on("mouseover.starrr","span",function(e){return o.syncRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("mouseout.starrr",function(){return o.syncRating()});this.$el.on("click.starrr","span",function(e){return o.setRating(o.$el.find("span").index(e.currentTarget)+1)});this.$el.on("starrr:change",this.options.change)}t.prototype.defaults={rating:void 0,numStars:4,change:function(e,t){}};t.prototype.createStars=function(){var e,t,n;n=[];for(e=1,t=this.options.numStars;1<=t?e<=t:e>=t;1<=t?e++:e--){n.push(this.$el.append("<span class='glyphicon .glyphicon-star-empty'></span>"))}return n};t.prototype.setRating=function(e){if(this.options.rating===e){e=void 0}this.options.rating=e;this.syncRating();return this.$el.trigger("starrr:change",e)};t.prototype.syncRating=function(e){var t,n,r,i;e||(e=this.options.rating);if(e){for(t=n=0,i=e-1;0<=i?n<=i:n>=i;t=0<=i?++n:--n){this.$el.find("span").eq(t).removeClass("glyphicon-star-empty").addClass("glyphicon-star")}}if(e&&e<5){for(t=r=e;e<=4?r<=4:r>=4;t=e<=4?++r:--r){this.$el.find("span").eq(t).removeClass("glyphicon-star").addClass("glyphicon-star-empty")}}if(!e){return this.$el.find("span").removeClass("glyphicon-star").addClass("glyphicon-star-empty")}};return t}();return e.fn.extend({starrr:function(){var t,r;r=arguments[0],t=2<=arguments.length?__slice.call(arguments,1):[];return this.each(function(){var i;i=e(this).data("star-rating");if(!i){e(this).data("star-rating",i=new n(e(this),r))}if(typeof r==="string"){return i[r].apply(i,t)}})}})})(window.jQuery,window);$(function(){return $(".starrr").starrr()});

  $(function(){

    $(document).on('click', '.btn-tanggapan', function(e){
      $('#modal-tanggapan').modal('show');
      $('#id_komplain').val($(this).data('id'));
    });

    $(document).on('submit', '#frm-tanggapan', function(e){
      $('.overlay').show();
      e.preventDefault();
      var data = $(this).serialize();
      // console.log(data);
      var url = "<?=site_url('json/tanggapi_komplain')?>";
      $.post(url, data, function(hasil){
        $('.overlay').hide();
        if(hasil.affected_rows > 0){
          $('#frm-filter').trigger('submit');
          alert('Terima kasih, tanggapan anda telah terekam dalam database kami.');
          $('#modal-tanggapan').modal('hide');
        }
        // console.log(hasil);
      });
    });

    $('.starrr').on('starrr:change', function(e, value){
      $('#ratingsField').val(value);
    });    

  });
</script>