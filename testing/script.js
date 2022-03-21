$(function(){
 $('#btn') .click(function(){
   var test = +$('#test-id').text();
  var res = {'test':test};
  
  $('.questions').each(function(){
      var id = $(this).data('id');
      res[id] = $('input[name=question-'+id+']:checked').val();
  });
  //отправка на сервер
$.ajax({
    url:'index.php',
    type:'POST',
    data: res,
    success: function(html){
        //console.log (html);
     $('.content').html(html);
    },
    error: function(){
        alert('Error!');
    }
});
 });
});