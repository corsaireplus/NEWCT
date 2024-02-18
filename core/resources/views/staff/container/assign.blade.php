@extends('staff.layouts.app')
@section('panel')

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>
                                    @if($colis_dispo->count() > 0)
                                    <input type="checkbox" class="checkAll" id="chk_all_multiple">
                                    @endif
                                </th>
                                <th>@lang('Date')</th>
                                <th>@lang('Reference Colis')</th>
                                <th>@lang('Nb Colis')</th>
                                <th>@lang('Nb Chargé')
                                <th>@lang('Expediteur')</th>
                                <th>@lang('Contact')</th>
                                <!-- <th>@lang('Choisir')</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($colis_dispo as $rdv)
                            @if($rdv->transfertDetail->count() > 0)
                            <tr>
                                <td data-label="@lang('Selection')">
                                    <input type="checkbox"  data-id="{{ $rdv->id }}" name="ids[]" value="{{ $rdv->id }}" class="checkboxmultiple childCheckBox" id="chk{{ $rdv->id }}" onclick='checkcheckboxmultiple();'>
                                </td>
                                <td data-label="@lang('Date')">
                                    <span>{{date('d-m-Y', strtotime($rdv->created_at))}}</span>
                                </td>
                                <td data-label="@lang('Reference Colis')">
                                <span class="badge badge--primary"> {{$rdv->reftrans}}    </span>
                                </td>
                                <td data-label="@lang('Nb Colis')">
                                <span> {{$rdv->transfertDetail->count()}}    </span>
                                </td>
                                <td data-label="@lang('Nb Colis Charge')">
                                    @if($rdv->transfertDetail->count() > 1)
                                    <input value="" name="{{$rdv->id}}" id="{{$rdv->id}}" type="number"/>
                                    @else
                                    <input type="hidden" name="{{$rdv->id}}" id="{{$rdv->id}}" data-nb="{{$rdv->id}}" value="1"/>
                                    @endif
                                </td>
                                <td data-label="@lang('Expediteur')">
                                    <span>{{$rdv->sender->nom}}</span>
                                </td>
                                <td data-label="@lang('Contact')">
                                    {{$rdv->sender->contact}}

                                </td>
                                <!-- <td data-label="@lang('Choisir')">
                                    <a href="javascript:void(0)" class="icon-btn btn--primary ml-1 editBrach" data-idmission="{{$mission->idcontainer}}" data-idrdv="{{$rdv->id}}" data-idchauf="{{$mission->chauffeur_idchauffeur}}"><i class="las la-edit"></i></a>
                                </td> -->
                            </tr>
                            @endif
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                            </tr>
                            @endforelse
                            <tr class="d-none dispatch">
                                    <td colspan="8">
                                        <button class="btn btn-sm btn--primary h-45 w-100 " id="dispatch_all"> <i
                                                class="las la-arrow-circle-right "></i> @lang('Ajouter Au Conteneur')</button>
                                    </td>
                            </tr>

                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th>
                                    @if($colis_dispo->count() > 0)
                                    <a href="javascript:void(0)" id="bulk_multiple" data-toggle="modal" data-target="#bulkModalmultiple" disabled class="icon-btn btn--primary ml-1 "><i class="las la-edit"></i></a> @endif
                                </th>
                        </tfoot> -->
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                {{ paginateLinks($colis_dispo) }}
            </div>
        </div>
    </div>
</div>

<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('ajouter Colis Au Conteneur')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('staff.conteneurs.storeone')}}" method="POST">
                @csrf
                <input type="hidden" name="idrdv" id="idrdv">
                <input type="hidden" name="idchauf" id="idchauf">
                <input type="hidden" name="idmission" id="idmission">
                <input type="hidden" name="nbcolis" id="nbcolis">
 

                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                    <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter Colis')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="bulkModalmultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('ajouter liste colis au conteneur')</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <form action="{{route('staff.conteneurs.storemulti')}}" method="POST">
                @csrf
                <div id="bulk_multi_hidden"></div>

                <input type="hidden" name="idmission" id="idmission" value="{{$mission->idcontainer}}">
                <input type="hidden" name="idchauf" id="idchauf" value="{{$mission->chauffeur_idchauffeur}}">


                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Ajouter')</button>
              </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('breadcrumb-plugins')
 <x-search-form placeholder="Recherche..." />
 <x-date-filter placeholder="Date Debut - Date Fin" />
     <x-back route="{{route('staff.conteneurs.index')}}" />

@endpush

@push('script')
<script>
    "use strict";
    $('.editBrach').on('click', function() {
        var modal = $('#branchModel');
        var id = $(this).data('idrdv');
        var inp =  $('#'+id).val();
        console.log(inp);
        modal.find('input[id=idrdv]').val($(this).data('idrdv'));
        modal.find('input[id=idchauf]').val($(this).data('idchauf'));
        modal.find('input[id=idmission]').val($(this).data('idmission'));
        modal.find('input[id=nbcolis]').val(inp);
        $('#branchModel').modal('show');
    });


    $('#bulk_multiple').on('click', function() {
        // console.log($( "input[name='ids[]']:checked" ).length);
        if ($("input[name='ids[]']:checked").length == 0) {
            $('#bulk_multiple').prop('type', 'button');
            new PNotify({
                title: 'Failed!',
                text: "@lang('fleet.delete_error')",
                type: 'error'
            });
            $('#bulk_multiple').attr('disabled', true);
        }
        if ($("input[name='ids[]']:checked").length > 0) {
            // var favorite = [];
            $.each($("input[name='ids[]']:checked"), function() {
                // favorite.push($(this).val());
                var inp =  $('#'+$(this).val()).val();
                $("#bulk_multi_hidden").append('<input type=hidden name=ids[] value=' + $(this).val() + '>');
                $("#bulk_multi_hidden").append('<input type=hidden name=nbcolis[] value=' + inp + '>');

            });
            // console.log(favorite);
        }
    });


    $('#chk_all').on('click', function() {
        if (this.checked) {
            $('.checkbox').each(function() {
                $('.checkbox').prop("checked", true);
            });
        } else {
            $('.checkbox').each(function() {
                $('.checkbox').prop("checked", false);
            });
        }
    });
    $('#chk_all_multiple').on('click', function() {
        if (this.checked) {
            $('.checkboxmultiple').each(function() {
                $('.checkboxmultiple').prop("checked", true);
            });
        } else {
            $('.checkboxmultiple').each(function() {
                $('.checkboxmultiple').prop("checked", false);
            });
        }
    });
    // Checkbox checked
    function checkcheckbox() {
        // Total checkboxes
        var length = $('.checkbox').length;
        // Total checked checkboxes
        var totalchecked = 0;
        $('.checkbox').each(function() {
            if ($(this).is(':checked')) {
                totalchecked += 1;
            }
        });
        // console.log(length+" "+totalchecked);
        // Checked unchecked checkbox
        if (totalchecked == length) {
            $("#chk_all").prop('checked', true);
        } else {
            $('#chk_all').prop('checked', false);
        }
    }

    function checkcheckboxmultiple() {
        // Total checkboxes
        var length = $('.checkboxmultiple').length;
        // Total checked checkboxes
        var totalchecked = 0;
        $('.checkboxmultiple').each(function() {
            if ($(this).is(':checked')) {
                totalchecked += 1;
            }
        });
        // console.log(length+" "+totalchecked);
        // Checked unchecked checkbox
        if (totalchecked == length) {
            $("#chk_all_multiple").prop('checked', true);
        } else {
            $('#chk_all_multiple').prop('checked', false);
        }
    }
</script>
<script>
        (function($) {
            "use strict";
            $(".childCheckBox").on('change', function(e) {
                let totalLength = $(".childCheckBox").length;
                let checkedLength = $(".childCheckBox:checked").length;
                if (totalLength == checkedLength) {
                    $('.checkAll').prop('checked', true);
                } else {
                    $('.checkAll').prop('checked', false);
                }
                if (checkedLength) {
                    $('.dispatch').removeClass('d-none')
                } else {
                    $('.dispatch').addClass('d-none')
                }
            });

            $('.checkAll').on('change', function() {
                if ($('.checkAll:checked').length) {
                    $('.childCheckBox').prop('checked', true);
                } else {
                    $('.childCheckBox').prop('checked', false);
                }
                $(".childCheckBox").change();
            });
            $('#dispatch_all').on('click', function() {
            
                        if ($("input[name='ids[]']:checked").length == 0) {
                        $('#bulk_multiple').prop('type', 'button');
                        new PNotify({
                            title: 'Failed!',
                            text: "@lang('fleet.delete_error')",
                            type: 'error'
                        });
                        $('#bulk_multiple').attr('disabled', true);
                        }
                    if ($("input[name='ids[]']:checked").length > 0) {
                        // var favorite = [];
                        $.each($("input[name='ids[]']:checked"), function() {
                            // favorite.push($(this).val());
                            var inp =  $('#'+$(this).val()).val();
                            $("#bulk_multi_hidden").append('<input type=hidden name=ids[] value=' + $(this).val() + '>');
                            $("#bulk_multi_hidden").append('<input type=hidden name=nbcolis[] value=' + inp + '>');

                        });
                         }
                var modal = $('#bulkModalmultiple');
                $('#bulkModalmultiple').modal('show');
                // let ids = [];
                // let nbs = [];
                // $('.childCheckBox:checked').each(function() {
                //     ids.push($(this).attr('data-id'))
                // })
                // let id = ids.join(',')
                // $.ajax({
                //     type: "POST",
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     url: "{{ route('staff.courier.dispatch.all') }}",
                //     data: {
                //         id: id
                //     },
                //     success: function(data) {
                //         notify('success', 'Colis ajouté avec succès')
                //         location.reload();
                //     }
                // })
            });

        })(jQuery)
    </script>
@endpush