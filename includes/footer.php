


</div></br></br>
<footer class="text-center" id="footer">&copy; Copyright 2017-2020 Fashion shop</footer>


<script>
// cache the element
var $navBar = $('.navbar');

// find original navigation bar position
var navPos = $navBar.offset().top;

// on scroll
$(window).scroll(function() {

    // get scroll position from top of the page
    var scrollPos = $(this).scrollTop();

    // check if scroll position is >= the nav position
    if (scrollPos >= navPos) {
        $navBar.addClass('fixed');
    } else {
        $navBar.removeClass('fixed');
    }

});






jQuery(window).scroll(function(){
      var vscroll = jQuery(this).scrollTop();
      jQuery('#logoText').css({
       "transform" : "translate(0px, "+vscroll/2+"px)"

      });

      jQuery('#back-flower').css({
       "transform" : "translate("+0+vscroll/5+"px, "+vscroll/12+"px)"
      });

       jQuery('#fore-flower').css({
       "transform" : "translate(0px, "+vscroll/2+"px)"
      });
  });



//detailsmodal function
function detailsmodal(id){
 var data = {"id" :  id};
 jQuery.ajax({
     url : '/website/includes/detailsmodal.php',
     method  : "post",
     data : data,
     success : function(data){
         jQuery('body').append(data);
         jQuery('#details-modal').modal('toggle');
     },
     error : function(){
         alert("Something went wrong!");
     }
 });

}
//update cart
function updata_cart(mode,edit_id,edit_size){

  var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
  jQuery.ajax({
    url: '/website/admin/parsers/update_cart.php',
    method: 'post',
    data: data,
    success:function(){
      location.reload();
    },
    error:function(){
      alert("something went wrong");
    }
  });

}

// add a  cart
function add_to_cart(){
jQuery('#modal_errors').html("");
  var size = jQuery('#size').val();
  var quantity = jQuery('#quantity').val();
  var available= parseInt(jQuery('#available').val());
  var error = '';
  var data = jQuery('#add_product_form').serialize();

  if (size == '' || quantity == '' || quantity == 0) {
    error += '<p class="text-danger text-center">You must choose a size and quantity</p>';
    jQuery('#modal_errors').html(error);
    return;

  }else if (quantity > available) {
    error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
    jQuery('#modal_errors').html(error);
    return;
  }else {
    jQuery.ajax({
      url: '/website/admin/parsers/add_cart.php',
      method: 'post',
      data: data,
      success:function(){
        location.reload();
      },
      error:function(){
        alert("something went wrong");
      }
    });
  }


}


</script>

</body>
</html>
