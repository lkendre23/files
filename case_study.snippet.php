
<?php 

$rd_args = array(
  'meta_query' => array(
    array(
      'key' => 'color',
      'value' => array('white','green'),
      'compare' => 'IN'
    )
  )
);
 
$rd_query = new WP_Query( $rd_args );

// echo "<pre>";
// print_r($rd_query);



?>

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
        output += `<tr>`;
        output += `<td colspan='3'>${resp.msg}</td>`;
        output += `</tr>`;
        jQuery('#table tbody').html(output);
      }

      if(resp.status == 'success'){

        //console.log(resp.data[0].service_cats[0].name)


        var datas = resp.data.length;         
        if(datas >= 1 ){
          var output = '';
          for(i=0;i<datas; i++){
            output += `<tr>`;
            output += `<td> ${resp.data[i].title}</td>`;
            output += `<td> ${resp.data[i].contents}</td>`;            
            output += `<td>${resp.data[i].industry}</td>`
            output += `<td>${resp.data[i].service_cats[0].name}</td>`
            output += `</tr>`;
          }
          jQuery('#table tbody').html(output);  
        } 
      }     
    })
  }

</script>

<!-- case study filter form -->
<?php 
global $wpdb;
$services = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key LIKE "select_services" ORDER BY wp_postmeta.meta_value ASC', OBJECT );      
?>
<form>
  <select name="custome_post" id="custome_post" onchange="caseStudyFilter();"  >
    <option value="">Select Industry</option>  
    <?php       
         foreach($services as $service){ ?>          
          <option value="<?php echo $service->meta_value;?>"><?php echo $service->meta_value; ?></option>   
      <?php } ?>
  </select>
  <select name="cat_type" id="cat_type" onchange="caseStudyFilter(); " >
    <option value="">Select Servic</option>
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
</form>

<!-- Case Study results -->
<table class="" id='table'>
  <thead>
    <tr>
      <th>Title</th>
      <th>Contents</th>
      <th>Industry</th>
      <th>Service</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $args =  array(
        'post_type' => 'cb_casestudies',
        'posts_per_page' => -1,
        'order' => 'DESC',        
      );
      $query = new WP_Query($args);
      while($query->have_posts() ):$query->the_post();       

    ?>
    <tr>
      <td><?php the_title(); ?></td>
      <td><?php the_excerpt(); ?></td>
      <td><?php the_field('select_services'); ?></td>
      <td><?php 
              $terms=get_the_terms( $query->post->ID, 'casestudies_category' );
              foreach($terms as $term)
              {
                echo $term->name;
              }
              ?>         
      </td>
    </tr>
  <?php endwhile; ?>
  </tbody>  
</table>
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