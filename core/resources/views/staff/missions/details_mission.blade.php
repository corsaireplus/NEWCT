@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div id="impri" class="table-responsive--sm  table-responsive">
                    <table class="table table--light style--two" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Observation')</th>
                                <th>@lang('Code Postal')</th>
                                <th>@lang('Adresse')</th>
                                <th>@lang('Client')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            @forelse($rdv_chauf as $rdv)

                            <tr class="row1" data-id="{{ $rdv->idrdv }}">
                                <td class="pl-3"><i class="fa fa-sort"></i></td>
                                <td data-label="@lang('Date')">
                                    <span class="font-weight-bold">{{date('d-m-Y', strtotime($rdv->date))}}</span>
                                </td>
                                @if($rdv->observation !== NULL)
                                <td data-label="@lang('Observation')">{{$rdv->observation}}</td>
                                @else <td data-label="@lang('Observation')"></td> @endif
                                <td data-label="@lang('Code Postal')">
                                    @if(isset($rdv->adresse->code_postal))
                                    <span>{{$rdv->adresse->code_postal}}</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Adresse')">
                                @if(isset($rdv->adresse->adresse))

                                    <span>{{$rdv->adresse->adresse}}</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Client')">
                                    {{$rdv->client->nom}}

                                </td>

                                <td data-label="@lang('Contact')">
                                    {{$rdv->client->contact}}
                                </td>

                                <td data-label="@lang('Action')">
                                    @if($rdv->status <= 2 ) 
                                         <a href="{{route('staff.mission.validatemission', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--success ml-1 delivery" data-code="{{$rdv->idrdv}}"> Valider @lang('Rdv')</a>
                                        <a href="{{route('staff.rdv.missioncancel', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--danger ml-1 delivery" data-code="{{$rdv->idrdv}}"> Annuler</a>
                                    @else
                                        @if($rdv->transfert)
                                                @if($rdv->transfert->paymentInfo->status == 0 )
                                                <a href="{{route('staff.transfert.edit', encrypt($rdv->transfert->id))}}" title="" > <span class="badge badge--danger">{{$rdv->transfert->reference_souche}}</span></a>
                                                @elseif($rdv->transfert->paymentInfo->status == 1 )
                                                <a href="{{route('staff.transfert.edit', encrypt($rdv->transfert->id))}}" title="" > <span class="badge badge--warning">{{$rdv->transfert->reference_souche}}</span></a>
                                                 @elseif($rdv->transfert->paymentInfo->status == 2)
                                                 <a href="{{route('staff.transfert.edit', encrypt($rdv->transfert->id))}}" title="" > <span class="badge badge--success">{{$rdv->transfert->reference_souche}}</span></a>
                                                 @endif
                                        
                                        @endif
                                        <a href="{{route('staff.rdv.detail', encrypt($rdv->idrdv))}}" title="" class="icon-btn btn--info ml-1 delivery" data-code="{{$rdv->idrdv}}"> Detail</a>
                                        <span class="badge badge-pill bg--success">@lang('Terminé')</span>
                                    @endif
                                        

                                </td>
                            </tr>


                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@push('breadcrumb-plugins')
<!-- <a href="javascript:void(0)" class="btn btn-sm btn--secondary box--shadow1 text--small sendSms" onclick="sendSms({{encrypt($mission->idmission)}},{{$mission->contact}})" data-idmission="{{encrypt($mission->idmission)}}" data-contact="{{$mission->contact}}"><i class="las la-phone"></i>@lang('Sms')</a> -->

<!-- <a href="{{route('staff.mission.send_sms',encrypt($mission->idmission))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-phone"></i> @lang('Envoyer SMS')</a> -->
<a href="{{route('staff.mission.print',encrypt($mission->idmission))}}" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> @lang('Imprimer')</a> <a href="{{route('staff.mission.index')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@endpush
@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script>
    "use strict";
    $('.printInvoice').click(function() {
        var divContents = document.getElementById("impri").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<body > <h1>Div contents are <br>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();

    });

    $('.payment').on('click', function() {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
 
</script>
<script type="text/javascript" language="javascript">
    function printDiv() {
        var divContents = document.getElementById("impri").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<body > <h1>Div contents are <br>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }
    $(function() {

        $("#table").DataTable();

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });
    });

    function sendOrderToServer() {

        var order = [];
        var token = $('meta[name="csrf-token"]').attr('content');

        $('tr.row1').each(function(index, element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index + 1
            });
        });
       
 
        $.ajax({
         url:"{{ route('staff.mission.order_list') }}"+'?_token=' + '{{ csrf_token() }}',
         method:"POST",
         dataType: "json",
         data:{order:order, token:token},
         success:function(response){
            
                if (response.status == "success") {
                    console.log(response);
                } else {
                    console.log(response);
                }
            }
        });

    }
</script>
@endpush