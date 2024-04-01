<script src="{{ asset('admin/assets/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/bundles/vendorscripts.bundle.js') }}"></script>

<!-- page vendor js file -->
<script src="{{ asset('admin/assets/bundles/c3.bundle.js') }}"></script>

<!-- page js file -->
<script src="{{ asset('admin/assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('js/realestate/index.js') }}"></script>


<script src="{{ asset('admin/assets/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{ asset('js/pages/ui/dialogs.js') }}"></script>



<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="https://cdn.ckeditor.com/4.20.0/basic/ckeditor.js"></script>

{{-- CDN Only --}}
<script src="{{asset('admin@old/js/lib/jquery-validation/dist/jquery.validate.js')}}"></script>
<script src="{{asset('admin@old/js/lib/jquery-validation/dist/additional-methods.min.js')}}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ \env('GOOGLEMAPKEY', 'AIzaSyAD4BpB9s-G7fG1NqWBSspuapE1gpCWC5M') }}&v=3.exp&libraries=places,drawing"></script>
<script src="{{ asset('admin@old/js/autocompletemap.js') }}"></script>
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
    // $(document).ready( function () {
    //     $('#myTable').DataTable({searching: true});
    // } );
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
            title: '{{__("Are you sure want to logout ?")}}',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: '{{__("Cancel")}}',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{__("Logout")}}'
            }).then((result) => {
            if (result.isConfirmed) {
                location.href="{{route('vendor.logout')}}";
            }
            })
    })
    $('.delete').on('click',function(e){
        e.preventDefault();
        let id = $(this).attr('data-url');
        Swal.fire({
            title: '{{__("Are you sure want to delete ?")}}',
            text: "",
            icon: 'Warning',
            showCancelButton: true,
            cancelButtonText: '{{__("Cancel")}}',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{__("Delete")}}'
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
    $('.paymentConfirm').on('click',function(){
        Swal.fire({
            title: "{{__('Subscription not available.Want to take subscription')}}",
            text: "",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: '{{__("Cancel")}}',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{__('Yes Continue')}}"
            }).then((result) => {
            if (result.isConfirmed) {
                location.href="{{route('vendor.initiat')}}";
            }
            })
    })

</script>

