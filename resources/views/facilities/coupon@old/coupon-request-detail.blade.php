@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Management')
@section('content')
<style>
    .contact-title{
        width: 100% !important;
    }
</style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 p-r-0 title-margin-right">
                <div class="page-header">
                    <div class="page-title">
                        {{-- <h1>Hello,
              <span>Welcome Here</span>
            </h1> --}}
                    </div>
                </div>
            </div>
            <!-- /# column -->
            <div class="col-lg-4 p-l-0 title-margin-left">
                <div class="page-header">
                    <div class="page-title">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Request Details</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div>
        <!-- /# row -->
        <section id="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h4>User Redeem Request Details</h4>

                        </div>
                        <div class="card-body">
                            <div class="user-profile">
                                <div class="row">
                                    <div class="col-lg-2">
                                        {{-- <label for="">Selfie Image</label> --}}
                                        <div class="user-photo m-b-30">

                                            @if ($data->users->profile_image)
                                                <img class="img-fluid" src="{{ asset($data->users->profile_image) }}"alt="selfie" style="width: 300px;height:250px;"/>
                                            @else
                                                {{-- <img class="img-fluid" src="{{ asset('admin/images/user-profile.jpg') }}"
                                                    alt="" /> --}}
                                            @endif

                                        </div>
                                    </div>
                                    @if ($data->users->profile_image)
                                        <div class="col-lg-10">
                                    @else
                                        <div class="col-lg-12">
                                    @endif

                                            <div class="user-profile-name">{{ $data->users->name ?? 'N/A' }}</div>

                                            <div class="custom-tab user-profile-tab">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li role="presentation" class="active">
                                                        <a href="#1" aria-controls="1" role="tab"
                                                            data-toggle="tab">Coupon Code : {{ $data->coupons->coupon_code ?? ''}}</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="1">
                                                        <div class="contact-information">
                                                            <h4>Coupon information</h4>
                                                            <div class="phone-content">
                                                                <span class="contact-title">Coupon Code : {{ $data->coupons->coupon_code ?? 'N/A'}}</span>
                                                                <span class="phone-number"></span>
                                                            </div>
                                                            @if($data->coupons && ($data->coupons->offer_type=='percentage'))
                                                                <div class="email-content">
                                                                    <span class="contact-title">Offer Type : {{ $data->coupons->offer_type=='percentage'?'Percentage':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title">Discount : {{ $data->coupons->discount }} %</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @elseif($data->coupons && ($data->coupons->offer_type=='amount'))
                                                                <div class="email-content">
                                                                    <span class="contact-title">Offer Type : {{ $data->coupons->offer_type=='amount'?'Flat in AED':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title">Discount : {{ $data->coupons->discount }} AED</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @elseif($data->coupons && ($data->coupons->offer_type=='buy-get-percentage'))
                                                                <div class="email-content">
                                                                    <span class="contact-title">Offer Type : {{ $data->coupons->offer_type=='buy-get-percentage'?'Buy X and Get Y Percentage Off':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title">Discount :Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->discount ?? 0}} % off</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @elseif($data->coupons && ($data->coupons->offer_type=='buy-get'))
                                                                <div class="email-content">
                                                                    <span class="contact-title">Offer Type : {{ $data->coupons->offer_type=='buy-get'?'Buy X and Get Y':'' }}</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                                <div class="email-content">
                                                                    <span class="contact-title">Discount :Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->free_items ?? 0}} Free</span>
                                                                    <span class="contact-email"></span>
                                                                </div>
                                                            @endif

                                                            <form action="{{ route('coupon.couponRequestdetail',$data->id) }}" method="post" id="myform" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                                <input type="hidden" name="status" value="vendor_redeem">
                                                                @if($data->coupons && ($data->coupons->offer_type=='percentage'))
                                                                    <input type="hidden" name="offer_type" value="percentage">
                                                                    <div class="form-group">
                                                                        <label for="discount">Total Price</label>
                                                                        <input type="text" name="amount[0]" data-key="0" data-offer="percentage" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_0" placeholder="Enter Total Sum Amount" class="form-control percentage_amount">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id">0</span></label><br>
                                                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id">0</span></label>
                                                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                                                    </div>
                                                                @elseif($data->coupons && ($data->coupons->offer_type=='amount'))
                                                                    <input type="hidden" name="offer_type" value="amount">
                                                                    <div class="form-group">
                                                                        <label for="discount">Total Price (AED)</label>
                                                                        <input type="text" name="amount[0]" data-key="0" data-offer="amount" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_0" placeholder="Enter Total Sum Amount" class="form-control percentage_amount">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id"></span></label><br>
                                                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id"></span></label>
                                                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                                                    </div>
                                                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get-percentage'))
                                                                    <input type="hidden" name="offer_type" value="buy-get-percentage">
                                                                    @if($data->coupons->buy_items>0)
                                                                        @for($i=0;$i<$data->coupons->buy_items;$i++)
                                                                            <div class="form-group">
                                                                                <label for="discount">Item {{ $i+1 }} Price(AED)</label>
                                                                                <input type="text" name="amount[{{ $i }}]" data-key="{{ $i }}" data-offer="buy-get-percentage" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_{{ $i }}" placeholder="Enter Item {{ $i+1 }} Price(AED)" class="form-control percentage_amount">
                                                                            </div>
                                                                        @endfor
                                                                    @endif
                                                                    <div class="form-group">
                                                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id">0</span></label><br>
                                                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id">0</span></label>
                                                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                                                    </div>
                                                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get'))
                                                                    <input type="hidden" name="offer_type" value="buy-get">
                                                                    @if($data->coupons->buy_items>0)
                                                                        @for($i=0;$i<$data->coupons->buy_items;$i++)
                                                                            <div class="form-group">
                                                                                <label for="discount">Buy Item {{ $i+1 }} Price(AED)</label>
                                                                                <input type="text" name="amount[{{ $i }}]" data-key="{{ $i }}" onkeypress="myFunction()" data-offer="buy-get" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_{{ $i }}" placeholder="Enter Item {{ $i+1 }} Price(AED)" class="form-control percentage_amount">
                                                                            </div>
                                                                        @endfor
                                                                    @endif
                                                                    @if($data->coupons->free_items>0)
                                                                        @for($j=0;$j<$data->coupons->free_items;$j++)
                                                                            <div class="form-group">
                                                                                <label for="discount">Get Item {{ $j+1 }} Price(AED)</label>
                                                                                <input type="text" name="amount_free[{{ $j }}]" data-key="{{ $j }}" data-offer="buy-get" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_free{{ $j }}" placeholder="Enter Item {{ $j+1 }} Price(AED)" class="form-control percentage_amount_free">
                                                                            </div>
                                                                        @endfor
                                                                    @endif
                                                                    <div class="form-group">
                                                                        <label for="discount">Total Discount Amount : <span class="discount_amount_id">0</span></label><br>
                                                                        <label for="discount">Total Amount To Recieved: <span class="paid_amount_id">0</span></label>
                                                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
    </div>
@stop
@section('scripts')
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
