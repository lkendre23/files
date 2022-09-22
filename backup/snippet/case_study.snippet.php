
<?php 

 
//         $args = array(
//             'post_type' => 'cb_casestudies',
//             'posts_per_page' => -1,
//             'order' => 'DESC',
//             'meta_value' => 'one',
//             // 'meta_query' => array(
//             //     'key' => 'select_filed',
//             //     'value' => array($custome_post),
//             //     'compare'=>'IN',
//             //     'value' => 'on',
                
//             // )
//         );
        
//         $getPosts = new WP_Query($args);

// $result = new WP_Query($args);

// echo "<pre>";
// print_r($result);



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
        output += `<td colspan='2'>${resp.msg}</td>`;
        output += `</tr>`;
        jQuery('#table tbody').html(output);
      }

      if(resp.status == 'success'){
        var datas = resp.data.length;         
        if(datas >= 1 ){
          var output = '';
          for(i=0;i<datas; i++){
            output += `<tr>`;
            output += `<td> ${resp.data[i].title}</td>`;
            output += `<td> ${resp.data[i].contents} </td>`;            
            output += `</tr>`;
          }
          jQuery('#table tbody').html(output);  
        } 
      }     
    })
  }

</script>

<!-- case study filter form -->
<form>
<input type="text" name="custome_post" id="custome_post" placeholder="custome_post" onchange="caseStudyFilter(); "> 
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

</form>


<!-- Blog results -->
<table class="" id='table'>
  <thead>
    <tr>
      <th>Title</th>
      <th>Contents</th>
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
      <td><?php the_content(); ?></td>
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
    alert(value)
    value = isNaN(value) ? 0 : value;
    value+= 5;
    document.getElementById('number').value = value;
    console.log(value);
    caseStudyFilter();
}
</script>