@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table white-space-wrap">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Chauffeur - Chargeur')</th>
                                <th>@lang('Nb RDV')</th>
                                <th>@lang('M. Prevu -M. Encaissé')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($missions as $key => $mission)
                            <tr>
                                <td>{{date('d-m-Y', strtotime($mission->date))}}</td>
                                <td><span>
                                    {{$mission->chauffeur->firstname}}
                                        </span>
                                   <br>
                                   {{$mission->chargeur->firstname}}
                                </td>

                               
                               

                                <td data-label="@lang('Nb RDV')">{{$mission->rdvs->count()}}</td>
                                        <td><span class="fw-bold d-block">
                                             {{getAmount($mission->rdvs->sum('montant'))}}{{ $general->cur_text }} </span>
                                             @if($mission->rdvs->sum('encaisse') > 0 ){{getAmount( ($mission->rdvs->sum('encaisse') - ($mission->depenses) ))}}{{ $general->cur_text }} @endif
                                            </td>
                                    <td>
                                    @if($mission->status == 0)
                                    <a href="{{route('staff.mission.edit', encrypt($mission->idmission))}}"><span class="badge badge--success">@lang('En Cours')</span></a>
                                    @elseif($mission->status == 1)
                                    <a href="javascript:void(0)" class=" open-modal-btn" data-code="reopen" data-idmission="{{$mission->idmission}}"><span class="badge badge--danger">@lang('Terminé')</span></a>
                                    @elseif($mission->status == 2)
                                    <a href="{{route('staff.mission.edit', encrypt($mission->idmission))}}"><span class="badge badge--danger">@lang('Terminé')</span></a>
                                    @endif
                                </td>
                                <td>

                                    @if($mission->status == 0)
                                    <a href="{{route('staff.mission.assigne', encrypt($mission->idmission))}}" title="" data-code="{{$mission->idmission}}"class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> Ajouter @lang('RDV')</a>
                                    @if($mission->status == 0 && $mission->rdvs->count() == 0)
                                    <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 open-modal-btn" data-code="delete" data-idmission="{{$mission->idmission}}"><i class="las la-trash"></i></a> 
                                    @endif
                                    @endif
                                    @if($mission->rdvs->count() > 0 && $mission->status == 0 )
                                    <a href="{{route('staff.mission.detailmission', encrypt($mission->idmission))}}" title="" class="icon-btn btn-outline--success" data-code="{{$mission->idmission}}">@lang('Liste RDV')</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline--secondary open-modal-btn" data-code="sms" data-idmission="{{encrypt($mission->idmission)}}"><i class="las la-phone"></i>@lang('Sms')</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline--primary open-modal-btn"  data-code="depense" data-idmission="{{$mission->idmission}}"><i class="las la-pen"></i>@lang('Depenses')</a>
                                    <a href="javascript:void(0)" title="" class="icon-btn btn--danger ml-1 open-modal-btn" data-code="fin" data-idmission="{{$mission->idmission}}">@lang('Finir')</a>
                                    @endif
                                    
                                    @if($mission->status == 1)
                                    <a href="{{route('staff.mission.bilan', encrypt($mission->idmission))}}"  class="btn btn-sm btn-outline--primary "><i class="las la-file-invoice"></i> Bilan </a>
                                    <a href="{{route('staff.mission.detailmissionend', encrypt($mission->idmission))}}" title="" class="icon-btn btn--success ml-1 " data-code="{{$mission->idmission}}">@lang('Details')</a>
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
                {{ paginateLinks($missions) }}
            </div>
        </div>
    </div>
</div>

<!-- Ajoutez un bouton ou un lien avec une classe "open-modal-btn" -->
<!-- <button class="btn btn-primary open-modal-btn" data-code="votre_code">Ouvrir le Modal</button> -->

<!-- Placez la balise vide pour le modal à la fin de votre fichier Blade -->
<div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dynamicModalLabel">Programme</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <!-- Contenu du modal qui sera rempli dynamiquement par JavaScript -->
            </div>
            
        </div>
    </div>
</div>



@endsection

@push('breadcrumb-plugins')
<a href="{{route('staff.mission.create')}}" >
<button type="button" class="btn btn-outline--primary m-1">
                                    <i class="fa la-plus"></i> @lang('Creer Programme')
                                </button>
                                </a>
    <x-search-form placeholder="Recherche..." />
    <x-date-filter placeholder="Date Debut - Date Fin" />

@endpush
@push('script-lib')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@push('script')
<script>

$(document).ready(function() {
        // Assumez que vous avez un bouton ou un lien avec une classe "open-modal-btn"
        $('.open-modal-btn').on('click', function() {
            var code = $(this).data('code');
            var idmission = $(this).data('idmission');

            // Effectuez une requête AJAX pour récupérer les données du modal
            $.post('{{ route('staff.open-modal') }}', { code: code, _token: "{{ csrf_token() }}",idmission:idmission }, function(response) {
                // Ajoutez le contenu au modal
                $('#dynamicModal .modal-body').html(response);

                // Ouvrez le modal
                $('#dynamicModal').modal('show');
            });
        });
    });
//     (function($) {
  
//     $('.depense').on('click', function() {
//         var modal = $('#depenseBy');
//         modal.find('input[name=idmission]').val($(this).data('idmission'))
//         // modal.modal('show');
//         $('#depenseBy').modal('show');
//     });
//     $('.payment').on('click', function() {
//         var modal = $('#paymentBy');
//         modal.find('input[name=code]').val($(this).data('code'))
//         // modal.modal('show');
//         $('#paymentBy').modal('show');
//     });
//     $('.reopen').on('click', function() {
//         var modal = $('#ropenBy');
//         modal.find('input[name=code]').val($(this).data('code'))
//         // modal.modal('show');
//         $('#ropenBy').modal('show');
//     });
//     $('.deletePaiement').on('click', function() {
//         var modal = $('#branchModel');
//         modal.find('input[name=idmission]').val($(this).data('idmission'))
//         modal.modal('show');
//     });

//     $('.envoiSms').off('click').on('click', function() {
//         var modal = $('#envoiSms');
//         modal.find('input[name=mission]').val($(this).data('mission'))
//         modal.find('input[name=contact]').val($(this).data('contact'))
//         $('#envoiSms').modal('show');
//     });
    
//   })(jQuery)
</script>


@endpush