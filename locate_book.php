<?php
include 'db_connect.php';
if(isset($_GET['id'])){
$book = $conn->query("SELECT * FROM books where id=".$_GET['id'])->fetch_assoc();
foreach($book as $k => $v){
    $meta[$k] = $v;
}
}
?>
<style>
	#locate_img{
	    width: 150px;
    height: 200px;
	}
</style>

<div class="container-fluid">
	<center>
	<?php if(!empty($meta['img_path'])):  ?>
	<img src="<?php echo $meta['img_path'] ?>" alt="" width="100" height="150" id="locate_img">
	<?php else:  ?>
	<img src="assets/img/book.jpg" alt="" width="120px" height="150px" id="locate_img">
	<?php endif;  ?>
	</center>
	<hr>
	<p><b>Title:</b> <?php echo $meta['title'] ?></p>
	<p><b>Author:</b> <?php echo $meta['author'] ?></p>
	<p><b>Description:</b> <?php echo $meta['description'] ?></p>
	<p><b>Location:</b> <?php echo $meta['location'] ?></p>
</div>