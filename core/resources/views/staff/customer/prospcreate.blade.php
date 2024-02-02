@extends('staff.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('staff.prospect.store')}}" method="POST">
                        @csrf
                        <div class="row">
                        <div class="form-group col-lg-6">
                                <label for="phone" class="form-control-label font-weight-bold">@lang('Téléphone')*</label>
                                <input type="text" class="form-control form-control-lg" id="contact" name="contact" value="{{old('contact')}}"  maxlength="40" >
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="fname" class="form-control-label font-weight-bold">@lang('Nom & prénom')</label>
                                <input type="text" class="form-control form-control-lg" id="nom" name="nom" value="{{old('nom')}}"  maxlength="40" >
                            </div>
                           
                             
                        </div>
                        @if(auth()->user()->branch_id == 1)
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="fname" class="form-control-label font-weight-bold">@lang('Adresse')</label>
                                <input type="text" class="form-control form-control-lg" id="adresse" name="adresse" value="{{old('adresse')}}"  >
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="phone" class="form-control-label font-weight-bold">@lang('Code Postal')</label>
                                <input type="text" class="form-control form-control-lg" id="code" name="code" value="{{old('code')}}"  maxlength="40" >
                            </div>
                             
                        </div>
                        
                        @endif
                        <div class="row">
                                                   
                            <div class="form-group col-lg-6">
                                <label for="email" class="form-control-label font-weight-bold">@lang('Message')</label>
                                <textarea class="form-control form-control-lg" id="message" name="message"  >{{old('message')}}</textarea>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="email" class="form-control-label font-weight-bold">@lang('Action')</label>
                                <textarea class="form-control form-control-lg" id="action" name="action"  >{{old('action')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> @lang('Enregistrer')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('staff.prospect.list') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> @lang('Go Back')</a>
@endpush
@push('script')
<script>
    
    $(document).ready(function() {
    
$('#contact').keyup(function() {
            var query = $(this).val();

            if (query != '' && query.length == 10) {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('staff.rdv.fetch') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $("#nom").val(response.nom);
                            $("#adresse").val(response.adresse);
                            $("#code").val(response.code_postal);
                        }

                    }
                });
            }
        });

    });
    </script>
    @endpush