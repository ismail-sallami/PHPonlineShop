/**
 * Created by ismail on 03.05.16.
 */

function btn_click(my_data) {
    $.ajax({ //make ajax request to cart_process.php
        url: "cart_update.php",
        type: "POST",
        dataType:"json", //expect json value from server
        data: my_data
    }).done(function(data){ //on Ajax success
        $("#cart-info").html(data.items); //total items in cart-info element
        if($(".shopping-cart-box").css("display") == "block"){ //if cart box is still visible
            $(".cart-box").trigger( "click" ); //trigger click to update the cart box.
        }
    })
}

$(document).ready(function(){

    //Show Items in Cart
    $( ".cart-box").click(function(e) { //when user clicks on cart box
        e.preventDefault();
        $(".shopping-cart-box").fadeIn(); //display cart box
        $("#shopping-cart-results").html('<img src="images/home/ajax-loader.gif">'); //show loading image
        $("#shopping-cart-results" ).load( "cart_update.php", {"load_cart":"1"}); //Make ajax request using jQuery Load() & update results
    });

    //Close Cart
    $( ".close-shopping-cart-box").click(function(e){ //user click on cart box close link
        e.preventDefault();
        $(".shopping-cart-box").fadeOut(); //close cart-box
    });

    //Remove items from cart
    $("#shopping-cart-results").on('click', 'a.remove-item', function(e) {
        e.preventDefault();
        var pcode = $(this).attr("data-code"); //get product code
        $(this).parent().fadeOut(); //remove item element from box
        $.getJSON( "cart_update.php", {"remove_code":pcode} , function(data){ //get Item count from Server
            $("#cart-info").html(data.items); //update Item count in cart-info
            $(".cart-box").trigger( "click" ); //trigger click on cart-box to update the items list
        });
    });

});
