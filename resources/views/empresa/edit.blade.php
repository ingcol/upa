@extends('layouts.app')
@section('content')
<div class="main-content">
  <div  class="contenedor">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row align-items-end">
          <div class="col-lg-8">
            <div class="page-header-title">
             <div class="d-inline">
               <h5>Editar empresa</h5>
             </div>
           </div>
         </div>
         <div class="col-lg-4">

         </div>
       </div>
     </div>
     <hr>



     <div class="row ">
      <div class="col-md-12">
        @if($empresa->id) 
        <div class="border p-3 mb-3 bg-light">
          <div class="mt-2 mb-2">

            <h6>Galería de la empresa</h6>
          </div>
          <div class="form-group">
            <form action="{{route('upload')}}" class="dropzone"  id="dropzonegaleria"> <input type="hidden" name="empresa_id" value={{$empresa->id}}>
             <span>Arrastra hasta 3 imágenes aquí para subirlas </span>
           </form>
         </div><small id="descriptionHelp" class="form-text text-muted mt-2">Tamaño recomendado de 1024*576.</small>

         @if(count($empresa->galeria))
         <div class="container">
          <div class="card-columns">

            @foreach ($empresa->galeria as $imagen)

            <div class="card">
              <img class="card-img-top" src="{{Storage::disk('s3')->url('empresas/'.$imagen->url)}}" alt="{{$imagen->descripcion}}" style="display:inline-block">
              <div class="card-body text-right">
                @if (Auth::check())                            
                <span data-id={{$imagen->id}} data-action={{route('galeria.destroy',$imagen->id)}} data-toggle="modal" data-target="#delete"><button class="btn btn-danger btn-sm" data-placement="bottom" title="Eliminar" data-toggle="tooltip" onclick="del({{$imagen->id}})">Eliminar</button></span>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    
    @endif
    <div class="border p-3 mb-3 bg-light">
      <div class="mt-2 mb-2">

        <h6>Galería de portafolio o menú</h6>
      </div>

      <div class="form-group">
        <form action="{{route('uploadMenu')}}" class="dropzone"  id="dropzonemenu"> <input type="hidden" name="empresa_id" value={{$empresa->id}}>
          <span>Arrastra hasta 10 imágenes aquí para subirlas </span>

        </form>
      </div><small  class="form-text text-muted mt-2">Tamaño recomendado de 1024*576.</small>



      @if(count($empresa->menus))
      <div class="container">
        <div class="card-columns">

          @foreach ($empresa->menus as $menu)

          <div class="card">
            <img class="card-img-top" src="{{Storage::disk('s3')->url('menu/'.$menu->file)}}"  style="display:inline-block">
            <div class="card-body text-right">
              @if (Auth::check())  
              <span id="imgDel" data-id="{{$menu->id}}"></span>

              <span data-id="{{$menu->id}}" data-toggle="modal" data-target="#deleteMenu"><button class="btn btn-danger btn-sm" data-placement="bottom" title="Eliminar" data-toggle="tooltip" onclick="delMenu({{$menu->id}})">Eliminar</button></span>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>

      @endif



    </div>
    @endif

    <form id="formempresa" class="form" method="POST" action="{{ ! $empresa->id ? route('empresas.store') : route('empresas.update', $empresa->id)}}" enctype="multipart/form-data">
      @if($empresa->id) 
      @method('PUT') 
      @endif
      @csrf
      <div class="form-group">
        <label for="ciudad" class="form-label">Ciudad</label>
        <select  title=" " data-live-search="true" data-style="form-control border " class="selectpicker  form-control  {{ $errors->has('ciudad_id') ? ' is-invalid' : '' }}" name="ciudad_id" id="ciudad_id" required>
          @foreach ($estados as $estado)
          <optgroup label="{{$estado->nombre}}">
            @foreach ($estado->ciudades as $ciudad)
            <option class="text-warning" {{ (int) old('ciudad_id') === $ciudad->id || $empresa->ciudad_id === $ciudad->id ? 'selected' : '' }} value="{{$ciudad->id}}">{{$ciudad->nombre}}</option> 
            @endforeach
          </optgroup>
          @endforeach
        </select>           
        @error('ciudad_id')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="nombre" class="form-label">Nombre</label>
        <input name="nombre" id="nombre" class="form-control  {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{ old('nombre') ?: $empresa->nombre }}"
        required autofocus/>
        @error('nombre')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="subcategoria" class="form-label">Categoria</label>
        <select   title=" " data-live-search="true" data-style="form-control border" class="selectpicker form-control  {{ $errors->has('subcategoria_id') ? ' is-invalid' : '' }}" name="subcategoria_id" id="subcategoria_id" >
          @foreach ($categorias as $categoria)
          <optgroup label="{{$categoria->nombre}}">
            @foreach ($categoria->subcategorias as $subcategoria)
            <option class="text-warning" {{ (int) old('subcategoria_id') === $subcategoria->id || $empresa->subcategoria_id === $subcategoria->id ? 'selected' : '' }} value="{{$subcategoria->id}}">{{$subcategoria->nombre}}</option> 
            @endforeach
          </optgroup>

          @endforeach
        </select>           
        @error('categoria_id')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="subcategoria" class="form-label">Estado</label>

        <select class="form-control" name="estado"  id="estado">
          @if($empresa->estado=="1")
          <option value="1">Activo
          </option>
          <option value="">Inactivo</option>

          @else

          <option value="">Inactivo</option> 
          <option value="1">Activo</option>
          @endif
        </select>


        @error('plan')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="subcategoria" class="form-label">Plan</label>

        <select class="form-control" name="plan"  id="plan">
          @if($empresa->plan=="gratis")
          <option value="gratis">Gratis
          </option>
          <option value="">Pago</option>

          @else

          <option value="">Pago</option> 
          <option value="gratis">Gratis</option>
          @endif
        </select>


        @error('plan')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="celular" class="form-label">Celular</label>
        <input type="number" name="celular" id="celular" class="form-control   {{ $errors->has('celular') ? ' is-invalid' : '' }}" value="{{ old('celular') ?: $empresa->celular }}" required/>
        @error('celular')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="whatsapp" class="form-label">Whatsapp</label>
        <input type="number" name="whatsapp" id="whatsapp" class="form-control   {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" value="{{ old('whatsapp') ?: $empresa->whatsapp }}" required/>
        @error('whatsapp')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="facebook" class="form-label">Facebook</label>
        <input  name="facebook" id="facebook" class="form-control  {{ $errors->has('facebook') ? ' is-invalid' : '' }}" value="{{ old('facebook') ?: $empresa->facebook }}" />
        @error('facebook')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" name="email" id="email" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') ?: $empresa->email }}" />
        @error('email')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="direccion" class="form-label">Dirección</label>
        <input name="direccion" id="direccion" class="form-control  {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{ old('direccion') ?: $empresa->direccion }}" required/>
        @error('direccion')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>  

      <div class="form-group">
        <label for="barrio" class="form-label">Barrio</label>
        <input name="barrio" id="barrio" class="form-control  {{ $errors->has('barrio') ? ' is-invalid' : '' }}" value="{{ old('barrio') ?: $empresa->barrio }}" required/>
        @error('barrio')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <div class="form-group">
        <label for="servicios" class="form-label">Servicios</label>
        <textarea required name="servicios" id="servicios" class="form-control   {{ $errors->has('servicios') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('servicios') ?: $empresa->servicios }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Especifica tus servicios separados por un guión (-).</small>
        @error('servicios')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div> 
      <div class="form-group">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea name="descripcion" required id="descripcion" class="form-control   {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('descripcion') ?: $empresa->descripcion }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Realice una breve descripción de su empresa y sus aspectos diferenciadores.</small>
        @error('descripcion')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>                 
      <div class="form-group">
        <label for="horario" class="form-label">Horario</label>
        <textarea name="horario" id="horario" class="form-control   {{ $errors->has('horario') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('horario') ?: $empresa->horario }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Especifica muy bien el horario de atención de tu empresa, eso es realmente importante para el cliente.</small>
        @error('horario')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      <div class="form-group">
        <label for="horario" class="form-label">Logo</label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFileLang" lang="es" name="logo">
          <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
        </div><small id="descriptionHelp" class="form-text text-muted mt-2">Tamaño recomendado de 200*200.</small>
      </div>
      <div class="">
        


        <div class="form-group">
          <label for="subcategoria" class="form-label">Menú / Portafolio</label>

          <select class="form-control" name="menu"  id="menu">


            @if($empresa->menu)

            @if($empresa->menu=="1")
            <option value="1">Menú
            </option>
            <option value="2">Portafolio</option>

            @else
            <option value="2">Portafolio</option>
            <option value="1">Menú
            </option>

            @endif

            @else
            <option value="">Seleccione
            </option>
            <option value="1">Menú
            </option>
            <option value="2">Portafolio</option>

            @endif

          </select>



        </div>
      </div>
      <div class="form-group text-right">
        <button type="submit"  form="formempresa" class="btn btn-success px-3"><i class="fa fa-edit ml-2"></i> {{$btnText}}</button>
      </div>

    </form>


  </div>
</div>

</div>
</div>
</div>



<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Confirmar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      
      @csrf {{method_field('delete')}}
      <div class="modal-body">
        <p class="text-center">
          ¿Esta Seguro que desea eliminar el registro?
        </p>
        <input type="hidden" name="id" id="id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancelar</button>
        <button  class="btn btn-danger" id="confirmarEliminar">Sí, Eliminar</button>
      </div>

    </div>
  </div>
</div>
<div class="modal modal-danger fade" id="deleteMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Eliminar galería de menú/portafolio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      
      @csrf {{method_field('delete')}}
      <div class="modal-body">
        <p class="text-center">
          ¿Esta Seguro que desea eliminar el registro?
        </p>
        <input type="hidden" name="idMenu" id="idMenu" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancelar</button>
        <button  class="btn btn-danger" id="confirmarEliminarMenu">Sí, Eliminar</button>
      </div>

    </div>
  </div>
</div>


@endsection

<script  src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script  src="{{ asset('js/eliminar-galeria.js') }}"></script>
<script  src="{{ asset('js/eliminar-menu.js') }}"></script>