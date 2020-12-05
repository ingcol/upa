<div class="search-area">
    <div class="search-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form action="#" class="d-md-flex justify-content-between">
                        <select   title=" " data-live-search="true" data-style="form-control border" class="selectpicker form-control  {{ $errors->has('subcategoria_id') ? ' is-invalid' : '' }}" name="subcategoria_id" id="subcategoria_id" required>
                            @foreach ($categorias as $categoria)
                            <optgroup label="{{$categoria->nombre}}">
                              @foreach ($categoria->subcategorias as $subcategoria)
                              <option {{ (int) old('subcategoria_id') === $subcategoria->id  ? 'selected' : '' }} value="{{$subcategoria->id}}">{{$subcategoria->nombre}}</option> 
                              @endforeach
                            </optgroup>
                            @endforeach
                          </select>   
                        <select>
                            <option value="1">Select Location</option>
                            <option value="2">Dhaka</option>
                            <option value="3">Rajshahi</option>
                            <option value="4">Barishal</option>
                            <option value="5">Noakhali</option>
                        </select>
                        <input type="text" placeholder="Search Keyword" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'" required>
                        <button type="submit" class="template-btn">find job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>