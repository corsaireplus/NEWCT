@extends('staff.layouts.app')
@section('panel')
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <form action="{{route('staff.container.store')}}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    @csrf
                    <div class="row">
                        <!-- <div class="form-group">
    <input type="text" name="country_name" id="country_name" class="form-control form-control-lg" placeholder="Enter Country Name" />
    <div id="countryList" class="form-group">
    </div>
   </div>
   {{ csrf_field() }}
  </div>                             -->

                        <div class="form-group col-md-6">
                            <label for="website">@lang('Date Depart')</label>
                            <input type="text" name="date" value="{{old('Date Depart')}}" data-language="en" class="form-control datepicker-here  form-control-lg" placeholder="@lang('Date Depart')" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="website">@lang('Date Arrivée')</label>
                            <input type="text" name="date_arrivee" value="{{old('Date Depart')}}" data-language="en" class="form-control datepicker-here  form-control-lg" placeholder="@lang('Date Arrivée')" required="">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="website">@lang('Armarteur')</label>
                            <input type="text" name="armateur" value="{{old('Armarteur')}}" data-language="en" class="form-control form-control-lg" placeholder="@lang('Armarteur')" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="website">@lang('Numero Conteneur')</label>
                            <input type="text" name="numero" value="{{old('Numero Conteneur')}}" data-language="en" class="form-control form-control-lg" placeholder="@lang('Numero Conteneur')" required="">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="inputMessage">@lang('Observation')</label>
                            <textarea name="message" id="observation" rows="6" class="form-control form-control-lg" placeholder="@lang('Observation ou Note')">{{old('message')}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                            <label for="priority">@lang('Destination')</label>
                            <select name="desti_id" class="form-control form-control-lg">
                                @foreach($branch as $type)
                                <option value="{{$type->id}}">{{ $type->name}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="row form-group">

                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block" id="recaptcha"><i class="fa fa-fw fa-paper-plane"></i> @lang('Enregistrer')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('breadcrumb-plugins')
<a href="{{route('staff.container.liste')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Retour')</a>
@endpush
@push('script-lib')
<script src="{{ asset('assets/staff/js/vendor/datepicker.min.js') }}"></script>
<script src="{{ asset('assets/staff/js/vendor/datepicker.en.js') }}"></script>
@endpush
@push('script')s
<script>
    $(document).ready(function() {

        $('#country_name').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('staff.mission.fetch') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#countryList').fadeIn();
                        $('#countryList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function() {
            $('#country_name').val($(this).text());
            $('#countryList').fadeOut();
        });

    });
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>

@endpush