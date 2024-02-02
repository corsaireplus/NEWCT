@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="row mt-30">
            <div class="col-lg-12">
                <div class="card b-radius--10 ">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light style--two custom-data-table white-space-wrap">
                                <thead>
                                    <tr>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Staff')</th>
                                        <th>@lang('Categorie')</th>
                                        <th>@lang('Montant')</th>
                                        <th>@lang('Description')</th>
                                        <th>@lang('Action')</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($depenses as $trans)

                                    <tr>
                                        <td data-label="@lang('Date')">
                                            <span>{{showDateTime($trans->created_at, 'd M Y')}}</span><br>
                                            <!-- <span>{{diffForHumans($trans->created_at) }}</span> -->
                                        </td>
                                        <td data-label="@lang('Staff')">

                                            {{__($trans->staff->fullname)}}
                                        </td>

                                        <td data-label="@lang('Categorie')">
                                            @if($trans->categorie)
                                            <span>
                                                {{__($trans->categorie->nom)}}
                                                @else
                                                <span>N/A</span>

                                                @endif

                                        </td>
                                        <td data-label="@lang('Montant')">
                                            <span class="font-weight-bold">
                                                {{getAmount($trans->montant)}} {{ auth()->user()->branch->currencie }}
                                            </span>
                                        </td>
                                        <td>{{$trans->description}}</td>
                                        <td>
                                            <a href="{{route('staff.transaction.get_depense', encrypt($trans->id))}}"><span class="badge badge--primary">@lang('modifier')</span></a>
                                            <a href="javascript:void(0)" class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="{{$trans->id}}"><i class="las la-trash"></i></a>
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
                        {{ paginateLinks($depenses) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('SUPPRIMER DEPENSE')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('staff.transaction.delete_depense')}}" method="POST">
                @csrf
                <input type="hidden" name="refpaiement" id="refpaiement">
                <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer cette depense ?')</p>
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
<form action="{{route('staff.expense.date.search')}}" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append ">
        <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="@lang('Min date - Max date')" autocomplete="off" value="{{ @$dateSearch }}">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
<a href="{{route('staff.transaction.create_depense')}}" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter Depense')</a>
@endpush
@push('script-lib')
<script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')
<script>
    "use strict";
    $('.deletePaiement').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=refpaiement]').val($(this).data('refpaiement'))
        modal.modal('show');
    });
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>
@endpush