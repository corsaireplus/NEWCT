@extends('staff.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--purple has-link box--shadow2">
                <a href="{{ route('staff.courier.sent.queue') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-hourglass-start f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang(' RDV en Cours')</span>
                            <h2 class="text-white">{{ $sentInQueue }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--cyan has-link box--shadow2">
                <a href="{{ route('staff.transactions.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-history f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Colis en Entrepot')</span>
                            <h2 class="text-white">{{ $upcomingCourier }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--primary has-link overflow-hidden box--shadow2">
                <a href="{{ route('staff.courier.dispatch') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-dolly f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Prochain RDV')</span>
                            <h2 class="text-white">{{ $sentInNext }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->





        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--pink has-link box--shadow2">
                <a href="{{ route('staff.courier.delivery.queue') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="lab la-accessible-icon f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang(' Delivery in Queue')</span>
                            <h2 class="text-white">{{ $deliveryInQueue }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--green has-link box--shadow2">
                <a href="{{ route('staff.courier.manage.sent.list') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-check-double f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Total sent')</span>
                            <h2 class="text-white">{{ $totalSent }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--deep-purple has-link box--shadow2">
                <a href="{{ route('staff.courier.manage.delivered') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-list-alt f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Total Delivered')</span>
                            <h2 class="text-white">{{ $totalDelivery }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--lime has-link box--shadow2">
                <a href="{{ route('staff.branch.index') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-university f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang(' Total Agences')</span>
                            <h2 class="text-white">{{ $branchCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--orange has-link box--shadow2">
                <a href="{{ route('staff.cash.courier.income') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-money-bill-wave f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('Total Cash Collection')</span>
                            <h2 class="text-white">{{ $general->cur_sym }}{{ showAmount($cashCollection) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--teal has-link box--shadow2">
                <a href="{{ route('staff.courier.manage.list') }}" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-shipping-fast f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small">@lang('All Courier')</span>
                            <h2 class="text-white">{{ $totalCourier }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

    </div><!-- row end-->
    <div class="row mt-30 ">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-header mb-1">
                    <h6>@lang('Upcomming Courier')</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Agence - Agent')</th>
                                    <th>@lang('Client - Contact')</th>
                                    <th>@lang('Montant - Reference')</th>
                                    <th>@lang('Date Creation')</th>
                                    <th>@lang('Paiement Status')</th>
                                    <th>@lang('Status')</th>
                                    <!-- <th>@lang('Action')</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courierDelivery as $courierInfo)
                                    <tr>
                                        <td>
                                            <span>{{ __($courierInfo->senderBranch->name) }}</span><br>
                                            {{ __($courierInfo->senderStaff->fullname) }}
                                        </td>

                                        <td>
                                            <span>
                                                @if ($courierInfo->receiver_branch_id)
                                                    {{ __($courierInfo->receiver->nom) }}
                                                @else
                                                    <span>{{ __($courierInfo->sender->nom) }}<span>
                                                @endif
                                            </span>
                                            <br>
                                            @if ($courierInfo->receiver_branch_id)
                                                {{ __($courierInfo->receiver->contact) }}
                                            @else
                                                <span>{{ __($courierInfo->sender->contact) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold">{{ getAmount($courierInfo->paymentInfo->final_amount) }}
                                                {{ __($general->cur_text) }}</span><br>
                                            <span>{{ $courierInfo->trans_id }}</span>
                                        </td>
                                        <td>
                                            <span>{{ showDateTime($courierInfo->created_at, 'd M Y') }}</span><br>
                                            <span>{{ diffForHumans($courierInfo->created_at) }}</span>
                                        </td>
                                        <td>
                                            @if(!$courierInfo->paymentInfo)
                                                <span class="badge badge--danger">@lang('Unpaid')</span>
                                            @else
                                                @if ($courierInfo->paymentInfo->status == Status::PAID)
                                                    <span class="badge badge--success">@lang('Paid')</span>
                                                @elseif($courierInfo->paymentInfo->status == Status::UNPAID)
                                                    <span class="badge badge--danger">@lang('Unpaid')</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($courierInfo->status == Status::COURIER_QUEUE)
                                                <span class="badge badge--primary">@lang('Received')</span>
                                            @elseif($courierInfo->status == Status::COURIER_DISPATCH)
                                                <span class="badge badge--">@lang('Sent')</span>
                                            @elseif($courierInfo->status == Status::COURIER_UPCOMING)
                                                <span class="badge badge--warning">@lang('Upcomming')</span>
                                            @elseif($courierInfo->status == Status::COURIER_DELIVERED)
                                                <span class="badge badge--success">@lang('Delivered')</span>
                                            @endif
                                        </td>

                                        <!--td>
                                            < @if ($courierInfo->status == Status::COURIER_DELIVERYQUEUE &&
                                                $courierInfo->paymentInfo->status == Status::COURIER_UPCOMING)
                                                <a href="javascript:void(0)" title=""
                                                    class="btn btn-sm btn-outline--secondary  delivery"
                                                    data-code="{{ $courierInfo->code }}"><i class="las la-truck"></i>
                                                    @lang('Delivery')</a>
                                            @endif
                                            @if ($courierInfo->status == Status::COURIER_DELIVERYQUEUE &&
                                                $courierInfo->paymentInfo->status == Status::COURIER_QUEUE)
                                                <a href="javascript:void(0)" title=""
                                                    class="btn btn-sm btn-outline--success  payment"
                                                    data-code="{{ $courierInfo->code }}"><i
                                                        class="las la-credit-card"></i>
                                                    @lang('Payment')</a>
                                            @endif
                                            <a href="{{ route('staff.courier.invoice', encrypt($courierInfo->id)) }}"
                                                title="" class="btn btn-sm btn-outline--info "><i
                                                    class="las la-file-invoice"></i> @lang('Invoice')</a>
                                            <a href="{{ route('staff.courier.details', encrypt($courierInfo->id)) }}"
                                                title="" class="btn btn-sm btn-outline--primary "> <i
                                                    class="las la-info-circle"></i>@lang('Details')</a> >
                                        </td-->
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Payment Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('staff.courier.payment') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to collect this amount?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deliveryBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Delivery Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
                <form action="{{ route('staff.courier.delivery') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>@lang('Are you sure to delivery this courier?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('breadcrumb-plugins')
    <div class="d-flex flex-wrap justify-content-end">
        <h3>{{ __(auth()->user()->branch->name) }}</h3>
    </div>
@endpush


@push('script')
    <script>
        (function() {
            'use strict';
            $('.payment').on('click', function() {
                var modal = $('#paymentBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });

            $('.delivery').on('click', function() {
                var modal = $('#deliveryBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });
        })(jQuery())
    </script>
@endpush
