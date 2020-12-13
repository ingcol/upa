 var idMenu
  function delMenu(idMenu){
   $("#idMenu").val(idMenu);
 }

 $(document).on('click', '#confirmarEliminarMenu', function(){
  $('#confirmarEliminarMenu').prop('disabled', true);
  var idMenu=$('#idMenu').val();
  var _token = $("input[name='_token']").val()
  $.ajax({
    type: "delete",
    
    url:'/menu/'+idMenu,
    data:{id:idMenu,_token:_token},
    success: function(data) {
      $('#deleteMenu').modal('hide');
      toastr.info('Registro eliminado'); 
      location.reload();
      $('#confirmarEliminarMenu').prop('disabled', false);
    },

    error: function (data) {
      $('#confirmarEliminarMenu').prop('disabled', false);
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
