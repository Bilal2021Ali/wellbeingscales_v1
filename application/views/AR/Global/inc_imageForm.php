<style>
#yourBtn {
     font-family: calibri;
     padding: 10px;
     -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
     border: 1px dashed #BBB;
     text-align: center;
     background-color: #DDD;
     cursor: pointer;
     height: 50px;
     width: 100%;
     border: 1px dashed #BBB;
     cursor: pointer;
     /* direction: ltr; */
     display: block;
     background: #fbfbfb;
     padding: 15px;
}
</style>
<h6 class="text-primary" style="position: relative;top: -33px;" id="Toast">
قم بتحديث الصورة الرمزية الخاصة بك
 </h6>
<h5 class="font-size-15 mt-3" style="position: relative;top: -42px;margin: 0px;">
     الملفات المسموح بها (.png، .jpg، .gif)
</h5>
<form id="AddPhoto">
     <div id="yourBtn" onclick="getFile()">إختر ملف</div>
     <input type="file" name="file" id="upfile" placeholder="Choose Your New Avatar" class="form-control d-none">    
     <div class="mt-3 text-right">
          <button class="btn btn-primary w-sm waves-effect waves-light btn-block" type="Submit" id="sub"> تحديث </button>
     </div>
</form> 
<script>
$( "#AddPhoto" ).on( 'submit', function ( e ) {
     var Templatur = $('input[name="Result"]').val();
     console.log(Templatur);    
     e.preventDefault();
     $.ajax( {
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/users/UpladeImgs',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function ( data ) {
               $( '#Toast' ).html( data );
               $( '#sub' ).removeAttr('disabled');
               $( '#sub' ).html('Submit !');
          },
          beforeSend : function(){
               $( '#sub' ).attr('disabled','');
               $( '#sub' ).html('Please wait.');
          },
          ajaxError: function () {
               $( '#Toast' ).css( 'background-color', '#DB0404' );
               $( '#Toast' ).html( "oops!! لدينا خطأ حالي" );
          }
     } );
} );
function getFile(){
     document.getElementById("upfile").click();
}
</script>