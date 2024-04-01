@extends('facilities.layouts.vendorLayout')
@section('title','Coupan Management')
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>{{__("Coupon Request Info")}}</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendor.dashboard') }}"><i class="fa fa-dashboard"></i></a></li>
                    <li class="breadcrumb-item">Coupon Request</li>
                    <li class="breadcrumb-item active">Info</li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="d-flex flex-row-reverse">
                    <div class="page_action">
                    </div>
                    <div class="p-2 d-flex">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="body">
                    <img src="{{ asset($data->users->profile_image) }}" alt=""  class="img-fluid rounded mb-3">
                    <h6 class="mb-4 font-weight-bold">{{ $data->users->name ?? 'N/A' }}</h6>
                    <ul class="list-unstyled">
                        <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">Coupon Code:</label>
                            <span>{{ $data->coupons->coupon_code ?? '--' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">Expire Date:</label>
                            <span class="text-danger">{{ \Carbon\Carbon::parse($data->end_date)->format('d M,Y') }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">Offer Type:</label>
                            @if($data->coupons->offer_type=='percentage')
                                <span>Percentage</span>
                            @elseif($data->coupons->offer_type=='amount')
                                <span>Amount</span>
                            @elseif($data->coupons->offer_type=='buy-get')
                                <span>Buy X and Get Y</span>
                            @elseif($data->coupons->offer_type=='buy-get-percentage')
                                <span>Buy X and Get Y Percentage</span>
                            @endif
                        </li>
                        <li class="d-flex justify-content-between">
                            <label class="mb-2 font-weight-bold text-muted">Offer:</label>
                            @if($data->coupons->offer_type=='percentage')
                                    <span class="contact-title">{{ $data->coupons->discount }} % Off</span>
                            @elseif($data->coupons->offer_type=='amount')
                                <span>{{ $data->coupons->discount }} AED Off</span>
                            @elseif($data->coupons->offer_type=='buy-get')
                                <span>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->free_items ?? 0}} Free</span>
                            @elseif($data->coupons->offer_type=='buy-get-percentage')
                                <span>Buy {{ $data->coupons->buy_items ?? 0 }} get {{ $data->coupons->discount ?? 0}} % Off</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8">
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs-new2">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Details">{{__("Coupon Details")}}</a></li>
                    </ul>
                    <div class="tab-content padding-0 mt-3">
                        <div class="tab-pane active" id="Details">
                            <form action="{{ route('coupon.couponRequestdetail',$data->id) }}" method="post" id="myform" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="status" value="vendor_redeem">
                                @if($data->coupons && ($data->coupons->offer_type=='percentage'))
                                    <input type="hidden" name="offer_type" value="percentage">
                                    <div class="form-group">
                                        <label for="discount">{{__("Total Price")}}</label>
                                        <input type="text" name="amount[0]" data-key="0" data-offer="percentage" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_0" placeholder="Enter Total Sum Amount" class="form-control percentage_amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="discount">{{__("Total Discount Amount")}} : <span class="discount_amount_id">0</span></label><br>
                                        <label for="discount">{{__("Total Amount To Recieved")}}: <span class="paid_amount_id">0</span></label>
                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                    </div>
                                @elseif($data->coupons && ($data->coupons->offer_type=='amount'))
                                    <input type="hidden" name="offer_type" value="amount">
                                    <div class="form-group">
                                        <label for="discount">{{__("Total Price")}} (AED)</label>
                                        <input type="text" name="amount[0]" data-key="0" data-offer="amount" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_0" placeholder="Enter Total Sum Amount" class="form-control percentage_amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="discount">{{__("Total Discount Amount")}} : <span class="discount_amount_id"></span></label><br>
                                        <label for="discount">{{__("Total Amount To Recieved")}}: <span class="paid_amount_id"></span></label>
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
                                        <label for="discount">{{__("Total Discount Amount")}} : <span class="discount_amount_id">0</span></label><br>
                                        <label for="discount">{{__("Total Amount To Recieved")}}: <span class="paid_amount_id">0</span></label>
                                        <input type="hidden" name="amount_free[0]" id="amount_free" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                    </div>
                                @elseif($data->coupons && ($data->coupons->offer_type=='buy-get'))
                                    <input type="hidden" name="offer_type" value="buy-get">
                                    @if($data->coupons->buy_items>0)
                                        @for($i=0;$i<$data->coupons->buy_items;$i++)
                                            <div class="form-group">
                                                <label for="discount">{{__("Buy Item")}} {{ $i+1 }} {{__("Price")}}(AED)</label>
                                                <input type="text" name="amount[{{ $i }}]" data-key="{{ $i }}" onkeypress="myFunction()" data-offer="buy-get" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_{{ $i }}" placeholder="Enter Item {{ $i+1 }} Price(AED)" class="form-control percentage_amount">
                                            </div>
                                        @endfor
                                    @endif
                                    @if($data->coupons->free_items>0)
                                        @for($j=0;$j<$data->coupons->free_items;$j++)
                                            <div class="form-group">
                                                <label for="discount">{{__("Get Item")}} {{ $j+1 }} {{__("Price")}}(AED)</label>
                                                <input type="text" name="amount_free[{{ $j }}]" data-key="{{ $j }}" data-offer="buy-get" data-discount="{{ $data->coupons->discount }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="percentage_amount_free{{ $j }}" placeholder="Enter Item {{ $j+1 }} Price(AED)" class="form-control percentage_amount_free">
                                            </div>
                                        @endfor
                                    @endif
                                    <div class="form-group">
                                        <label for="discount">{{__("Total Discount Amount")}} : <span class="discount_amount_id">0</span></label><br>
                                        <label for="discount">{{__("Total Amount To Recieved")}}: <span class="paid_amount_id">0</span></label>
                                        <input type="hidden" name="amount_discount" id="discount_amount" placeholder="Enter Total Sum Amount">
                                        <input type="hidden" name="amount_paid" id="amount_paid" placeholder="Enter Total Sum Amount">
                                    </div>
                                @endif
                                <div>
                                    <button type="submit" class="btn btn-primary">{{__("Submit")}}</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

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
