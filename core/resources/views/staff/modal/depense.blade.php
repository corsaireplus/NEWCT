<form action="{{route('staff.transaction.store_depense')}}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <input type="hidden" name="idmission" value="{{$idmission}}">
                    <input type="hidden" name="cat_id" value="10">
                    <p>@lang('Entrez Information Depense')</p>
                    <div class="form-group">
                        

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control" name="montant" id="montant" placeholder="Montant Depense">
                        </div>
                        <div class="form-group col-lg-6">
                        <select  class="form-control" name="cat_id" id="cat_id">
                       @foreach($categorie as $type)
                        <option value="{{$type->id}}">{{$type->nom}}</option>
                        @endforeach
                        </select>
                        </div>
                            <label>@lang('Entrer Description')</label>
                            <textarea name="description" id="description" rows="4" class="form-control form-control-lg" placeholder="@lang('Entrer Message')">{{old('message')}}</textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary">@lang('Ajouter Depense')</button>
                  </div>
                  
            </form>