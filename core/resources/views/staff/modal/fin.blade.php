<form action="{{route('staff.mission.end')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="code" value="{{$idmission}}">
                <div class="modal-body">
                    <p>@lang('Etes Vous sûr de terminer le programme?')</p>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Terminer')</button>
             </div>
            </form>