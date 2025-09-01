<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
    var Toast=Swal.mixin({toast:true,position:'top-end',showConfirmButton:false,timer:3000});var SwalDelete=Swal.mixin({icon:'warning',showCancelButton:true,confirmButtonText:"Padam",cancelButtonText:"Kembali",allowOutsideClick:false});function saa_alert(icon,text,title=null,timer=null,timerProgressBar=false){if(title==null||title==''){title=icon.charAt(0).toUpperCase()+icon.substring(1)+'!';}if(timer!=null){Swal.fire({title:title,text:text,icon:icon,timer:timer,timerProgressBar:timerProgressBar});}else Swal.fire(title,text,icon);}function saa_error(){Swal.fire('Oops...',"Ralat berlaku, sila cuba semula",'error')}function saa_cancelled(){Swal.fire("Dibatalkan","Tindakan anda telah dibatalkan",'error')}function sat_alert(icon,title){Toast.fire({icon:icon,title:title})}
    @foreach (['st_success', 'st_info', 'st_warning', 'st_error'] as $key)
        @if (session()->has($key))
            $(function () {
                Toast.fire({
                    icon: "{{ str_replace('st_', '', $key) }}",
                    title: "{{ session()->get($key) }}"
                });
            });
        @endif
    @endforeach
    @foreach (['sa_success', 'sa_info', 'sa_warning', 'sa_error'] as $key)
        @if (session()->has($key))
            $(function () {
                Swal.fire(
                    @switch($key)
                        @case('sa_success')
                            "Berjaya!"
                            @break
                        @case('sa_info')
                            "Info!"
                            @break
                        @case('sa_warning')
                            "Amaran!"
                            @break
                        @case('sa_error')
                            "Ralat!"
                            @break
                    @endswitch,
                    "{{ session()->get($key) }}",
                    "{{ str_replace('sa_', '', $key) }}"
                );
            });
        @endif
    @endforeach
</script>
