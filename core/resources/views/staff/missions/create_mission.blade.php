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
                                <!-- @if($rdv_dispo->count() > 0)
                            <input type="checkbox" id="chk_all_multiple">
                              @endif -->
                            
                                    <input type="checkbox" class="checkAll"> @lang('Tout Choisir')
                                </th>
                            </th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Observation')</th>
                                    <th>@lang('RDV')</th>
                                    <th>@lang('Adresse')</th>
                                    <th>@lang('Code Postal')</th>
                                    <th>@lang('Contact')</th>
                                    <!-- <th>@lang('Contact')</th> -->
                                    <!-- <th>@lang('RDV')</th> -->
                                  <!-- <th>@lang('Montant')</th> -->
                                    <!-- <th>@lang('Choisir')</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($rdv_dispo as $rdv)
                                <tr>
                                <td>
                                <input type="checkbox" name="ids[]" class="childCheckBox" data-id="{{ $rdv->idrdv }}">
                                </td>
                                <!-- <td data-label="@lang('Selection')">
                    <input type="checkbox" name="ids[]" value="{{ $rdv->idrdv }}" class="checkboxmultiple" id="chk{{ $rdv->idrdv }}" onclick='checkcheckboxmultiple();'>
                           </td> -->
                                    <td data-label="@lang('Date')">
                                        <span class="font-weight-bold">{{date('d-m-Y', strtotime($rdv->date))}}</span>
                                    </td>
                                    @if($rdv->observation !== NULL)
                                <td data-label="@lang('Observation')">{{$rdv->observation}}</td>
                                @else <td data-label="@lang('Observation')"></td> @endif
                                    <td data-label="@lang('RDV')">
                                        @foreach($rdv->rdvDetail as $detail)
                                        @if($detail->rdv_type_id == 2)
                                      DEPOT {{$detail->qty}} {{$detail->type->name}}
                                      @elseif($detail->rdv_type_id == 1 )
                                      RECUP {{$detail->qty}} {{$detail->type->name}}
                                      @endif
                                       @endforeach
                                    </td>
                                    <td data-label="@lang('Adresse')">
                                        <span>{{ optional($rdv->adresse)->adresse ?? 'N/A' }}</span>
                                    </td>
                                    <td data-label="@lang('Code Postal')">
                                        <span>{{ optional($rdv->adresse)->code_postal ?? 'N/A' }}</span>
                                    </td>

                                    <td data-label="@lang('Contact')">
                                    {{$rdv->client->contact}}
                                      
                                    </td>

                                   
                                <!-- <td data-label="@lang('Choisir')">
                                    <a href="javascript:void(0)"  class="icon-btn btn--primary ml-1 editBrach"
                                          data-idmission="{{$mission->idmission}}"
                                            data-idrdv="{{$rdv->idrdv}}"
                                           
                                            data-idchauf="{{$mission->chauffeur_idchauffeur}}"
                                        ><i class="las la-edit"></i></a>
                                    </td>
                                </tr> -->
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{__($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            <tr class="d-none dispatch">
                                    <td colspan="8">
                                        <button class="btn btn-sm btn--primary h-45 w-100 " id="dispatch_all"> <i
                                                class="las la-arrow-circle-right "></i> @lang('Ajouter Au Programme')</button>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
              <tr>
                <th>
                <!-- @if($rdv_dispo->count() > 0)
                <a href="javascript:void(0)" id="bulk_multiple" data-toggle="modal" data-target="#bulkModalmultiple" disabled class="icon-btn btn--primary ml-1 "><i class="las la-edit"></i></a>
                @endif -->
                </th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                {{ paginateLinks($rdv_dispo) }}
                </div>
            </div>
       <!-- <table class="table table-bordered " id="rdvs-table" name="rdvs-table">
        <thead>
            <tr>
        
            <th>@lang('Date')</th>
             <th>@lang('Observation')</th>
            <th>@lang('RDV')</th>
            <th>@lang('Adresse')</th>
            <th>@lang('Code Postal')</th>
            <th>@lang('Contact')</th>
            </tr>
        </thead>
    </table> -->
        </div>
    </div>

    <div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('ajouter RDV')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('staff.mission.storerdv')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idrdv"id="idrdv" >
                    <input type="hidden" name="idchauf"id="idchauf" >
                    <input type="hidden" name="idmission"id="idmission" >

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter RDV')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="bulkModalmultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('ajouter liste RDV')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('staff.mission.storerdvmulti')}}" method="POST">
                    @csrf
                    <div id="bulk_multi_hidden"></div>
                  
                    <input type="hidden" name="idmission"id="idmission" value="{{$mission->idmission}}" >
                    <input type="hidden" name="idchauf"id="idchauf" value="{{$mission->chauffeur_idchauffeur}}" >

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal">@lang('Annuler')</button>
                        <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-paper-plane"></i>@lang('Ajouter RDV')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{route('staff.mission.index')}}" />
    <x-search-form placeholder="Recherche..." />
    <x-date-filter placeholder="Date Debut - Date Fin" />
@endpush
@push('script-lib')
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- App scripts -->
@endpush
@push('script')
    <script>
        "use strict";
        $('.editBrach').on('click', function() {
            var modal = $('#branchModel');
            modal.find('input[id=idrdv]').val($(this).data('idrdv'));
            modal.find('input[id=idchauf]').val($(this).data('idchauf'));
            modal.find('input[id=idmission]').val($(this).data('idmission'));
            $('#branchModel').modal('show');
        });
             
   
    $('#bulk_multiple').on('click',function(){
    // console.log($( "input[name='ids[]']:checked" ).length);
    if($( "input[name='ids[]']:checked" ).length == 0){
      $('#bulk_multiple').prop('type','button');
        new PNotify({
            title: 'Failed!',
            text: "@lang('fleet.delete_error')",
            type: 'error'
          });
        $('#bulk_multiple').attr('disabled',true);
    }
    if($("input[name='ids[]']:checked").length > 0){
      // var favorite = [];
      $.each($("input[name='ids[]']:checked"), function(){
          // favorite.push($(this).val());
          $("#bulk_multi_hidden").append('<input type=hidden name=ids[] value='+$(this).val()+'>');
      });
      // console.log(favorite);
    }
  });


  $('#chk_all').on('click',function(){
    if(this.checked){
      $('.checkbox').each(function(){
        $('.checkbox').prop("checked",true);
      });
    }else{
      $('.checkbox').each(function(){
        $('.checkbox').prop("checked",false);
      });
    }
  });
  $('#chk_all_multiple').on('click',function(){
    if(this.checked){
      $('.checkboxmultiple').each(function(){
        $('.checkboxmultiple').prop("checked",true);
      });
    }else{
      $('.checkboxmultiple').each(function(){
        $('.checkboxmultiple').prop("checked",false);
      });
    }
  });
  // Checkbox checked
  function checkcheckbox(){
    // Total checkboxes
    var length = $('.checkbox').length;
    // Total checked checkboxes
    var totalchecked = 0;
    $('.checkbox').each(function(){
        if($(this).is(':checked')){
            totalchecked+=1;
        }
    });
    // console.log(length+" "+totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        $("#chk_all").prop('checked', true);
    }else{
        $('#chk_all').prop('checked', false);
    }
  }
  function checkcheckboxmultiple(){
    // Total checkboxes
    var length = $('.checkboxmultiple').length;
    // Total checked checkboxes
    var totalchecked = 0;
    $('.checkboxmultiple').each(function(){
        if($(this).is(':checked')){
            totalchecked+=1;
        }
    });
    // console.log(length+" "+totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        $("#chk_all_multiple").prop('checked', true);
    }else{
        $('#chk_all_multiple').prop('checked', false);
    }
  }
    </script>

<script>
    $('#rdvs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('staff.mission.createassign',encrypt($mission->idmission)) }}",
        columns: [
           
            {data: 'date', name: 'date'},
            {data: 'observation', name: 'observation'},
            {data: 'adresse', name: 'adresse'},
            {data: 'code_postal', name: 'code_'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            
        ]
    });
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
                let ids = [];
                $('.childCheckBox:checked').each(function() {
                    ids.push($(this).attr('data-id'))
                })
                let id = ids.join(',')
                let idmission = "{{$mission->idmission}}";
                let idchauf = "{{$mission->chauffeur_idchauffeur}}";
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('staff.mission.storerdvmulti')}}",
                    data: {
                        id: id,
                        idmission :idmission,
                        idchauf : idchauf
                    },
                    success: function(data) {
                        notify('success', 'Rdv Ajouté au programme!')
                        location.reload();
                    }
                })
            });

        })(jQuery)
</script>
@endpush
