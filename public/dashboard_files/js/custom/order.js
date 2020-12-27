
$(document).ready(function(){
    //add product btn
    $(".add-product-btn").on('click',function(e){
        e.preventDefault();
        var name = $(this).data('name');
        var id = $(this).data('id');
        var sale_price = $.number($(this).data('price'),2);
    
        $(this).removeClass('btn-success').addClass('btn-default disabled');

        
        var html =
            `<tr>
                <td><input type="hidden" value="${id}" name="products_ids[]"></td>
                <td>${name}</td>
                <td><input type="number" name="quantity[]" min="1" value="1" data-price="${sale_price}" class="form-control input-sm product-quantity"></td>
                <td class="product-price" >${sale_price}</td>    
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><i class="fa fa-trash"></i></button></td>
            </tr>`;

        $('.order-list').append(html);
        //calculate total price
        calculate_price();

});// end of remove class

//disabled btn
$('body').on('click','.disabled',function(e){
    e.preventDefault();

});// end of remove disabled


//remove product btn
$('body').on('click','.remove-product-btn',function(e){

    e.preventDefault();
    var id = $(this).data('id'); 
    $(this).closest('tr').remove();//remove nearest tr
    $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');

    //calculate total price
    calculate_price();

});// end of remove product



//change product quantity
$('body').on('keyup change', '.product-quantity', function() {
    var quantity = parseInt($(this).val()); 
    var unitPrice = parseFloat($(this).data('price').replace(/,/g,'')); // to delete string ,
    $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice , 2));
    calculate_price();

});//end of product quantity change

});// end document of ready


//calculate total price
function calculate_price()
{
    var price = 0;
    $('.order-list .product-price').each(function(index){
        
        price += parseFloat($(this).html().replace(/,/g,''));// it delete a , and put '' nothing empty string
        //price +=  $(this).html(); // it work but not number it a string
    });
   // alert(price); // for test
   $('.total-price').html($.number(price,2));

   if(price > 0)
   {
       $('#add-order-form-btn').removeClass('disabled');
   }
   else{
       $('#add-order-form-btn').addClass('disabled');
   }
}
