<form action="{{route('staff.mission.delete_mission')}}" method="POST">
                    @csrf
                    <input type="hidden" name="idmission"id="idmission" value="{{$idmission}} >
                    <div class="modal-body">
                    <p>@lang('Êtes vous sûr de vouloir Supprimer ce programme ?')</p>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Supprimer')</button>
                 </div>
                </form>