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
                                    <a href="javascript:void(0)" class=" reopen" data-code="{{$mission->idmission}}"><span class="badge badge--danger">@lang('Terminé')</span></a>
                                    @elseif($mission->status == 2)
                                    <a href="{{route('staff.mission.edit', encrypt($mission->idmission))}}"><span class="badge badge--danger">@lang('Terminé')</span></a>
                                    @endif
                                </td>
                                <td>

                                    @if($mission->status == 0)
                                    <a href="{{route('staff.mission.assigne', encrypt($mission->idmission))}}" title="" data-code="{{$mission->idmission}}"class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> Ajouter @lang('RDV')</a>
                                    @if($mission->status == 0 && $mission->rdvs->count() == 0)
                                    <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-idmission="{{$mission->idmission}}"><i class="las la-trash"></i></a> 
                                    @endif
                                    @endif
                                    @if($mission->rdvs->count() > 0 && $mission->status == 0 )
                                    <a href="{{route('staff.mission.detailmission', encrypt($mission->idmission))}}" title="" class="icon-btn btn-outline--success" data-code="{{$mission->idmission}}">@lang('Liste RDV')</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline--secondary sendSms"  data-idmission="{{encrypt($mission->idmission)}}" data-contact="{{$mission->contact}}"><i class="las la-phone"></i>@lang('Sms')</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline--primary depense" data-idmission="{{$mission->idmission}}"><i class="las la-pen"></i>@lang('Depenses')</a>
                                    <a href="javascript:void(0)" title="" class="icon-btn btn--danger ml-1 payment" data-code="{{$mission->idmission}}">@lang('Finir')</a>
                                    @endif
                                    
                                    @if($mission->status == 1)
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
<x-confirmation-modal />
<div class="modal fade" id="depenseBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Ajouter Depense')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
            </div>

            <form action="{{route('staff.transaction.store_depense')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="idmission">
                    <input type="hidden" name="cat_id" value="10">
                    <p>@lang('Entrez Information Depense')</p>
                    <div class="form-group">
                        

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control" name="montant" id="montant" placeholder="Montant Depense">
                        </div>
                      
                        
                            <label for="inputMessage">@lang('Entrer Description')</label>
                            <textarea name="description" id="description" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>

                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--primary">@lang('Enregistrer')</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('SUPPRIMER PROGRAMME')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="{{route('staff.mission.delete_mission')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idmission"id="idmission" >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer ce programme ?')</p>
                </div>

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-fw fa-trash"></i>@lang('Supprimer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Terminer Programme')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.mission.end')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de terminer le programme?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirmer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ropenBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Rouvrir Programme')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.mission.reopen')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de rouvrir le programme?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success">@lang('Confirmer')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="smsModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('ENVOYER SMS AUX CLIENTS')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.mission.send_sms')}}" method="POST">
                @csrf
                <input type="hidden" name="idmission" id="idmission">
                <input type="hidden" name="contact" id="contact">

                <div class="modal-body">
                      <div class="form-group">
                        
                            <label for="inputMessage">@lang('Entrer Message')</label>
                            <textarea name="message" id="message" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>
                        
                        </div>

               <p>NB: SMS non valable les dimanches et jour ferié</p>
                    <p>@lang('Êtes vous sûr de vouloir envoyer les sms?')</p>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-phone"></i>@lang('Envoyer')</button>
                </div>
            </form>
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
<!-- <form action="{{route('staff.rdv.search')}}" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="@lang('Contact Client')" value="{{ $search ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form> -->
@endpush

@push('script')
<script>
    "use strict";
    $('.depense').on('click', function() {
        var modal = $('#depenseBy');
        modal.find('input[name=idmission]').val($(this).data('idmission'))
        // modal.modal('show');
        $('#depenseBy').modal('show');
    });
    $('.payment').on('click', function() {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        // modal.modal('show');
        $('#paymentBy').modal('show');
    });
    $('.reopen').on('click', function() {
        var modal = $('#ropenBy');
        modal.find('input[name=code]').val($(this).data('code'))
        // modal.modal('show');
        $('#ropenBy').modal('show');
    });
    $('.deletePaiement').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=idmission]').val($(this).data('idmission'))
        modal.modal('show');
    });
    $('.sendSms').on('click', function() {
        var modal = $('#smsModel');
        modal.find('input[name=idmission]').val($(this).data('idmission'))
        modal.find('input[name=contact]').val($(this).data('contact'))
        modal.modal('show');
    });
</script>
@endpush