@extends('layouts.app')
@section('content')

<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header">Regístrate como profesional</div>

              <div class="card-body">
               <form id="formprofesional" class="form" method="POST" action="{{ ! $profesional->id ? route('profesionales.store') : route('profesionales.update', $profesional->id)}}" enctype="multipart/form-data">
             
                  @if($profesional->id) 
                  @method('PUT') 
                  @endif
                  @csrf
                  <div class="form-group">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <select  title=" " data-live-search="true" data-style="form-control border " class="selectpicker  form-control  {{ $errors->has('ciudad_id') ? ' is-invalid' : '' }}" name="ciudad_id" id="ciudad_id" required>
                      @foreach ($estados as $estado)
                      <optgroup label="{{$estado->nombre}}">
                        @foreach ($estado->ciudades as $ciudad)
                        <option {{ (int) old('ciudad_id') === $ciudad->id || $profesional->ciudad_id === $ciudad->id ? 'selected' : '' }} value="{{$ciudad->id}}">{{$ciudad->nombre}}</option> 
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
                    <input name="nombre" id="nombre" class="form-control  {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{ old('nombre') ?: $profesional->nombre }}"
                    required autofocus/>
                    @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="subprofesion" class="form-label">Profesión</label>
                    <select   title=" " data-live-search="true" data-style="form-control border" class="selectpicker form-control  {{ $errors->has('subprofesion_id') ? ' is-invalid' : '' }}" name="subprofesion_id" id="subprofesion_id" required>
                      @foreach ($profesiones as $profesion)
                      <optgroup label="{{$profesion->nombre}}">
                        @foreach ($profesion->subprofesiones as $subprofesion)
                        <option {{ (int) old('subprofesion_id') === $subprofesion->id || $profesional->subprofesion_id === $subprofesion->id ? 'selected' : '' }} value="{{$subprofesion->id}}">{{$subprofesion->nombre}}</option> 
                        @endforeach
                      </optgroup>
                     
                      @endforeach
                    </select>           
                    @error('subprofesion_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="tel" name="celular" id="celular" class="form-control   {{ $errors->has('celular') ? ' is-invalid' : '' }}" value="{{ old('celular') ?: $profesional->celular }}" required/>
                    @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="whatsapp" class="form-label">Whatsapp</label>
                    <input type="tel" name="whatsapp" id="whatsapp" class="form-control   {{ $errors->has('whatsapp') ? ' is-invalid' : '' }}" value="{{ old('whatsapp') ?: $profesional->whatsapp }}" required/>
                    @error('whatsapp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                    <div class="form-group">
                      <label for="facebook" class="form-label">Facebook</label>
                      <input  name="facebook" id="facebook" class="form-control  {{ $errors->has('facebook') ? ' is-invalid' : '' }}" value="{{ old('facebook') ?: $profesional->facebook }}" />
                      @error('facebook')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') ?: $profesional->email }}" />
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input name="direccion" id="direccion" class="form-control  {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{ old('direccion') ?: $profesional->direccion }}" required/>
                    @error('direccion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>  

                  <div class="form-group">
                    <label for="perfil" class="form-label">Perfil Laboral</label>
                    <textarea name="perfil" id="perfil" class="form-control   {{ $errors->has('perfil') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('perfil') ?: $profesional->perfil }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Realice una breve descripción de su profesional y sus aspectos diferenciadores.</small>
                    @error('perfil')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>                 
                  <div class="form-group">
                    <label for="enfasis" class="form-label">Énfasis Laboral</label>
                    <textarea name="enfasis" id="enfasis" class="form-control   {{ $errors->has('enfasis') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('enfasis') ?: $profesional->enfasis }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Realice una breve descripción de su profesional y sus aspectos diferenciadores.</small>
                    @error('enfasis')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>   
                  <div class="form-group">
                    <label for="competencias" class="form-label">Competencias Laborales</label>
                    <textarea name="competencias" id="competencias" class="form-control   {{ $errors->has('competencias') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('competencias') ?: $profesional->competencias }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Realice una breve descripción de su profesional y sus aspectos diferenciadores.</small>
                    @error('competencias')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>   
                  <div class="form-group">
                    <label for="intereses" class="form-label">Intereses Laboral</label>
                    <textarea name="intereses" id="intereses" class="form-control   {{ $errors->has('intereses') ? ' is-invalid' : '' }}" rows="5" aria-describedby="descriptionHelp">{{ old('intereses') ?: $profesional->intereses }}</textarea><small id="descriptionHelp" class="form-text text-muted mt-2">Realice una breve descripción de su profesional y sus aspectos diferenciadores.</small>
                    @error('intereses')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>   
                  <div class="form-group">
                    <label for="tipo" class="form-label">Tipo de servicio</label>
                    <select   title=" " data-live-search="true" data-style="form-control border" class="selectpicker form-control  {{ $errors->has('tipo') ? ' is-invalid' : '' }}" name="tipo" id="tipo" required>
                      <option {{ (int) old('tipo') === "Independiente" || $profesional->tipo === "Independiente" ? 'selected' : '' }} value="Independiente">Independiente</option> 
                      <option {{ (int) old('tipo') === "Vinculacion" || $profesional->tipo === "Vinculacion" ? 'selected' : '' }} value="Vinculacion">Vinculación laboral</option> 
                    </select>           
                    @error('tipo')
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
                  <div class="form-group text-right">
                      <button type="submit"  form="formprofesional" class="btn btn-primary px-3">{{$btnText}}<i class="fa-chevron-right fa ml-2"></i></button>
                  </div>
                           
                </form>
        
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
            <form action="" method="post">
               @csrf {{method_field('delete')}}
                <div class="modal-body">
                    <p class="text-center">
                        ¿Esta Seguro que desea eliminar el registro?
                    </p>
                    <input type="hidden" name="id" id="id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No, Cancelar</button>
                    <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection