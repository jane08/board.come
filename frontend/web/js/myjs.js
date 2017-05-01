jQuery(document).ready(function () {
	

//Показать подкатегории
	$(document).on('change', '.category', function () {
		
        var category_id = $('.category').val();

		//alert(category_id);

      $.ajax({
          type: "POST",
          url: '/ad/sub-cat-list',
			cache: false,
			data: {category_id:category_id},
			dataType: 'html',
			success: function(data){
			//alert(data);
			
			$('.subcat').html(data);
              }
            });

					 
    });

    //Показать подкатегории
    $(document).on('click', '.cat_name', function () {

        var category_id = $(this).data('catid');;

        $.ajax({
            type: "POST",
            url: '/site/show-sub-cat',
            cache: false,
            data: {category_id:category_id},
            dataType: 'html',
            success: function(data){
                //alert(data);

                $('.subcats').html(data);
            }
        });


    });

    //Показать объявления
    $(document).on('click', '.subcat_name', function () {

        var subcat_id = $(this).data('subcatid');
       // alert(subcat_id);
        $('.load').show(); //show loading image
        $.ajax({
            type: "POST",
            url: '/site/index/'+subcat_id,
            cache: false,
            data: {subcat_id:subcat_id},
            dataType: 'html',
            success: function(data){
                //alert(data);
                $('.load').hide(); //hide loading image
                $('.ajax_ad').html(data);
            }
        });


    });





    $(document).on('click', '.stars', function () {

        var stars =$(this).val();
        var user_id = $(this).data('user');
        var status = $(this).data('status');
        var currentuser = $(this).data('currentuser');
        //alert(user_id);
        if(!currentuser){
            alert('Только зарегистрированные пользователи могут голосовать!');
        }
        else if(currentuser==user_id){
            alert('Вы не можете госовать сами за себя!');
        }
        else {
            if (status > 0) {
                alert('Вы уже проголосовали!');

            } else {
                alert('Спасибо за оценку!');

                $.ajax({
                    type: "POST",
                    url: '/site/add-rating/',
                    cache: false,
                    data: {stars: stars, user_id: user_id, status: status, currentuser: currentuser},
                    dataType: 'html',
                     success: function(data){

                     $('.ajax_rate').html(data);
                     }
                });
            }
        }
       // $.post('add-rating',{rate:$(this).val()},function(d){
           /* if(d>0)
            {
                alert('You already rated');
            }else{
                alert('Thanks For Rating');
            }
        });
       */
         // });
    });

});
