<script>
	
	function fetchdata(){
		var search = jQuery('#search').val();
		var post_type = jQuery('#post_type').val();
		var value = parseInt(document.getElementById('number').value);
		// var no_post = incrementer();
		var tableWraps = jQuery('#table');
		//alert(search+' - '+ post_type);
		//console.log("<?= site_url() ?>/wp-admin/admin-ajax.php");
		jQuery.post("<?= site_url() ?>/wp-admin/admin-ajax.php",{'action':'my_action','search': search, 'post_type' : post_type,'number': value },function(resp){					
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

<input type="text" name="search" id="search" placeholder="search" onchange="fetchdata(); "> 
<!-- <input type="checkbox" name="post_type" id="post_type"  value="page" > Page -->
<select name="post_type" id="post_type" onchange="fetchdata(); " >
	<option value="">Select Service</option>
	<?php 
	$categories = get_categories();
	foreach($categories as $category) {?>
		<option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
	<?php } ?>
		
</select>

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
				'post_type' => 'post',
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
			<!-- read more -->
			<!-- read more -->
   <input type="hidden" id="number" name='number'value="5"/>
   <input type="button" onclick="incrementValue()" value="Load More" />
<script>
value = 5;
function incrementValue()
{
    var value = parseInt(document.getElementById('number').value,10);
    alert(value)
    value = isNaN(value) ? 0 : value;
    value+= 5;
    document.getElementById('number').value = value;
    console.log(value);
    fetchdata();
}
</script>