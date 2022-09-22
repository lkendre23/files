<script>
  
  function filterData1() {
  alert('Hi')

 }

</script>

<form method="get" action='' class="year-form"> 
            <div class="f-dropdown-years">
              
              <input type="text" name="case_study" onchange="filterData1()">
              </div>
            
              <div class="dropdown-documents">
              <select name="debtDoc" onchange="filterData()" class="invest-year">
                <option value="">All Documents</option>                   
              </select>
            </div>
            <input type="hidden" name="action" value="casestudy_filter_action">
            
          </form>





<div class="our-clients">
	<ul>
  <?php
        $query = new WP_Query(array(
            'post_type'  => 'cb_casestudies',
            'posts_per_page'  =>  -1,
            'order' => 'ASC'
        ));
        while ($query->have_posts()) {
            $query->the_post();
    ?>
     
    <li> <h2><?php the_title(); ?> </h2> </li>
    <li> <h2><?php the_excerpt();  ?> </h2> </li>


  <?php } ?>
</ul>
</div>
<div class="clear"></div>


<script type="text/javascript">
  alert("Hello")
function filterData() {
  alert('Hi')

 }
/*
  var myForm = jQuery(`#${formId}`)[0];

    var formData = new FormData(myForm);    

    var formNumber = jQuery(`#${formId} input[name="counter"]`).val();
    alert(formNumber);
    var tableWrap = `#table${formNumber}`;  
     jQuery.ajax({
            method: "POST",
            // enctype: 'multipart/form-data',
            url: "<?= site_url() ?>/wp-admin/admin-ajax.php",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            beforeSend: function() {
              loadingOverlay(tableWrap, 'show');
            },
            success: function (data) {
         var targetWrapper = `#table${formNumber}`;   
               // console.log(targetWrapper);
               if(data.status == 'error') {
                  alert(data.msg);
                  jQuery(`${targetWrapper} tbody`).html("");
                  return false;
               }

               

               var output = '';
               jQuery.each(data.data, function(key, value){
                  output += `<tr>`;
                  output += `<td data-label="Date" class="investor-date">${value.investor_date}</td>`;
                  output += `<td data-label="Title" class="investor-post-title">${value.title}</td>`;
                  output += `<td data-label="PDF" class="pdf-icon">`;
                  if(value.uaudio_link) {
                    output += `<a target="_blank" href="${value.uaudio_link}" download><img src="<?php// echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>`;  
                  }
                  if(value.updf_link) {
                    output += `<a target="_blank" href="${value.updf_link}" download><img src="<?php //echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>`;  
                  }
                  output += `</td>`;
                  output += `</tr>`;  
               });
                

               jQuery(`${targetWrapper} tbody`).html(output);
 
            },
            error: function (e) {
 
               console.log(e);
 
            },
            complete: function() {
              loadingOverlay(tableWrap, 'hide');
            }
        });
}

jQuery('.investors-result-right-list-inner').hover(function(){
    jQuery('.investors-result-right-list-inner').removeClass('active-tab');
    jQuery('.investors-result-right-list-ctn-inner').removeClass('active-content');
    var getdatatitle = jQuery(this).attr('data-title'); 
    jQuery(this).addClass('active-tab'); 
    jQuery('.investors-result-right-list-ctn-inner.'+getdatatitle).addClass('active-content')
});


function onclickcheck(){
    jQuery(".investors-table").addClass("showtabledbtiss");
    jQuery(".investor-filer").addClass("showtabledbtiss");
};

</script>
