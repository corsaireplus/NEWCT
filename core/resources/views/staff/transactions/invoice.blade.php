@extends('staff.layouts.app')
@section('panel')
    <div class="card">
        <div class="card-body">
            <div id="printInvoice">
                <div class="content-header">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">
                        <address class="m-t-5 m-b-5">
                            <strong class="text-inverse">CHALLENGES TRANSIT</strong><br>
                           
                            90 Rue Edouard Branly Montreuil<br>
                            Tél: 0179751616 - 0619645428<br>
                            Abidjan Cocody<br>
                            Tél:(+225) 0141652222-0141652323<br>   
                        </address>
                            <!-- @lang('Facture Numéro'):
                            <small>#{{ $courierInfo->trans_id }}</small>
                            <br>
                            @lang('Date'):
                            {{ showDateTime($courierInfo->created_at, 'd M Y') }}
                            <br> -->
                            <!-- @lang('Estimate Delivery Date'):
                            {{ showDateTime($courierInfo->estimate_date, 'd M Y') }} -->
                        </div>
                        <div class="fw-bold">
                         <b>FACTURE </b><br>
                            @lang('Facture Numéro'):
                            <small>#{{ $courierInfo->trans_id }}</small>
                            <br>
                            @lang('Date'):
                            {{ showDateTime($courierInfo->created_at, 'd M Y') }}
                            <br>
                            <b>@lang('Agence Expediteur'):</b> {{ __($courierInfo->senderBranch->name) }}<br>
                            @if($courierInfo->reftrans)
                            <b>@lang('Agence Destination'):</b> {{ __($courierInfo->receiverBranch->name) }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="invoice">
                    <div class="d-flex justify-content-between mt-3">
                        <div class="text-center">
                            @php
                                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($courierInfo->code, 'C128') . '" alt="barcode" />';
                            @endphp
                            <br>
                            <span>{{ $courierInfo->code }}</span>
                        </div>
                        <div>
                           
                            <b>@lang('Transaction Id'):</b> {{ $courierInfo->code }}<br>
                            <b>@lang('Paiement Status'):</b>
                            @if ($courierInfo->status == 2)
                                <span class="badge badge--success">@lang('Pauyé')</span>
                            @else
                                <span class="badge badge--danger">@lang('Non Payé')</span>
                            @endif
                          
                        </div>
                    </div>
                    <hr>
                    <div class="invoice-info d-flex justify-content-between">
                        <div>
                            @lang('A')
                            <address>
                                <strong>{{ __(@$courierInfo->sender->nom) }}</strong><br>
                                @lang('Phone'): {{ @$courierInfo->sender->contact }}<br>

                                <!-- @lang('City'): {{ __(@$courierInfo->sender->city) }}<br> -->
                                @lang('Code Postal'): {{ __(@$courierInfo->sender->code_postal) }}<br>
                                <!-- @lang('Email'): {{ @$courierInfo->senderCustomer->email }} -->
                            </address>
                        </div>
                        @if($courierInfo->reftrans)
                        <div>
                            @lang('Destinataire')
                            <address>
                                <strong>{{ __(@$courierInfo->receiver->nom) }}</strong><br>
                                <!-- @lang('City'): {{ __(@$courierInfo->receiverCustomer->city) }}<br> -->
                                <!-- @lang('State'): {{ __(@$courierInfo->receiverCustomer->state) }}<br> -->
                                <!-- @lang('Address'): {{ __(@$courierInfo->receiverCustomer->address) }}<br> -->
                                @lang('Phone'): {{ @$courierInfo->receiver->contact }}<br>
                                <!-- @lang('Email'): {{ @$courierInfo->receiverCustomer->email }} -->
                            </address>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Description')</th>
                                        <th>@lang('Prix')</th>
                                        <th>@lang('Qté')</th>
                                        <th>@lang('Sous-total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courierInfo->products as $courierProductInfo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> @if($courierProductInfo->type_cat_id == 2){{__('DEPOT')}} @else {{__('ENVOI')}} @endif {{ __(@$courierProductInfo->type->name) }}</td>
                                            <td>{{ showAmount($courierProductInfo->fee) }} {{ $general->cur_sym }}</td>
                                            <td>{{ $courierProductInfo->qty }} {{ __(@$courierProductInfo->type->unit->name) }}</td>
                                            <td>{{ showAmount($courierProductInfo->fee) }} {{ $general->cur_sym }}</td>
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
                                            <th>@lang('Sous-total'):</th>
                                            <td>{{ showAmount($courierInfo->paymentInfo->amount) }} {{ $general->cur_sym }}
                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <th>@lang('Total'):</th>
                                            <td>{{ showAmount($courierInfo->paymentInfo->final_amount) }} {{ $general->cur_sym }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
                MERCI DE VOTRE CONFIANCE            </p>
            <p class="text-center">
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> challenge-transit.com</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> Tel:(+33)0179751616 - (+225)0141652222</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i>challengetransit@gmail.com</span>
            </p>
         </div>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-end">
                        @if(!$courierInfo->paymentInfo)
                            <td>@lang('Unpaid')</td>
                        @else
                            @if ($courierInfo->status <= 1 )
                                <button type="button" class="btn btn-outline--success m-1 payment"
                                    data-code="{{ $courierInfo->code }}">
                                    <i class="fa fa-credit-card"></i> @lang('Ajouter Paiement')
                                </button>
                            @endif
                        @endif

                        <button class="btn btn-outline--primary m-1 printInvoice">
                            <i class="las la-download"></i>@lang('Imprimer')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" a>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Payment Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i> </button>
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
@endsection

@push('breadcrumb-plugins')

@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.printInvoice').click(function() {
                $("#printInvoice").printThis();
            });
            $('.payment').on('click', function() {
                var modal = $('#paymentBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
