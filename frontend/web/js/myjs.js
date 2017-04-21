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

        $.ajax({
            type: "POST",
            url: '/site/index/'+subcat_id,
            cache: false,
            data: {subcat_id:subcat_id},
            dataType: 'html',
            success: function(data){
                //alert(data);

                $('.ajax_ad').html(data);
            }
        });


    });



});
