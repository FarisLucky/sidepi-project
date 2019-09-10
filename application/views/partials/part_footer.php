<footer class="footer">
  <div class="container-fluid clearfix">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
      <a href="http://www.bootstrapdash.com/" target="_blank">Sidepi</a>. All rights reserved.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Sidepi Team 8:
      <i class="mdi mdi-heart text-danger"></i>
    </span>



    <!-- Batas Footer -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
</footer>

<script src="<?= base_url() ?>assets/custom/js/jquery-3.4.1.min.js"></script>
<!-- End Jquery -->
<script src="<?= base_url() ?>assets/vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url() ?>assets/vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="<?= base_url() ?>assets/js/off-canvas.js"></script>
<script src="<?= base_url() ?>assets/js/misc.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/custom/DataTables/datatables.min.js"></script>
<!-- Sweet ALert -->
<script src="<?= base_url() ?>assets/custom/sweetalert/sweetalert2.all.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>assets/custom/toastr/toastr.min.js"></script>
<!-- CKEditor -->
<script src="<?= base_url() ?>assets/library/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/custom/select2/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>assets/custom/lightbox2-11/js/lightbox.min.js"></script>
<!-- endinject -->
<script>
$(document).ready(function() {
  $(".overlay").hide();
  $(".select-opt").select2({
    placeholder: '-- Pilih Options --',
    width: 'element'
  });
  $('.datepicker').datepicker({
    format: 'mm/dd/yyyy',
  });
  $.ajax( {
      url: base + 'dashboard/get_time',
      success: function( dataResponse ) {
          time = dataResponse;
      },
      type: 'GET'
  } );

  function getNewMsgs() {
    $.ajax( {
        url: base + 'dashboard/get_new_msgs',
        type: 'POST',
        // send the time
        data: { time: time,id_tkn: csrf_val },
        success: function( dataResponse ) {
            try {
              dataRs = JSON.parse( dataResponse );
              // update the time
              time = dataRs.time;
              // show the new messages
              console.log(dataResponse);
              dataResponse.msgs.forEach( function( msg ) {
                  console.log( msg );
              } );
              // repeat
              setTimeout( function() {
                  getNewMsgs();
              }, 1000 );
            } catch( e ) {
                // may fail is the connection is lost/timeout for example, so dataResponse
                // is not a valid json string, in this situation you can start this process again
            }
        }
    } );
  }

  getNewMsgs();
});
</script>
<!-- End custom js for this page-->
<script src="<?= base_url().'assets/custom/js/indexing.js' ?>"></script>
<!-- End custom js for this page-->

</body>

</html>