@extends('staff.layouts.app')
@section('panel')
    <div class="card">
        <div class="card-body">
            <div class="content-header">
                <h3>
                    @lang('Reçu #')
                    <small>{{$courierInfo->reference}}</small>
                </h3>
            </div>

            <div class="invoice">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        @php echo $code @endphp
                    </div>
                    <div class="col-lg-6">
                        <h5 class="float-sm-right">@lang('Date'): {{ showDateTime($courierInfo->created_at, 'd M Y') }}</h5>
                    </div>
                </div>
              <hr>
                <div class="row invoice-info">
                    <div class="col-md-4">
                        @lang('Pour')
                        <address class="font-weight-light">
                            <strong>{{__($courierInfo->client->nom)}}</strong><br>
                            @lang('Tel'): {{__($courierInfo->client->contact)}}<br>
                        </address>
                    </div><!-- /.col -->
                    <div class="col-md-4">
                       
                    </div><!-- /.col -->
                <div class="col-md-4 font-weight-light">
                    <b>@lang('Reçu Id') #{{__($courierInfo->reference)}}</b><br>
                    <br>

                    <b>@lang('Paiement Status'):</b> 
                            <span class="badge badge--success">@lang('Payé')</span>
                    <br>
                    <b>@lang('Agent'):</b> {{__($courierInfo->senderStaff->fullname)}}<br>
                </div>
            </div>

              <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive--md">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Qté')</th>
                                <th>@lang('Sous-total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courierProductInfos as $courierProductInfo)
                            <tr>
                                <td data-label="#">{{$loop->iteration}}</td>
                                <td data-label="Type">{{__($courierProductInfo->type->name)}}</td>
                                <td data-label="Date">{{showDateTime($courierProductInfo->created_at, 'd M Y')}}</td>
                                <td data-label="Qté">{{$courierProductInfo->qty}}</td>
                                <td data-label="Sous-total">{{getAmount($courierProductInfo->fee)}} {{$general->cur_sym}}</td>
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
                                    <th style="width:50%">@lang('Sous-total'):</th>
                                    <td> {{getAmount($courierInfo->montant)}} {{$general->cur_sym}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Total'):</th>
                                    <td>{{getAmount($courierInfo->montant)}} {{$general->cur_sym}}</td>
                                </tr>
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-right">
                        
                        <button class="btn btn-primary m-1 printInvoice"><i class="fa fa-download"></i>@lang('Print')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Payment Confirmation')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{route('staff.courier.payment')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Are you sure to collect this amount?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--success">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    "use strict";
    $('.printInvoice').click(function () { 
        window.print();
        return false;
    });

    $('.payment').on('click', function () {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
</script>
@endpush