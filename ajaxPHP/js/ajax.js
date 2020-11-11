$('select').on('change', function () {
   let key = $(this).attr('name');
   let value = $(this).val();

   $.ajax({
      type: 'get',
      data: key + '=' + value,
      url: 'actions/query.php',
       success: function (res) {
            $('.cards-block').html(res);
       },
       error: function () {
          alert('Ошибка');
       }
   });
});