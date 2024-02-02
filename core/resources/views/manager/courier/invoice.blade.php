@extends('manager.layouts.app')
@section('panel')
    <div class="card">
        <div class="card-body">
            <div id="printInvoice">
                <div class="content-header">
                    <h3>
                        @lang('Invoice Number'):
                        <small>#{{ $courierInfo->invoice_id }}</small>
                        <br>
                        @lang('Date'):
                        {{ showDateTime($courierInfo->created_at) }}
                        <br>
                        @lang('Estimate Delivery Date: ') {{ showDateTime($courierInfo->estimate_date, 'd M Y') }}
                    </h3>
                </div>

                <div class="invoice">
                    <div class="d-flex justify-content-between mt-3">
                        <div class="text-center">
                            @php
                                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($courierInfo->code, 'C128') . '" alt="barcode" />';
                            @endphp
                            <br>
                           <span> {{ $courierInfo->code }}</span>
                        </div>
                        <div>
                            <b>@lang('Order Id') #{{ $courierInfo->code }}</b><br>
                            <b>@lang('Payment Status'):</b>
                            @if(!$courierInfo->payment)
                                <span class="badge badge--danger">@lang('Unpaid')</span>
                            @else
                                @if ($courierInfo->payment->status == Status::PAID)
                                    <span class="badge badge--success">@lang('Paid')</span>
                                @else
                                    <span class="badge badge--danger">@lang('Unpaid')</span>
                                @endif
                            @endif
                            <br>
                            <b>@lang('Sender At Branch'):</b> {{ __($courierInfo->senderBranch->name) }}<br>
                            <b>@lang('Received At Branch'):</b> {{ __($courierInfo->receiverBranch->name) }}
                        </div>
                    </div>
                    <hr>
                    <div class=" invoice-info d-flex justify-content-between">
                        <div>
                            @lang('From')
                            <address>
                                <strong>{{ __(@$courierInfo->senderCustomer->fullname) }}</strong><br>
                                @lang('City'): {{ __(@$courierInfo->senderCustomer->city) }}<br>
                                @lang('State'): {{ __(@$courierInfo->senderCustomer->state) }}<br>
                                @lang('Address'): {{ __($courierInfo->senderCustomer->address) }}<br>
                                @lang('Phone'): {{ @$courierInfo->senderCustomer->mobile }}<br>
                                @lang('Email'): {{ @$courierInfo->senderCustomer->email }}
                            </address>
                        </div>
                        <div>
                            To
                            <address>
                                <strong>{{ __(@$courierInfo->receiverCustomer->fullname) }}</strong><br>
                                @lang('City'): {{ __(@$courierInfo->receiverCustomer->city) }}<br>
                                @lang('State'): {{ __(@$courierInfo->receiverCustomer->state) }}<br>
                                @lang('Address'): {{ __(@$courierInfo->receiverCustomer->address) }}<br>
                                @lang('Phone'): {{ @$courierInfo->receiverCustomer->mobile }}<br>
                                @lang('Email'): {{ @$courierInfo->receiverCustomer->email }}
                            </address>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Courier Type')</th>
                                        <th>@lang('Sending Date')</th>
                                        <th>@lang('Qty')</th>
                                        <th>@lang('Subtotal')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courierInfo->products as $courierProductInfo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ __(@$courierProductInfo->type->name) }}</td>
                                            <td>
                                                {{ showDateTime($courierProductInfo->created_at, 'd M Y') }}</td>
                                            <td>{{ $courierProductInfo->qty }} {{ __(@$courierProductInfo->type->unit->name) }} </td>
                                            <td>
                                                {{ $general->cur_sym }}{{ getAmount($courierProductInfo->fee) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-30 mb-none-30">
                        <div class="col-lg-12 mb-30">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>@lang('Subtotal'):</th>
                                            <td>{{ $general->cur_sym }}{{ showAmount(@$courierInfo->payment->final_amount) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>@lang('Discount'):</th>
                                            @if(!$courierInfo->payment)
                                            <td>@lang('Unpaid')</td>
                                            @else
                                                <td>{{ $general->cur_sym }}{{ showAmount($courierInfo->payment->discount) }}
                                                    <small class="text--danger">
                                                        ({{ getAmount($courierInfo->payment->percentage)}}%)
                                                    </small>
                                                </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>@lang('Total'):</th>
                                            <td>{{ $general->cur_sym }}{{ showAmount(@$courierInfo->payment->final_amount) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-end">
                        <button class="btn btn-outline--primary  printInvoice"><i
                                class="las la-download"></i></i>@lang('Print')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        "use strict";
        $('.printInvoice').click(function() {
            $('#printInvoice').printThis();
        });
    </script>
@endpush
@push('breadcrumb-plugins')
    <x-back route="{{ route('manager.courier.index') }}" />
@endpush
