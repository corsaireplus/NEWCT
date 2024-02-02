@extends('staff.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <form action="{{route('staff.courier.update',encrypt($courierInfo->id))}}" method="POST">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-6 form-group">
                            <label for="">@lang('Estimate Date')</label>
                            <div class="input-group">
                                <input name="estimate_date" value="{{ showDateTime($courierInfo->estimate_date,'Y-m-d')}}" type="text" autocomplete="off"  class="form-control date" placeholder="Estimate Delivery Date" required>
                                <span class="input-group-text"><i class="las la-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-6 form-group">
                            <label for="">@lang('Payment Status')</label>
                            <div class="input-group">
                                <select class="form-control" required name="payment_status">
                                    @if(!$courierInfo->paymentInfo)
                                        <option value="0" selected>@lang('UNPAID')</option>
                                    @else
                                        <option value="0" @selected($courierInfo->payment->status == Status::UNPAID)>@lang('UNPAID')</option>
                                        <option value="1" @selected($courierInfo->payment->status == Status::PAID)>@lang('PAID')</option>
                                    @endif
                                </select>
                                <span class="input-group-text"><i class="las la-money-bill-wave-alt"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Sender Information')</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Email')</label>
                                            <input type="email" class="form-control" name="sender_customer_email" value="{{ @$courierInfo->senderCustomer->email}}" required>
                                        </div>
                                        <div class=" form-group col-lg-6">
                                            <label>@lang('Phone')</label>
                                            <input type="text" class="form-control" value="{{@$courierInfo->senderCustomer->mobile}}" name="sender_customer_phone" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('First Name')</label>
                                            <input type="text" class="form-control" name="sender_customer_firstname" value="{{ $courierInfo->senderCustomer->firstname }}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Last Name')</label>
                                            <input type="text" class="form-control" name="sender_customer_lastname" value="{{ $courierInfo->senderCustomer->lastname }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('City')</label>
                                            <input type="text" class="form-control" name="sender_customer_city"
                                                value="{{ @$courierInfo->senderCustomer->city }}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('State')</label>
                                            <input type="text" class="form-control" name="sender_customer_state"
                                                value="{{ @$courierInfo->senderCustomer->state }}" required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>@lang('Address')</label>
                                            <input type="text" class="form-control" name="sender_customer_address"
                                                value="{{ $courierInfo->senderCustomer->address }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Receiver Information')</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Email')</label>
                                            <input type="email" class="form-control" name="receiver_customer_email"
                                                value="{{@$courierInfo->receiverCustomer->email}}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Phone')</label>
                                            <input type="text" class="form-control" name="receiver_customer_phone"
                                                value="{{ @$courierInfo->receiverCustomer->mobile}}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('First Name')</label>
                                            <input type="text" class="form-control" name="receiver_customer_firstname"
                                                value="{{$courierInfo->receiverCustomer->firstname}}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Last Name')</label>
                                            <input type="text" class="form-control" name="receiver_customer_lastname"
                                                value="{{$courierInfo->receiverCustomer->lastname}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('City')</label>
                                            <input type="text" class="form-control" name="receiver_customer_city"
                                                value="{{@$courierInfo->receiverCustomer->city}}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('State')</label>
                                            <input type="text" class="form-control" name="receiver_customer_state"
                                                value="{{@$courierInfo->receiverCustomer->state}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Address')</label>
                                            <input type="text" class="form-control" name="receiver_customer_address"
                                                value="{{@$courierInfo->receiverCustomer->address}}" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>@lang('Select Branch')</label>
                                            <select class="form-control" name="branch" required>
                                                <option value>@lang('Select One')</option>
                                                @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" @selected($courierInfo->receiver_branch_id==$branch->id)>{{__($branch->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary text-white">@lang('Courier Information')
                                    <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i
                                            class="la la-fw la-plus"></i>@lang('Add New One')
                                    </button>
                                </h5>
                                <div class="card-body">
                                    <div class="row" id="addedField">
                                        @foreach ($courierInfo->products as $item)
                                            <div class="row single-item gy-2">
                                                <div class="col-md-2">
                                                    <select class="form-control selected_type" name="items[{{ $loop->index}}][type]" required>
                                                        <option disabled selected value="">@lang('Select Courier/Parcel Type')</option>
                                                        @foreach($types as $type)
                                                            <option value="{{$type->id}}" @selected($item->type->id==$type->id)
                                                                data-unit="{{$type->unit->name}}" data-price="{{ getAmount($type->price)}}"  >
                                                                {{__($type->name)}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" placeholder="@lang('Courier/Parcel Name')"
                                                            name="items[{{ $loop->index }}][name]" value="{{ $item->parcel_name }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control quantity" value="{{ $item->qty }}"  name="items[{{ $loop->index }}][quantity]"  required>
                                                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input type="text"  class="form-control single-item-amount" value="{{getAmount($item->fee)}}"  name="items[{{ $loop->index }}][amount]" required readonly>
                                                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
 						                @endforeach
                                    </div>
                                    <div class="border-line-area">
                                        <h6 class="border-line-title">@lang('Summary')</h6>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-text">@lang('Discount')</span>
                                                @if(!$courierInfo->paymentInfo)
                                                    <p>@lang('Unpaid')</p>
                                                @else
                                                    <input type="number" name="discount"  class="form-control bg-white text-dark discount" value="{{ $courierInfo->payment->percentage }}">
                                                    <span class="input-group-text">%</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" d-flex justify-content-end mt-2">
                                        <div class="col-md-3  d-flex justify-content-between">
                                            <span class="fw-bold">@lang('Subtotal'):</span>
                                            <div>{{$general->cur_sym}}<span class="subtotal">{{ showAmount(@$courierInfo->payment->amount) }}</span></div>
                                        </div>
                                    </div>
                                    <div class=" d-flex justify-content-end mt-2">
                                        <div class="col-md-3  d-flex justify-content-between">
                                            <span class="fw-bold">@lang('Total'):</span>
                                            <div> {{$general->cur_sym}}<span class="total">{{ showAmount(@$courierInfo->payment->final_amount) }}</span></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> @lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('script-lib')
    <script src="{{asset('assets/viseradmin/js/vendor/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/viseradmin/js/vendor/datepicker.en.js')}}"></script>
@endpush

@push('style-lib')
    <link  rel="stylesheet" href="{{asset('assets/viseradmin/css/vendor/datepicker.min.css')}}">
@endpush

@push('script')
<script>
    "use strict";
    (function ($) {


        $('.addUserData').on('click', function () {
            let length=$("#addedField").find('.single-item').length;
            let html = `
            <div class="row single-item gy-2">
                <div class="col-md-2">
                    <select class="form-control selected_type" name="items[${length}][type]" required>
                        <option disabled selected value="">@lang('Select Courier/Parcel Type')</option>
                            @foreach($types as $type)
                            <option value="{{$type->id}}" data-unit="{{$type->unit->name}}" data-price={{ getAmount($type->price)}} >{{__($type->name)}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="@lang('Courier/Parcel Name')"  name="items[${length}][name]">
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control quantity" placeholder="@lang('Quantity')" disabled name="items[${length}][quantity]"  required>
                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text"  class="form-control single-item-amount" placeholder="@lang('Enter Price')" name="items[${length}][amount]" required readonly>
                        <span class="input-group-text">{{__($general->cur_text)}}</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>`;
            $('#addedField').append(html)
        });

        $('#addedField').on('change', '.selected_type', function (e) {
            let unit = $(this).find('option:selected').data('unit');
            let parent = $(this).closest('.single-item');
            $(parent).find('.quantity').attr('disabled', false);
            $(parent).find('.unit').html(`${unit || '<i class="las la-balance-scale"></i>'}`);
            calculation();
        });

        $('#addedField').on('click', '.removeBtn', function (e) {
            let length=$("#addedField").find('.single-item').length;
            if(length <= 1){
                notify('warning',"@lang('At least one item required')");
            }else{
                $(this).closest('.single-item').remove();
            }
            $('.discount').trigger('change');
            calculation();
        });

        let discount=0;

        $('.discount').on('input change',function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');
             discount=parseFloat($(this).val() || 0);
             if(discount >=100){
                discount=100;
                notify('warning',"@lang('Discount can not bigger than 100 %')");
                $(this).val(discount);
             }
            calculation();
        });

        $('#addedField').on('input', '.quantity', function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');

            let quantity = $(this).val();
            if (quantity <= 0) {
                quantity = 0;
            }
            quantity=parseFloat(quantity);

            let parent   = $(this).closest('.single-item');
            let price    = parseFloat($(parent).find('.selected_type option:selected').data('price') || 0);
            let subTotal = price*quantity;

            $(parent).find('.single-item-amount').val(subTotal.toFixed(2));


            calculation()
        });

        function calculation ( ) {
            let items    = $('#addedField').find('.single-item');
            let subTotal = 0;

            $.each(items, function (i, item) {
                let price = parseFloat($(item).find('.selected_type option:selected').data('price') || 0);
                let quantity = parseFloat($(item).find('.quantity').val() || 0);
                subTotal+=price*quantity;
            });

            subTotal=parseFloat(subTotal);

            let discountAmount = (subTotal/100)*discount;
            let total          = subTotal-discountAmount;

            $('.subtotal').text(subTotal.toFixed(2));
            $('.total').text(total.toFixed(2));
        };

        $('.date').datepicker({
            language  : 'en',
            dateFormat: 'yyyy-mm-dd',
            minDate   : new Date()
        });

    })(jQuery);
</script>
@endpush

@push('style')
    <style>
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }
        .border-line-area::before {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }
        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
        }
    </style>
@endpush
