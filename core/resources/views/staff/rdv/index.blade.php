@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
          <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('Action')</th>
                                <th>@lang('Date RDV')</th>
                                <th>@lang('Observation')</th>
                                <th>@lang('Client')</th>
                                <th>@lang('Contact')</th>
                                <th>@lang('Code Postal')</th>
                                <th>@lang('Adresse')</th>
                                <th>@lang('Status')</th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rdv as $rdvliste)
                            <tr>
                            <td>
                                    <!-- <a href="{{route('staff.rdv.details', encrypt($rdvliste->idrdv))}}" title="" class="icon-btn btn--success ml-1"><i class="las la-edit"></i></a> -->

                                    <a href="{{route('staff.rdv.details', encrypt($rdvliste->idrdv))}}"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-pen"></i>@lang('Edit')
                                            </a>
                                    <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="{{$rdvliste->idrdv}}"><i class="las la-trash"></i></a>

                                <!-- <a href="{{route('staff.rdv.edit', encrypt($rdvliste->idrdv))}}" title="Annuler RDV" class="icon-btn btn--danger ml-1">@lang('Annuler')</a> -->

                                </td>
                                <td >{{date('d-m-Y', strtotime($rdvliste->date))}}</td>
                                @if($rdvliste->observation !== NULL)
                                <td >{{$rdvliste->observation}}</td>
                                @else <td></td> @endif
                                <td >{{$rdvliste}}</td>
                                <td >{{$rdvliste->client->contact}}</td>
                                @if($rdvliste->adresse)
                                <td >{{$rdvliste->adresse->code_postal}}</td>
                                
                                @else
                                <td >N/A</td>
                             
                                @endif
                                @if($rdvliste->adresse)
                                <td >{{$rdvliste->adresse->adresse}}</td>
                                @else
                                <td >N/A</td>
                                @endif
                                <td > @if($rdvliste->status == 0 && $rdvliste->chauffeur )
                                    <span class="badge badge--primary">@lang('En Cours')</span>
                                    @elseif($rdvliste->status == 0 && !$rdvliste->chauffeur )
                                    <span class="badge badge--danger">@lang('Non Assigné')</span>
                                    @elseif($rdvliste->status == 1)
                                    <span class="badge badge--success">@lang('Delivery')</span>
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
                {{ paginateLinks($rdv) }}
            </div>
        </div> 
    </div>
    
</div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('SUPPRIMER RDV')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="{{route('staff.rdv.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="refpaiement"id="refpaiement" >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer ce rdv ?')</p>
                </div>

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-fw fa-trash"></i>@lang('Supprimer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
<a href="{{route('staff.rdv.create')}}" >
<button type="button" class="btn btn-outline--primary m-1 payment">
                                    <i class="fa la-plus"></i> @lang('Creer RDV')
                                </button>
                                </a>
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
    $('.deletePaiement').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=refpaiement]').val($(this).data('refpaiement'))
        modal.modal('show');
    });
</script>
@endpush