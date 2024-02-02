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
                                <th></th>
                                <th>@lang('Date')</th>
                                <th>@lang('ETD')</th>
                                <th>@lang('ETA')</th>
                                <th>@lang('N°CONTENEUR')</th>
                                <th>@lang('N°DOSSIER')</th>
                                <th>@lang('COMP/BATEAU')</th>
                                <th>@lang('Status draft')</th>
                                <th>@lang('Status relache')</th>
                                <th>@lang('Palette')</th>
                                <th>@lang('Montant')</th>
                                <th>@lang('Regle')</th>
                                <th>@lang('Livrer')</th>

                            </tr>
                        </thead>
                        <tbody>
                        @forelse($rdv as $rdvliste)
                        <tr>
                        <td><a href="{{route('staff.suivi.edit', encrypt($rdvliste->id))}}"  class="icon-btn btn--primary "><i class="las la-edit"></i></a>
</td>
                        <td>{{date('d-m-Y', strtotime($rdvliste->date_charge))}}</td>
                        <td>{{$rdvliste->etd ? $rdvliste->etd :"" }}</td>
                        <td>{{$rdvliste->eta ? $rdvliste->eta :"" }}</td>
                        <td>{{$rdvliste->conteneur_num ? $rdvliste->conteneur_num :"" }}</td>
                        <td>{{$rdvliste->dossier_num ? $rdvliste->dossier_num :"" }}</td>
                        <td>{{$rdvliste->comp_bateau ? $rdvliste->comp_bateau :"" }}</td>
                        <td>{{$rdvliste->draft_status ? $rdvliste->draft_status :"" }}</td>
                        <td>{{$rdvliste->relache_status ? $rdvliste->relache_status :"" }}</td>
                        <td>{{$rdvliste->palette? $rdvliste->palette :"" }}</td>
                        <td>{{$rdvliste->montant ? $rdvliste->montant :"" }}</td>
                        <td>{{$rdvliste->regle ? $rdvliste->regle :"" }}</td>
                        <td>{{$rdvliste->livrer ? $rdvliste->livrer :"" }}</td>
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
@endsection
@push('breadcrumb-plugins')
<a href="{{route('staff.suivi.create')}}" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i>@lang('Creer Suivi')</a>

@endpush