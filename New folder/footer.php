<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); ?>
	</div> <!-- ast-container -->
	</div><!-- #content -->
    <?php 
    	astra_content_after();
    		
    	astra_footer_before();
    		
    	astra_footer();
    		
    	astra_footer_after(); 
    ?>
	</div><!-- #page -->

    <?php 
    	astra_body_bottom();    
    	wp_footer(); 
    ?>


<div class="custom-search-wrap">
    <div class="custom-search-form">
        <form role="search" method="get" class="search-form" action="https://development.ikf.in/ikf2022/">
            <div class="search-div">    
                <input type="text" name="s" value="" placeholder="Search" onchange="searchFilterSearch(this);searchFilter();">
            </div>
        </form>
    </div>
</div>

    

	</body>
</html>
<style>
div#previewImage {
    position: absolute;
    position: absolute;
    z-index: 999;
}
</style>

<script>
// Search Popup
jQuery(".searchhdrbtn").click(function(){
    jQuery(".custom-search-wrap").toggleClass("showsearch");
});

// MegaMenu hover dark
jQuery(document).ready(function () {
    jQuery("#mega-menu-wrap-primary #mega-menu-primary").hover(function () {
        jQuery('body').addClass("header-hover");
        jQuery(".header-hover .custom-logo").attr("src","https://development.ikf.in/ikf2022/wp-content/uploads/ikf-logo-blue.png");
        jQuery(".header-hover .custom-logo").attr("srcset","https://development.ikf.in/ikf2022/wp-content/uploads/ikf-logo-blue.png");
    },
    function() {
        jQuery(".header-hover .custom-logo").attr("src","https://development.ikf.in/ikf2022/wp-content/uploads/2022/08/ikf-logo.png");
        jQuery(".header-hover .custom-logo").attr("srcset","https://development.ikf.in/ikf2022/wp-content/uploads/2022/08/ikf-logo.png");
        jQuery('body').removeClass("header-hover");
    }
    );
});

/******** Start header after scrollback ************/
const body = document.body;
const scrollUp = "scroll-up";
const scrollDown = "scroll-down";
let lastScroll = 0;

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;
  if (currentScroll <= 0) {
    body.classList.remove(scrollUp);
    return;
  }
  if (currentScroll > lastScroll && !body.classList.contains(scrollDown)) {
    body.classList.remove(scrollUp);
    body.classList.add(scrollDown);
  } else if (
    currentScroll < lastScroll &&
    body.classList.contains(scrollDown)
  ) {
    body.classList.remove(scrollDown);
    body.classList.add(scrollUp);
  }
  lastScroll = currentScroll;
});
/******** End header after scrollback ************/ 

// File Upload Placeholder
jQuery("input[type=file]").change(function (e) {
    jQuery(this).parents(".uploadFile").find(".filename").text(e.target.files[0].name);
});

jQuery(document).ready(function($){
// on focus
    jQuery(".wpcf7-form input, .wpcf7-form textarea").focus(function() {
       jQuery(this).parent().siblings('label').addClass('has-value');
    })
    // blur input fields on unfocus + if has no value
    .blur(function() {
        var text_val = jQuery(this).val();
        if(text_val === "") {
            jQuery(this).parent().siblings('label').removeClass('has-value');
        }
    });
});   


function removewpcf(){
    jQuery('span.wpcf7-not-valid-tip + span.wpcf7-not-valid-tip').remove();
}setInterval('removewpcf()',1000);

jQuery(document).ready(function () {
            jQuery("#test").CreateMultiCheckBox({ defaultText : 'Select Service*'});
        });

        jQuery(document).ready(function () {

            jQuery(document).on("click", ".MultiCheckBox", function () {
                var detail = jQuery(this).next();
                detail.show();
            });

            jQuery(document).on("click", ".MultiCheckBoxDetailHeader input", function (e) {
                e.stopPropagation();
                var hc = jQuery(this).prop("checked");
                jQuery(this).closest(".MultiCheckBoxDetail").find(".MultiCheckBoxDetailBody input").prop("checked", hc);
                jQuery(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();
            });

            jQuery(document).on("click", ".MultiCheckBoxDetailHeader", function (e) {
                var inp = jQuery(this).find("input");
                var chk = inp.prop("checked");
                inp.prop("checked", !chk);
                jQuery(this).closest(".MultiCheckBoxDetail").find(".MultiCheckBoxDetailBody input").prop("checked", !chk);
                jQuery(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();
            });

            jQuery(document).on("click", ".MultiCheckBoxDetail .cont input", function (e) {
                e.stopPropagation();
                jQuery(this).closest(".MultiCheckBoxDetail").next().UpdateSelect();

                var val = (jQuery(".MultiCheckBoxDetailBody input:checked").length == jQuery(".MultiCheckBoxDetailBody input").length)
                jQuery(".MultiCheckBoxDetailHeader input").prop("checked", val);
            });

            jQuery(document).on("click", ".MultiCheckBoxDetail .cont", function (e) {
                var inp = jQuery(this).find("input");
                var chk = inp.prop("checked");
                inp.prop("checked", !chk);

                var multiCheckBoxDetail = jQuery(this).closest(".MultiCheckBoxDetail");
                var multiCheckBoxDetailBody = jQuery(this).closest(".MultiCheckBoxDetailBody");
                multiCheckBoxDetail.next().UpdateSelect();

                var val = (jQuery(".MultiCheckBoxDetailBody input:checked").length == jQuery(".MultiCheckBoxDetailBody input").length)
                jQuery(".MultiCheckBoxDetailHeader input").prop("checked", val);
            });

            jQuery(document).mouseup(function (e) {
                var container = jQuery(".MultiCheckBoxDetail");
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.hide();
                }
            });
        });

        var defaultMultiCheckBoxOption = { defaultText: 'Select Service*'};

        jQuery.fn.extend({
            CreateMultiCheckBox: function (options) {

                var localOption = {};
                localOption.width = (options != null && options.width != null && options.width != undefined) ? options.width : defaultMultiCheckBoxOption.width;
                localOption.defaultText = (options != null && options.defaultText != null && options.defaultText != undefined) ? options.defaultText : defaultMultiCheckBoxOption.defaultText;
                localOption.height = (options != null && options.height != null && options.height != undefined) ? options.height : defaultMultiCheckBoxOption.height;

                this.hide();
                this.attr("multiple", "multiple");
                var divSel = jQuery("<div class='MultiCheckBox'>" + localOption.defaultText + "<span class='k-icon k-i-arrow-60-down'><svg aria-hidden='true' focusable='false' data-prefix='fas' data-icon='sort-down' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512' class='svg-inline--fa fa-sort-down fa-w-10 fa-2x'><path fill='currentColor' d='M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41z' class=''></path></svg></span></div>").insertBefore(this);
                divSel.css({ "width": localOption.width });

                var detail = jQuery("<div class='MultiCheckBoxDetail'><div class='MultiCheckBoxDetailHeader'><input type='checkbox' class='mulinput' value='-1982' /><div>Select All</div></div><div class='MultiCheckBoxDetailBody'></div></div>").insertAfter(divSel);
                detail.css({ "width": parseInt(options.width) + 10, "max-height": localOption.height });
                var multiCheckBoxDetailBody = detail.find(".MultiCheckBoxDetailBody");

                this.find("option").each(function () {
                    var val = jQuery(this).attr("value");

                    if (val == undefined)
                        val = '';

                    multiCheckBoxDetailBody.append("<div class='cont'><div><input type='checkbox' class='mulinput' value='" + val + "' /></div><div>" + jQuery(this).text() + "</div></div>");
                });

                multiCheckBoxDetailBody.css("max-height", (parseInt(jQuery(".MultiCheckBoxDetail").css("max-height")) - 28) + "px");
            },
            UpdateSelect: function () {
                var arr = [];

                this.prev().find(".mulinput:checked").each(function () {
                    arr.push(jQuery(this).val());
                });

                this.val(arr);
            },
        });

      function multicho(){
        var getleng = jQuery(".MultiCheckBoxDetail .cont input.mulinput").length;
        var getvalcal = '';
        var no = 0; 
        var no1 = 0; 
        for(i=0;i<getleng;i++){
                    var getvalin =  jQuery(".MultiCheckBoxDetail .cont:eq("+i+") input.mulinput:checkbox:checked").val();
                    if(getvalin == undefined || getvalin == ''){
                    }else{
                        no = parseInt(no) + parseInt(1);
                        no1 = parseInt(no1) + parseInt(1);
                        getvalcal = getvalcal + no +') '+getvalin + "\n";
                    }
                }
          jQuery('.products-textarea').html(getvalcal);
                if(no1 > 0){
                    jQuery('.MultiCheckBox').text(no1+' Service Selected');
                }else{
                    jQuery('.MultiCheckBox').text('Select Service*');
                }
      }




jQuery(document).ready(function(){
       
    jQuery('.onlycharallow').attr('onkeypress','return validateChar(event)'); 
    jQuery('.onlynumallow').attr('onkeypress','return validateNum(event)');

})



function validateChar(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 123)) {
      if (charCode == 8 || charCode == 32 || charCode == 9)
          return true;
      else
          return false;
  } else
      return true;

}
function validateNum(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      if (charCode == 43 || charCode == 40 || charCode == 41 || charCode == 9)
          return true;
      else
          return false;
  } else
      return true;
}

/*
jQuery(document).ready(function(){
    var file = document.getElementById('fileupload');

    file.onchange = function(e) {    
        var filesize =  this.files[0].size;        
        var actual_size = Math.round( filesize / 1024 );             
        var ext = this.value.match(/\.([^\.]+)$/)[1];
        switch (ext) {
            /*case 'jpg':
            case 'jpeg':
            case 'bmp':
            case 'png':
            case 'tif':*//*
            case 'pdf':
            case 'doc':
            case 'docx':
            case 'ppt':
            case 'pptx':          
            if(actual_size <= 5120 ){        
                jQuery('#fileError').removeClass('not_allowed');
                jQuery('#fileError').addClass('allowed');
                break;
            }else{           
               $('#simef').remove();
               jQuery('#fileError').removeClass('allowed');
               jQuery('#fileError').addClass('not_allowed');
               jQuery("#fileupload").val('');
               break;
            }          
            default:      
              jQuery('#fileError').removeClass('allowed');
              jQuery('#fileError').addClass('not_allowed');      
              jQuery(".filename").text("Upload Resume*");          
        }
    };
});
</script>