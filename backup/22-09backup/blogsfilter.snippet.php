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
				output += `<li>`;
				output += `<div colspan='2'>${resp.msg}</div>`;
				output += `</li>`;
				jQuery('#table').html(output);
			}

			if(resp.status == 'success'){
				var datas = resp.data.length;					
				if(datas >= 1 ){
					var output = '';
					for(i=0;i<datas; i++){
						output += `<li>`;					
						if( resp.data[i].thumbnail.length >= 1){
	            	 		output += `<div><img src="${resp.data[i].thumbnail}" /></div>`;          	 	            	
			            } else{
			            	output += `<div><img src="https://development.ikf.in/ikf2022/wp-content/themes/astra-child/assets/images/post_thum-err.svg" /></div>`;
			            } 
						output += `<div><h3> ${resp.data[i].blog_cats} </h3><div>`;
						output += `<div><h3> by ${resp.data[i].blog_auther} | ${resp.data[i].blog_time} </h3><div>`;
						output += `<div><a href="${resp.data[i].permalink}">${resp.data[i].title} </a></div>`;						
						output += `<div> ${resp.data[i].contents} </div>`;												 
						output += `</li>`;
					}
					jQuery('#table').html(output);	
				} 
			}			
		})
	}
</script>

<div class="container-search">
		<div class="inner-search">
			<div class="col-search">
			<input type="text" name="search" id="search" placeholder="search" onchange="fetchdata(); "> 
		</div>		
		<div class="col-select-cat">
			<select name="post_type" id="post_type" onchange="fetchdata(); " >
				<option value="">Select Service</option>
				<?php 
				$categories = get_categories();
				foreach($categories as $category) {?>
					<option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
				<?php } ?>
					
			</select>
		</div>
	</div>
</div>

<!-- Blog results -->
<ul class="" id='table'>	
		<?php 
			$args =  array(
				'post_type' => 'post',
				'posts_per_page' => 10,
				'order' => 'DESC',				
			);
			$query = new WP_Query($args);
			while($query->have_posts() ):$query->the_post();
		?>
		<li>
			<?php 

			if( !empty(get_the_post_thumbnail_url() ) ){?>
				<div >
					<img src="<?php echo get_the_post_thumbnail_url(); ?>" />
				</div>
			<?php				
			}
			?>
			
			<div>
        	<?php 
              $terms=get_the_terms( $query->post->ID, 'category' );
              foreach($terms as $term)
              {
                echo $term->name;
              }
              ?>         
      		</div>
      		<div><?php  echo "by ".get_the_author().' | '.get_the_time("F d, Y");?></div>
			<div><?php the_title(); ?></div>
			<div><?php //the_excerpt(); ?>
			<?php 
			$str =  get_the_content();
			$result  = explode(" ", $str);
			for($i=0;$i<=30;$i++){
				echo $result[$i]." ";				
			}
			echo "...";		
			?>	
			</div>
		</li>
	<?php endwhile; ?>	
</ul>
			<!-- read more -->
			<!-- read more -->
   <input type="hidden" id="number" name='number'value="5"/>
   <input type="button" onclick="incrementValue()" value="Load More" />
<script>
value = 5;
function incrementValue()
{
    var value = parseInt(document.getElementById('number').value,10);
    //alert(value)
    value = isNaN(value) ? 0 : value;
    value+= 5;
    document.getElementById('number').value = value;
    console.log(value);
    fetchdata();
}
</script>