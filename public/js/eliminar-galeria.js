 var id
  function del(id){
   $("#id").val(id);
 }

 $(document).on('click', '#confirmarEliminar', function(){
  $('#confirmarEliminar').prop('disabled', true);
  var idDel=$('#id').val();
  var _token = $("input[name='_token']").val()
  $.ajax({
    type: "delete",
    
    url:'/galeria/'+idDel,
    data:{id:id,_token:_token},
    success: function(data) {
      $('#delete').modal('hide');
      toastr.info('Registro eliminado'); 
      location.reload();
      $('#confirmarEliminar').prop('disabled', false);
    },

    error: function (data) {
      $('#confirmarEliminar').prop('disabled', false);
      var errors = data.responseJSON;
      if ($.isEmptyObject(errors) == false) {
        $.each(errors.errors, function (key, value) {
          $('#' + key)
          toastr.error(value); 
        });
      }

    },          


  });



});
