<script src="{{asset('admin/js/lib/jquery.min.js')}}"></script>
<script src="{{asset('admin/js/lib/jquery.nanoscroller.min.js')}}"></script>
<!-- nano scroller -->
<script src="{{asset('admin/js/lib/menubar/sidebar.js')}}"></script>
<script src="{{asset('admin/js/lib/preloader/pace.min.js')}}"></script>
<!-- sidebar -->

<script src="{{asset('admin/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/scripts.js')}}"></script>
<!-- bootstrap -->

<script src="{{asset('admin/js/lib/calendar-2/moment.latest.min.js')}}"></script>
<script src="{{asset('admin/js/lib/calendar-2/pignose.calendar.min.js')}}"></script>
<script src="{{asset('admin/js/lib/calendar-2/pignose.init.js')}}"></script>


<script src="{{asset('admin/js/lib/weather/jquery.simpleWeather.min.js')}}"></script>
<script src="{{asset('admin/js/lib/weather/weather-init.js')}}"></script>
<script src="{{asset('admin/js/lib/circle-progress/circle-progress.min.js')}}"></script>
<script src="{{asset('admin/js/lib/circle-progress/circle-progress-init.js')}}"></script>
<script src="{{asset('admin/js/lib/chartist/chartist.min.js')}}"></script>
<script src="{{asset('admin/js/lib/sparklinechart/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('admin/js/lib/sparklinechart/sparkline.init.js')}}"></script>
<script src="{{asset('admin/js/lib/owl-carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('admin/js/lib/owl-carousel/owl.carousel-init.js')}}"></script>
{{-- <script src="{{asset('admin/js/lib/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('admin/js/lib/sweetalert/sweetalert.init.js')}}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- scripit init-->
<script src="{{asset('admin/js/dashboard2.js')}}"></script>
<script src="{{asset('admin/js/lib/jquery-validation/dist/jquery.validate.js')}}"></script>
<script src="{{asset('admin/js/lib/jquery-validation/dist/additional-methods.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.20.0/basic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- CDN Only --}}
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ \env('GOOGLEMAPKEY', 'AIzaSyAD4BpB9s-G7fG1NqWBSspuapE1gpCWC5M') }}&v=3.exp&libraries=places,drawing"></script>
<script src="{{ asset('admin/js/autocompletemap.js') }}"></script>
<script>
    $(document).ready(function() {
        toastr.options.timeOut = 1000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });

</script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable({searching: false});
    } );
</script>
<script>
    function selectFirstAddress (input) {
        google.maps.event.trigger(input, 'keydown', {keyCode:40});
        google.maps.event.trigger(input, 'keydown', {keyCode:13});
    }

    // Select first address on focusout
    $('#address').on('focusout', function() {
        selectFirstAddress(this);
    });

    // Select first address on enter in input
    // $('#address').on('keydown', function(e) {
    //     if (e.keyCode == 13) {
    //         selectFirstAddress(this);
    //     }
    // });
</script>
<script>
    $('.logout').on('click',function(){
        Swal.fire({
            title: 'Are you sure want to logout ?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Logout'
            }).then((result) => {
            if (result.isConfirmed) {
                location.href="{{route('logout')}}";
            }
            })
    })
    $('.delete').on('click',function(e){
        e.preventDefault();
        let id = $(this).attr('data-url');
        Swal.fire({
            title: 'Are you sure want to delete ?',
            text: "",
            icon: 'Warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Delete'
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = id;
            }
            })
    })
// document.querySelector(".logout").onclick = function () {
//     Swal(
//         {
//         title: "Are you sure want to logout ?",
//         text: "",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         closeOnConfirm: false,
//         confirmButtonText: "Logout",
//         },
//         function () {
//             location.href="{{route('logout')}}";
//         }
//     );
// };


</script>
