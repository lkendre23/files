<style>
  .container-search input, select {
    width: 50%;
    background: #FFFFFF;
    float: left;
    height: 50px;
    border: 1px solid #DDDDDD;
    color: #000000;
    margin-top: 48px;
}
</style>

<script>  
  function caseStudyFilter(){
    var custome_post = jQuery('#custome_post').val();
    var cat_type = jQuery('#cat_type').val();
    var value = parseInt(document.getElementById('number').value);    
    var tableWraps = jQuery('#table');        
    jQuery.post("<?= site_url() ?>/wp-admin/admin-ajax.php",{'action':'casestudy_action','custome_post': custome_post, 'cat_type' : cat_type,'number': value },function(resp){         
      if(resp.status == 'error'){
        //alert(resp.msg)
        var output = '';        
        output += `<li>`;
        output += `<div class="cserrormsg">${resp.msg}</div>`;
        output += `</li>`;
        jQuery('#table li').html(output);
      }
      if(resp.status == 'success'){
        //console.log(resp.data[0].service_cats[0].name)
        var datas = resp.data.length;         
        if(datas >= 1 ){
          var output = '';
          for(i=0;i<datas; i++){
            output += `<li>`;
            output += `<div><h4>Industry</h4><p>${resp.data[i].industry}</p><h4>Service</h4><p>${resp.data[i].service_cats[0].name}</p></div>`;
            output += `<div> ${resp.data[i].title}</div>`;
            output += `<div> ${resp.data[i].contents}</div>`;                       
            // output += `<div></div>`;
            output += `</li>`;
          }
          jQuery('#table').html(output);  
        } 
      }     
    })
  }
</script>
<!-- case study filter form -->
<?php 
global $wpdb;
$services = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key LIKE "select_services" ORDER BY wp_postmeta.meta_value ASC', OBJECT ); ?>
<div class="container-search">
    <div class="inner-search">
      <div class="col-search">
        <select name="custome_post" id="custome_post" onchange="caseStudyFilter();"  >
          <option value="">Select Industry</option>  
            <?php       
             foreach($services as $service){ ?>          
            <option value="<?php echo $service->meta_value;?>"><?php echo $service->meta_value; ?></option>   
            <?php } ?>
        </select>
    </div>

    <div class="col-select-cat">
      <select name="cat_type" id="cat_type" onchange="caseStudyFilter(); " >
        <option value="">Select Service</option>
        <?php 
        // Custome posts Category
        $args = array(
          'taxonomy' => 'casestudies_category',
          'orderby' => 'name',
          'order' => 'ASC',
        );  
        $categories = get_categories($args);  
        foreach($categories as $category) {?>
          <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
        <?php } ?>    
      </select>
    </div>
  </div>
</div>
<!-- Case Study results -->
<ul class="" id='table'>
    <?php 
      $args =  array(
        'post_type' => 'cb_casestudies',
        'posts_per_page' => -1,
        'order' => 'DESC',        
      );
      $query = new WP_Query($args);
      while($query->have_posts() ):$query->the_post();      
    ?>
    <li>
      <div>
        <?php 
          echo "<h4>Industry</h4>";
           echo "<p>".get_field('select_services')."</p>";        
          $terms=get_the_terms( $query->post->ID, 'casestudies_category' );
          foreach($terms as $term)
          {
            echo "<h4>Service</h4>";
            echo "<p>".$term->name."</p>";
          }
        ?>         
      </div>
      <div><?php the_title(); ?></div>
      <div><?php the_excerpt(); ?></div>
    </li>
  <?php endwhile; ?>
  <!-- </tbody>   -->
</ul>
<!-- Blog results -->
<input type="hidden" id="number" name='number'value="5"/>
<input type="button" onclick="incrementValue()" value="Read More" />
<script>
value = 5
function incrementValue()
{
    value = parseInt(document.getElementById('number').value,10);
    //alert(value)
    value = isNaN(value) ? 0 : value;
    value+= 5;
    document.getElementById('number').value = value;
    console.log(value);
    caseStudyFilter();
}
</script>