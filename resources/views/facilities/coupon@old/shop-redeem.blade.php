@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Management')
@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            {{-- <h1>Hello, <span>Welcome Here</span></h1> --}}
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Apply Coupon</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>
            <!-- /# row -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h4>Apply Coupon</h4>

                            </div>
                            <div class="card-body mt-3">
                                <div class="basic-form">
                                    <form action="{{route('coupon.onShopRedeemCreate')}}" id="myform" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label>Choose User By Name</label>
                                            <select name="user_id" id="userId" class="form-control js-example-basic-single userId">
                                                <option value="" disabled hidden selected></option>
                                                @foreach($users as $key=>$value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Enter Coupon</label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" name="coupon" class="form-control" id="coupon">
                                                    <input type="hidden" name="coupon_id" id="couponId">
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-primary" type="button" id="apply">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="append">

                                        </div>
                                        <button type="submit" class="btn btn-default mt-4">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
    $('#apply').on('click',function(){
        var coupon=$('#coupon').val();
        var userId=$('#userId').val();
        if(coupon && userId){
            $.ajax({
                type: 'get',
                url: "{{ route('coupon.checkCoupon') }}",
                data: {coupon:coupon,user_id:userId},
                success: function (response) {
                    if(response.status==false){
                        Swal.fire('Error!',response.message);
                    }
                    if(response.status==true){
                        var html=`<input type="hidden" name="coupon_id" value="`+response.data1.id+`">`;
                        if(response.data1.offer_type=='amount'){
                            html +=`<div class="form-group">
                                        <label for="discount">Total Price (AED)</label>
                                        <input type="text" name="amount[0]" data-key="0" data-offer="amount" data-discount="`+response.data1.discount+`" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_0" placeholder="Enter Total Sum Amount" class="form-control percentage_amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id"></span></label><br>
                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id"></span></label>
                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                    </div>`;
                        }
                        if(response.data1.offer_type=='percentage'){
                            html +=`<div class="form-group">
                                        <label for="discount">Total Price</label>
                                        <input type="text" name="amount[0]" data-key="0" data-offer="percentage" data-discount="`+response.data1.discount+`" data-discount="`+response.data1.discount+`" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_0" placeholder="Enter Total Sum Amount" class="form-control percentage_amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id">0</span></label><br>
                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id">0</span></label>
                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                    </div>`;
                        }
                        if(response.data1.offer_type=='buy-get-percentage'){
                            if(response.data1.buy_items > 0){
                                    var i=0;
                                    for(i = 0;i < response.data1.buy_items; i++ ){
                                        var j = i+1;
                                        html += `<div class="form-group">
                                                <label for="discount">Item `+ j +` Price(AED)</label>
                                                <input type="text" name="amount[`+ i +`]" data-key="`+ i +`" data-offer="buy-get-percentage" data-discount="`+response.data1.discount+`" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_`+ i +`" placeholder="Enter Item `+ j +` Price(AED)" class="form-control percentage_amount">
                                            </div>`;
                                    }
                                    html +=`<div class="form-group">
                                                <label for="discount">Total Discount Amount : <span class="discount_amount_id">0</span></label><br>
                                                <label for="discount">Total Amount To Recieved: <span class="paid_amount_id">0</span></label>
                                                <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                                <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                                <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                            </div>`;
                            }
                        }
                        if(response.data1.offer_type=='buy-get'){
                            if(response.data1.buy_items>0){
                                var i=0;
                                for(i=0;i<response.data1.buy_items;i++){
                                    var k=i+1;
                                    html +=`<div class="form-group">
                                            <label for="discount">Buy Item `+k+` Price(AED)</label>
                                            <input type="text" name="amount[`+ i +`]" data-key="`+ i +`" onkeypress="myFunction()" data-offer="buy-get" data-discount="`+response.data1.discount+`" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_`+i+`" placeholder="Enter Item `+k+` Price(AED)" class="form-control percentage_amount">
                                        </div>`;
                                }
                            }
                            if(response.data1.free_items>0){
                                var j=0;
                                for(j=0; j < response.data1.free_items;j++){
                                    var l=j+1;
                                    html +=`<div class="form-group">
                                        <label for="discount">Get Item `+ l +` Price(AED)</label>
                                        <input type="text" name="amount_free[`+ j +`]" data-key="`+ j +`" data-offer="buy-get" data-discount="`+response.data1.discount+`" id="percentage_amount_free`+ j +`" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="Enter Item `+ l +` Price(AED)" class="form-control percentage_amount_free">
                                    </div>`;
                                }
                            }
                            html +=`<div class="form-group">
                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id">0</span></label><br>
                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id">0</span></label>
                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                    </div>`;
                        }
                        $('#append').html(html)
                    }

                },
                error:function() {
                    Swal.fire('error','Something went wrong');
                }
            });
        }
        if(!coupon && !userId){
            Swal.fire('error','Enter Coupon Code and Select User Name');
        }
        if(!coupon && userId){
            Swal.fire('error','Enter Coupon Code');
        }
        if(!userId && coupon){
            Swal.fire('error','Select User Name');
        }

    })
</script>
<script>
    {{--  $('#percentage_amount').keyup(function(){
        var amount=this.value;
        var discount = $(this).attr('data-discount');
        var dis=(discount*amount)/100;
        var paid=amount-dis;
        $('.discount_amount_id').text(dis);
        $('.paid_amount_id').text(paid);
        $('#discount_amount').val(dis);
    })
    $('#percentage_amount').keyup(function(){
        var amount=this.value;
        var discount = $(this).attr('data-discount');
        if(amount>=discount){

            var paid=amount-discount;
            $('.discount_amount_id').text(discount);
            $('.paid_amount_id').text(paid);
            $('#discount_amount').val(paid);
        }else{
            $('.discount_amount_id').text(0);
            $('.paid_amount_id').text();
            $('#discount_amount').val();
        }
    })
    $('#percentage_amount').blur(function(){
        var amount=this.value;
        var discount = $(this).attr('data-discount');
        console.log(discount)
        console.log(amount)
        if()
        if(amount < discount){
            Swal.fire('Total Sum Amount must be greater than Discount Amount');
        }
    })  --}}
    var amounts=[];
    var free_amount=[];
    var total_paid=0;
    var total_discount=0;
    var total_fee=0;
    $(document).on('keyup','.percentage_amount',function(){
        var key=$(this).attr('data-key')
        var offer_type=$(this).attr('data-offer')
        var amount1=$('#percentage_amount_'+key).val();
        if(amount1==''){
            amount1=0;
        }
        amount1=parseFloat(amount1);
        amounts[key]=amount1;
        {{--  if(amounts[key]=='' || amounts[key]==0 || amounts[key]==null){
            amounts[key]=0;
        }  --}}
        var sum = amounts.reduce((a, b) => a + b, 0)
        var discount = $(this).attr('data-discount');
        discount=parseFloat(discount);
        console.log(discount+"======="+amount1+"=========>>"+sum+"=<<<<===="+offer_type)
        if(sum!=0){
            if(offer_type=='percentage'){
                var dis=(discount*sum)/100;
                var paid=sum-dis;
                total_paid=paid;
                total_discount=dis;
                total_fee=dis;
                $('.discount_amount_id').text(total_discount);
                $('.paid_amount_id').text(total_paid);
                $('#amount_free').val(total_discount)
                $('#discount_amount').val(total_discount);
                $('#amount_paid').val(total_paid);

            }
            if(offer_type=='amount'){
                if(amount1>=discount){
                    var paid=amount1-discount;
                    total_paid=paid;
                    total_discount=discount;
                    total_fee=discount;
                    $('.discount_amount_id').text(total_discount);
                    $('.paid_amount_id').text(total_paid);
                    $('#discount_amount').val(total_discount);
                    $('#amount_free').val(total_discount)
                    $('#amount_paid').val(total_paid);
                }else{
                    {{--  $('.discount_amount_id').text(0);  --}}
                    $('.paid_amount_id').text();
                    $('#discount_amount').val();
                    $('#amount_free').val()
                    $('#amount_paid').val();
                }
            }
            if(offer_type=='buy-get-percentage'){
                var dis=(discount*sum)/100;
                var paid=sum-dis;

                total_paid=paid;
                total_discount=dis;
                total_fee=dis;
                $('.discount_amount_id').text(total_discount);
                $('.paid_amount_id').text(total_paid);
                $('#amount_free').val(total_fee)
                $('#discount_amount').val(total_discount);
                $('#amount_paid').val(total_paid);
            }
            if(offer_type=='buy-get'){
                var sub = free_amount.reduce((a, b) => a + b, 0)
                var paid=sum-sub;
                total_paid=paid;
                total_discount=sub;
                console.log(sub+"=======>"+paid+"==>>>>>>>>>>>>"+sum+"++++++")
                $('.discount_amount_id').text(total_discount);
                $('.paid_amount_id').text(total_paid);
                $('#discount_amount').val(total_discount);
                $('#amount_paid').val(total_paid);
            }
        }else{
            $('.discount_amount_id').text(0);
            $('.paid_amount_id').text(0);
            $('#discount_amount').val();
            $('#amount_free').val()
            $('#amount_paid').val();
        }


    })

    $(document).on('keyup','.percentage_amount_free',function(){
        var key=$(this).attr('data-key')
        var amount2=$('#percentage_amount_free'+key).val();
        if(amount2==''){
            amount2=0;
        }
        amount2=parseFloat(amount2);

        console.log(amount2)
        free_amount[key]=amount2;
        if(free_amount[key]=='' || free_amount[key]==0 || free_amount[key]==null ||free_amount[key]=='NaN'){
            free_amount.splice(key, 1);
        }
        var sub = free_amount.reduce((a, b) => a + b, 0)
        var sum = amounts.reduce((a, b) => a + b, 0)
        var paid=sum-sub;
        total_paid=paid;
        total_discount=sub;
        console.log(sub+"=======>"+paid+"==>>>>>>>>>>>>"+sum+"=="+amount2+"++++++"+free_amount)
        $('.discount_amount_id').text(total_discount);
        $('.paid_amount_id').text(total_paid);
        $('#discount_amount').val(total_discount);
        $('#amount_paid').val(total_paid);

    })
    {{--  $('.percentage_amount').blur(function(){


    })  --}}
</script>
<script>
    $('form#myform').on('submit', function(event) {
        //Add validation rule for dynamically generated name fields


        $('.percentage_amount').each(function() {
            $(this).rules("add",
                {
                    required: true,
                    messages: {
                        required: "Please Enter Required Fields",
                    }
                });
        });
        $('.percentage_amount_free').each(function() {
            $(this).rules("add",
                {
                    required: true,
                    messages: {
                        required: "Please Enter Required Fields",
                    }
                });
        });
        $('#userId').each(function() {
            $(this).rules("add",
                {
                    required: true,
                    messages: {
                        required: "Please Enter Required Fields",
                    }
                });
        });
        $('#coupon').each(function() {
            $(this).rules("add",
                {
                    required: true,
                    messages: {
                        required: "Please Enter Required Fields",
                    }
                });
        });
});
$("#myform").validate({
    submitHandler: function (form) {

        console.log(form)
        var amount=$('.percentage_amount').val();
        if(amount==''){
            amount=0
        }
        amount=parseFloat(amount);
        var discount = $('.percentage_amount').attr('data-discount');
        discount=parseFloat(discount);
        var key = $('.percentage_amount').attr('data-offer');
        console.log(amount+"=====>"+discount+"========>"+key)
        if(key==='amount'){
            if(amount < discount){
                Swal.fire('Total Price Amount should be greater than Discount Amount');
                return false;
            }
        }

        Swal.fire({
            title: '',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                form.submit();
            } else if (result.isDenied) {
              Swal.fire('Changes are not saved', '', 'info')
            }
          })
    }
});
</script>
@stop
