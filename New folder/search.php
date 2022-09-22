<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<style>
	
	.posts.clearfix {
    border: 1px solid red !important;
    background: sienna;
    display: flex;
    margin: 6px 2px;
}

</style>

<!-- custome search form -->
<!-- custome search form -->
<!-- custome search form -->
<br><br>


<script>

	function searchFilterSearch(searchText){
		var searchp = jQuery('#searchp').val();
		//alert(searchp.length);
	
		if( searchp.length >= 1 ){
			alert('check all'+searchp.length)
				jQuery('#type_all').val('any');
				jQuery('#type_post').val('post');
				jQuery('#type_casestudy').val('cb_casestudies');
				jQuery('#type_services').val('cb_services');
				jQuery('#type_opening').val('cb_careers');
				jQuery('#type_client').val('cb_clients');

				jQuery('#type_all').attr('checked',true);
				jQuery('#type_post').attr('checked',true);
				jQuery('#type_casestudy').attr('checked',true);
				jQuery('#type_services').attr('checked',true);
				jQuery('#type_opening').attr('checked',true);
				jQuery('#type_client').attr('checked',true);
				
		}else{

			// jQuery('#type_all').val('');
			// 	jQuery('#type_post').val('');
			// 	jQuery('#type_casestudy').val('');
			// 	jQuery('#type_services').val('');
			// 	jQuery('#type_opening').val('');
			// 	jQuery('#type_client').val('');

			// 	jQuery('#type_all').removeAttr('checked');
			// 	jQuery('#type_post').removeAttr('checked');
			// 	jQuery('#type_casestudy').removeAttr('checked');
			// 	jQuery('#type_services').removeAttr('checked');
			// 	jQuery('#type_opening').removeAttr('checked');
			// 	jQuery('#type_client').removeAttr('checked');
	
		}



	}  

	function searchFilterAll(type_all){
		if(type_all.checked){			
			jQuery('#type_all').val('any');
			jQuery('#type_post').val('post');
			jQuery('#type_casestudy').val('cb_casestudies');
			jQuery('#type_services').val('cb_services');
			jQuery('#type_opening').val('cb_careers');
			jQuery('#type_client').val('cb_clients');


			jQuery('#type_post').attr('checked',true);
			jQuery('#type_casestudy').attr('checked',true);
			jQuery('#type_services').attr('checked',true);
			jQuery('#type_opening').attr('checked',true);
			jQuery('#type_client').attr('checked',true);		
			// jQuery('#type_page').attr('checked',true);
		}else{			
			jQuery('#type_all').val('');
		}
	}
	function searchFilterPost(postType){
		if(postType.checked){			
			jQuery('#type_post').val('post');
		}else{			
			jQuery('#type_all').val('');
			jQuery('#type_post').val('');
			jQuery('#type_all').removeAttr('checked');
			
			
		}	
	}
	// function searchFilterPage(pageType){
	// 	if(pageType.checked){			
	// 		jQuery('#type_page').val('page');

	// 	}else{			
	// 		jQuery('#type_page').val('');
	// 	}	
	// }

	function searchFilterCaseStudy(casestudy){
		if(casestudy.checked){			
			jQuery('#type_casestudy').val('cb_casestudies');
		}else{			
			jQuery('#type_casestudy').val('');
			jQuery('#type_all').removeAttr('checked');
			jQuery('#type_all').val('');
		}

	}	

	function searchFilterServices(serviceType){
		if(serviceType.checked){			
			jQuery('#type_services').val('cb_services');

		}else{			
			jQuery('#type_services').val('');
			jQuery('#type_all').removeAttr('checked');
			jQuery('#type_all').val('');
		}

	} 

	function searchFilterOpening(openingType){
		if(openingType.checked){			
			jQuery('#type_opening').val('cb_careers');
		}else{			
			jQuery('#type_opening').val('');
			jQuery('#type_all').removeAttr('checked');
			jQuery('#type_all').val('');
		}

	}


	function searchFilterClient(clientType){
		if(clientType.checked){			
			jQuery('#type_client').val('cb_clients');
		}else{			
			jQuery('#type_client').val('');
			jQuery('#type_all').removeAttr('checked');
			jQuery('#type_all').val('');
		}

	}
	
  function searchFilter(){
    var search_text = jQuery('#searchp').val();
    var type_all = jQuery('#type_all').val();    
    var type_post = jQuery('#type_post').val();
    // var type_page = jQuery('#type_page').val();
    var type_services = jQuery('#type_services').val();
    var type_opening = jQuery('#type_opening').val();
    var type_client = jQuery('#type_client').val();   
    var type_casestudy = jQuery('#type_casestudy').val();

    //alert(type_all+''+type_post+''+type_page);

    var value = parseInt(document.getElementById('number').value);  

    // var tableWraps = jQuery('#table');        
    jQuery.post("<?= site_url() ?>/wp-admin/admin-ajax.php",{'action':'search_action','search_text': search_text, 'type_all' : type_all,'type_post':type_post,'type_services':type_services,'type_opening':type_opening,'type_client':type_client,'type_casestudy':type_casestudy,'number': value },function(resp){         
      if(resp.status == 'error'){        
        var output = '';        
        output += `<ul>`;
        output += `<li class="search-error-msg">${resp.msg}</li>`;
        output += `</ul>`;
        jQuery('#search_div').html(output);
        jQuery('#searchp').css('border','1px solid red');
      }

      if(resp.status == 'success'){
        var datas = resp.data.length; 
        //alert(datas)        
        //console.log(datas)
        if(datas >= 1 ){
          var output = '';
          for(i=0;i<datas; i++){
            output += `<li>`;
            if( resp.data[i].thumbnail.length >= 1){
            	 output += `<div><img src="${resp.data[i].thumbnail}" /></div>`;          	 	            	
            } else{
            	output += `<div><img src="https://development.ikf.in/ikf2022/wp-content/themes/astra-child/assets/images/post_thum-err.svg" /></div>`;
            } 
            output += `<div> <a href="${resp.data[i].permalink}">${resp.data[i].title}</a></div>`;
            output += `<div> <a href="${resp.data[i].permalink}">${resp.data[i].permalink}</a></div>`; 
            output += `<div> ${resp.data[i].contents}</div>`;                 
            output += `<div><span>${resp.data[i].publishdate} </span></div>`;               
            output += `</li>`;
          }
          jQuery('#search_div').html(output);  
        } 
      }     
    })
  }

</script>

<div>
	<form id='searchform'>
		<input type="text" name="searchp" value="<?php echo (!empty ($_GET['s'] ))?  $_GET['s']: '' ; ?>" placeholder="Search" id="searchp" onchange="searchFilterSearch(this);searchFilter();"><br>
		<input type="checkbox" id="type_all" name="type_all" value=""  onchange="searchFilterAll(this); searchFilter();" checked /> All <br>
		<input type="checkbox" id="type_post" name="type_post" value="" onchange="searchFilterPost(this); searchFilter();"  checked /> Posts <br>	
		<!-- <input type="checkbox" id="type_page" name="type_page" value=""  onchange="searchFilterPage(this); searchFilter();" checked /> Pages <br> -->
		<input type="checkbox" id="type_services" name="type_services" value="" onchange="searchFilterServices(this); searchFilter();" checked /> Services <br>
		<input type="checkbox" id="type_opening" name="type_opening" value="" onchange="searchFilterOpening(this); searchFilter();" checked /> Opening <br>
		<input type="checkbox" id="type_client" name="type_client" value="" onchange="searchFilterClient(this); searchFilter();" checked /> Clients <br>
		<input type="checkbox" id="type_casestudy" name="type_casestudy" value=""  onchange="searchFilterCaseStudy(this); searchFilter();" checked /> Case Study <br>	
	</form>
</div>

<?php 

if(!empty($_GET['search_text'] )) {

$text = '';

if( !empty($_GET['search_text'] ) ){
	$text = $_GET['search_text'];
}

if( !empty($_GET['type_all'] ) ){
	$type_all = $_GET['type_all'];
}

if( !empty($_GET['type_post'] ) ){
	$type_post = $_GET['type_post'];
}

if( !empty($_GET['type_page'] ) ){
	$type_page = $_GET['type_page'];
}

?>

<div class="container">
<h4>Search For: <?php echo $text; ?></h4>
<?php 
// all types values
if( !empty($text) && !empty($type_all) && !empty($type_post) && !empty($type_page) ){  ?>
	<script>		
		jQuery('#type_all').attr('checked','true');
		jQuery('#type_post').attr('checked','true');
		jQuery('#type_page').attr('checked','true');		
	</script>
<?php

	$type = array('any', $type_post,$type_page);
	$args  =  array(	
	'post_type' => $type,
	'posts_per_page' => -1,
	's' => $text,
	
);
}

if(  !empty($text)  && !empty($type_post) ){ 
	?>
	<script>				
		jQuery('#type_post').attr('checked','true');			
	</script>
<?php
	
	$type = array( $type_post);
	$args  =  array(	
	'post_type' => $type,
	'posts_per_page' => -1,
	's' => $text,
);
}

if( !empty($text) && !empty($type_page) ){ 
	?>
	<script>				
		jQuery('#type_page').attr('checked','true');			
	</script>
<?php	
	$type = array('any', $type_page);
	$args  =  array(	
	'post_type' => $type,
	'posts_per_page' => -1,
	's' => $text,
);
}

if( !empty($text) && !empty($type_all)  ){?>
	<script>				
		jQuery('#type_all').attr('checked','true');
		jQuery('#type_post').attr('checked','true');
		jQuery('#type_page').attr('checked','true');		
	</script>
<?php	 
	$type = array('any');
	$args  =  array(	
	'post_type' => $type,
	'posts_per_page' => -1,
	's' => $text,
);
}

if( !empty($text) && !empty($type_post)  && !empty($type_page) ){ ?>
	<script>				
		jQuery('#type_all').attr('checked','true');
		jQuery('#type_post').attr('checked','true');
		jQuery('#type_page').attr('checked','true');		
	</script>
	<?php
	$type = array($type_post,$type_page);
	$args  =  array(	
	'post_type' => $type,
	'posts_per_page' => -1,
	's' => $text,
);
}


@$query = new WP_Query($args);
$counter = 0;

if ( $query->have_posts() ) :	

	while( $query->have_posts() ): $query->the_post(); ?>	
		<div class="posts clearfix custom<?php echo $counter; ?>">		
			<strong>
				<?php if( get_post_type() == "post" ){ /*echo "Post"; */ }  ?>
				<?php if( get_post_type() == "page" ){ /*echo "Pages"; */ }  ?>
				<?php if( get_post_type() == "other" ){ /*echo "Other"; */ }  ?>			
			</strong>
			<h5> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h5>					
		</div>
	<?php $counter++; 
	endwhile; wp_reset_query(); ?>
<?php 
else:
	echo "<div class='search-no-data' >No Data found !!!</div> ";
endif;
?>
</div>
<!-- custome search form -->

<?php } else{ ?>
	<script>
		document.getElementById("search_text").style.border = "2px solid red";	
	</script>

<?php
	// echo "please enter the vlaues";
}?>

<?php 
	$args = array(
		'post_type' =>  array('post','cb_casestudies','cb_services','cb_careers','cb_clients'),
		'posts_per_page' => '5',
		'order' => 'ASC',
		's' => $_GET['s'],
	);
	$searchQuery = new WP_Query($args);
?>

<ul class="" id='search_div'>
	<?php
		while($searchQuery->have_posts() ):$searchQuery->the_post(); ?>
			<li>				
				<?php 
					if(get_the_post_thumbnail_url() != "" ){ ?>
						<div>	
							<img src="<?php echo get_the_post_thumbnail_url(); ?>" />
						</div>
					<?php }
				?>					
				<div>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
				<div>
						<p><?php the_permalink(); ?></p>
				</div>
				<div>
					<?php 
						$content = get_the_content(); 
						$result = explode(" ",$content);
						for($i=0;$i<30;$i++){
							echo $result[$i]." ";
						}
						echo "...";
					?>					
				</div>
				<div>
					<p><?php echo get_the_date(); ?></p>
				</div>
			</li>
		<?php endwhile; ?>
</ul>

<!-- Blog results -->
<div>
<input type="hidden" id="number" name='number'value="5"/>
<input type="button" onclick="incrementValue()" value="Load More" />
</div>
<script>
value = 5
function incrementValue()
{
    value = parseInt(document.getElementById('number').value,10);
    //alert(value)
    value = isNaN(value) ? 0 : value;
    value+= 5;
    document.getElementById('number').value = value;
    //console.log(value);
    searchFilter();
}
</script>

<script type="text/javascript">  

jQuery(document).ready(function () {  
	jQuery("#searchform").bind("keypress", function (e) {  
		//console.log(e.keyCode);
		if (e.keyCode == 13) {  
			return false;  
		}  
	});  
});  

</script> 


<!-- wordpress search -->
<!-- wordpress search -->


<?php /* if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_archive_header(); ?>

		<?php astra_content_loop(); ?>		

		<?php astra_pagination(); ?>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif */ ?>


<?php get_footer(); ?>
