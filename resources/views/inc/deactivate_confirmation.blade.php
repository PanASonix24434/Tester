<form id="form-deactivate-item" method="POST" action="#">
    @method('PUT')
    @csrf
</form>
<script type="text/javascript">
    $(document).on('click','.button-deactivate',function(e){e.preventDefault();var url = $(this).data('url');var text = $(this).data('text');Swal.fire({title:"Adakah anda pasti?",text:text,icon:'warning',showCancelButton:true,confirmButtonText:"Nyahaktifkan",cancelButtonText:"Kembali",allowOutsideClick:false}).then((result) => {if(result.isConfirmed){$('#form-deactivate-item').attr('action',url).submit();}});});
</script>
