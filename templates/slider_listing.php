<div class="wrap">
	<?php
		if(isset($_SESSION['success'])){
			echo '<div class="updated notice is-dismissible"><p>'. $_SESSION['success'] .'</p></div>';
			unset($_SESSION['success']);
		}
		if(isset($_SESSION['error'])){
			echo '<div class="error notice is-dismissible"><p>'. $_SESSION['error'] .'</p></div>';
			unset($_SESSION['error']);
		}
	?>
	<div id="icon-users" class="icon32"><br/></div>
	<h1>Sliders <a href="<?php echo admin_url('admin.php?page=add_slides'); ?>" class="page-title-action">Add New</a></h1>
	<h2 class="screen-reader-text">Sliders list</h2>

	<form  action="" id="slider-filter" method="get">
		<input type="hidden" name="noheader" value="true"/>
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
		<?php $testListTable->display() ?>
	</form>
</div>