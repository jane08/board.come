jQuery(document).ready(function () {
	


//Показать области
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
	
	
	
});
