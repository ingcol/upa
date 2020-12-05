 @extends('layouts.app_web')
@section('content')
<detalle-empresa :id="{{json_encode($id)}}">
<detalle-empresa/>
@endsection