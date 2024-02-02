@extends('staff.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Agent')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Nom Complet')
                            <span>{{ __($courierInfo->senderStaff->fullname) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span>{{ __($courierInfo->senderStaff->email) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Agence')
                            <span>{{ __($courierInfo->senderBranch->name) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Status')
                            @if ($courierInfo->senderStaff->status == Status::ENABLE)
                                <span class="badge badge-pill badge--success">@lang('Active')</span>
                            @elseif($courierInfo->senderStaff->status == Status::DISABLE)
                                <span class="badge badge-pill badge--danger">@lang('Banned')</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            @if ($courierInfo->receiver_staff_id)
                <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted">@lang('Receiver Staff')</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Fullname')
                                <span>{{ __($courierInfo->receiverStaff->fullname) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Email')
                                <span>{{ __($courierInfo->receiverStaff->email) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Branch')
                                <span>{{ __($courierInfo->receiverBranch->name) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Status')
                                @if ($courierInfo->receiverStaff->status == Status::ENABLE)
                                    <span class="badge badge-pill badge--success">@lang('Active')</span>
                                @elseif($courierInfo->receiverStaff->status == Status::DISABLE)
                                    <span class="badge badge-pill badge--danger">@lang('Banned')</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
            <div class="row mb-30">
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Expediteur Information')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Name')
                                    <span>{{ __(@$courierInfo->sender->nom) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Phone')
                                    <span>{{ __(@$courierInfo->sender->contact) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Transaction Numero')
                                    <span class="fw-bold">{{ $courierInfo->trans_id }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if($courierInfo->reftrans)
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Destinataire Information')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Name')
                                    <span>{{ __(@$courierInfo->receiver->nom) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Phone')
                                    <span>{{ @$courierInfo->receiver->contact }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Reference Colis')
                                    <span class="badge badge--primary fw-bold">{{ __(@$courierInfo->reftrans) }}</span>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>
           
            <div class="row mb-30">
                <div class="col-lg-12">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Transaction Details')</h5>
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th>@lang('Description')</th>
                                            <th>@lang('Frais')</th>
                                            <th>@lang('Qté')</th>
                                            <th>@lang('Sous-total')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courierInfo->products as $courierProductInfo)
                                            <tr>
                                                <td>{{ __($courierProductInfo->type->name) }}</td>
                                                <td>{{ showAmount($courierProductInfo->fee) }} {{ $general->cur_sym }}</td>
                                                <td>{{ $courierProductInfo->qty }}
                                                    {{ __(@$courierProductInfo->type->unit->name) }}</td>
                                                <td>{{ showAmount($courierProductInfo->fee) }} {{ $general->cur_sym }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-30">
                <div class="col-lg-12 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Facture Information')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Payment Received By ')
                                    @if (!empty($courierInfo->paymentInfo->branch_id))
                                        <span>{{ __(@$courierInfo->paymentInfo->branch->name) }}</span>
                                    @else
                                        <span>@lang('N/A')</span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Date')
                                    @if (!empty($courierInfo->paymentInfo->date))
                                        <span>{{ showDateTime($courierInfo->date, 'd M Y') }}</span>
                                    @else
                                        <span>@lang('N/A')</span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Subtotal')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        <span>{{ showAmount($courierInfo->paymentInfo->amount) }} {{ __($general->cur_text) }}</span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Discount')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        <span>
                                            {{ showAmount($courierInfo->paymentInfo->discount) }}
                                            {{ __($general->cur_text) }}
                                            <small class="text--danger">({{ getAmount($courierInfo->paymentInfo->percentage)}}%)</small>
                                        </span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Total')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        <span>{{ showAmount($courierInfo->paymentInfo->final_amount) }}
                                            {{ __($general->cur_text) }}
                                        </span>
                                    @endif
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        @if ($courierInfo->paymentInfo->status == Status::PAID)
                                            <span class="badge badge--success">@lang('Paid')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Unpaid')</span>
                                        @endif
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-lg-12 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark">@lang('Paiement Information')</h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Sous-total')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        <span>{{ showAmount($courierInfo->paymentInfo->amount) }} {{ __($general->cur_text) }}</span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Remise')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        <span>
                                            {{ showAmount($courierInfo->paymentInfo->discount) }}
                                            {{ __($general->cur_text) }}
                                            <small class="text--danger">({{ getAmount($courierInfo->paymentInfo->percentage)}}%)</small>
                                        </span>
                                    @endif
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Total')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        <span>{{ showAmount($courierInfo->paymentInfo->final_amount) }}
                                            {{ __($general->cur_text) }}
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                @lang('Reste à Payer')
                                @if($userInfo->branch_id == $courierInfo->branch_id )
                                <span class="badge badge--danger">{{getAmount($courierInfo->paymentInfo->sender_amount - $deja_payer_sender )}} {{$userInfo->branch->currencie}}</span>
                                @else
                                <span class="badge badge--danger">{{ getAmount($courierInfo->paymentInfo->receiver_amount - $deja_payer_receiver) }} {{$userInfo->branch->currencie}}</span>
                                @endif
                              </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @lang('Status')
                                    @if(!$courierInfo->paymentInfo)
                                        <p>@lang('Unpaid')</p>
                                    @else
                                        @if ($courierInfo->status == 2)
                                            <span class="badge badge--success">@lang('Payé')</span>
                                        @elseif($courierInfo->status == 1)
                                        <span class="badge badge--warning">@lang('Partiel')</span>
                                        @else
                                            <span class="badge badge--danger">@lang('Non Payé')</span>
                                        @endif
                                    @endif
                                </li>
                            </ul>
                           
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th>@lang('Date')</th>
                                            <th>@lang('Agent')</th>
                                            <th>@lang('Montant  payé')</th>
                                            <th>@lang('Mode')</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach($courierInfo->paiement as $payment)

                                    <tr>
                                        <td>
                                            {{date('d-m-Y', strtotime($payment->date_paiement))}}
                                        </td>
                                        <td>{{$payment->agent->firstname}}</td>
                                        @if($userInfo->branch_id == $courierInfo->branch_id )
                                        <td>{{getAmount($payment->sender_payer)}} {{auth()->user()->branch->currencie}}</td>
                                        @else
                                        <td>{{getAmount($payment->receiver_payer)}} {{auth()->user()->branch->currencie}}</td>

                                        @endif
                                        @if($payment->modepayer)
                                        <td>{{$payment->modepayer->nom}}</td>
                                        @else
                                        <td>N/A</td>
                                        @endif
                                        <td>                                            <a href="{{route('staff.transaction.recu', encrypt($payment->refpaiement))}}"><span class="badge badge--primary">@lang('reçu')</span></a>

                                    </tr>

                                    @if($userInfo->branch_id == $courierInfo->sender_branch_id)
                                    @php
                                    $total += $payment->sender_payer;
                                    @endphp
                                    @else
                                    @php
                                    $total += $payment->receiver_payer;
                                    @endphp
                                    @endif

                                    @endforeach
                                            <!-- <tr>
                                                <td>{{ __($courierProductInfo->type->name) }}</td>
                                                <td>{{ showAmount($courierProductInfo->fee) }} {{ $general->cur_sym }}</td>
                                                <td>{{ $courierProductInfo->qty }}
                                                    {{ __(@$courierProductInfo->type->unit->name) }}</td>
                                                <td>{{ showAmount($courierProductInfo->fee) }} {{ $general->cur_sym }}</td>
                                            </tr>
-->
                                    </tbody>
                                </table>
                            </div>
                     
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />

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
    <x-back route="{{ route('staff.transaction.index') }}" />

    <a href="{{ route('staff.transaction.invoice', encrypt($courierInfo->id)) }}" title=""
        class="btn btn-sm btn-outline--info">
        <i class="las la-file-invoice"></i>
        @lang('Facture')
    </a>

    <!-- @if ($courierInfo->status <= 1 )
        <button class="btn btn-sm btn-outline--info delivery"
            data-code="{{ $courierInfo->code }}"><i class="las la-truck"></i>
            @lang('Delivery')</button>
    @endif -->

    @if ($courierInfo->status <= 1 )
            <button class="btn btn-sm btn-outline--success payment"
                data-code="{{ $courierInfo->code }}"><i class="las la-credit-card"></i>
                @lang('Payer')</button>
    @endif

    <!-- @if ($courierInfo->status == Status::COURIER_QUEUE || $courierInfo->status == Status::COURIER_DISPATCH)
        @php
            $class = '';
            if ($courierInfo->sender_branch_id == $staff->branch_id) {
                $icon = 'la-arrow-circle-right';
                $text = 'Dispatch';
                $route = route('staff.courier.dispatched', $courierInfo->id);
                $question = "Are you sure to despatched this courier";
                if($courierInfo->sender_branch_id == $staff->branch_id && $courierInfo->status == Status::COURIER_DISPATCH){
                    $class = 'd-none';
                }
            } else {
                $icon = 'la-check-circle';
                $text = 'Received';
                $route = route('staff.courier.receive', $courierInfo->id);
                $question = "Are you sure to receive this courier";
            }
        @endphp

        <button type="button" class="btn btn-sm btn-outline--warning confirmationBtn {{ $class }}"
            data-action="{{ $route }}" data-question="{{ __($question) }}?">
            <i class="las {{ $icon }}"></i>
            @lang($text)
        </button>
    @endif -->
@endpush

@push('script')
    <script>
        (function($) {
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
        })(jQuery)
    </script>
@endpush
