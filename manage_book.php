<?php
include 'db_connect.php';
if(isset($_GET['id'])){
$book = $conn->query("SELECT * FROM books where id=".$_GET['id'])->fetch_assoc();
foreach($book as $k => $v){
    $meta[$k] = $v;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage_book">
        <div class=" mt-3">
            <label for="title"  >Title</label>
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : "" ?>">
            <input type="text" id="title" name="title" class="form-control" value="<?php echo isset($meta['title']) ? $meta['title'] : "" ?>" required>
        </div>
        <div class=" mt-3">
            <label for="author"  >Author</label>
            <input type="text" id="author" name="author" class="form-control" value="<?php echo isset($meta['author']) ? $meta['author'] : "" ?>" required>
        </div>
        <div class="">
            <label for="description">Description</label>
            <textarea id="description" class="md-textarea form-control" rows="2" name="description" required><?php echo isset($meta['description']) ? $meta['description'] : "" ?></textarea>
        </div>
        <div class="">
            <label for="location">Book Location</label>
            <textarea id="location" class="md-textarea form-control" rows="2" name="location" required><?php echo isset($meta['location']) ? $meta['location'] : "" ?></textarea>
        </div>
        <div class='mt-3'>
            <img src="<?php echo isset($meta['img_path']) ? $meta['img_path'] : "" ?>" alt="" id="img-field">
        </div>
        <div class=" mt-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="img-label">Book Image</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="img" name="img"
                    aria-describedby="img-label"  accept="image/x-png,image/gif,image/jpeg" onchange="displayIMG(this)">
                    <label class="custom-file-label" for="img" id="img-fname">Choose file</label>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
$('#title').trigger('click')
  $('input, textarea').each(function(){
        $(this).trigger('focus')
        $(this).trigger('blur')
    })
function displayIMG(input) {
    $('#img-field').removeAttr('src')
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-fname').html(input.files[0]['name'])
                $('#img-field').attr('src', e.target.result).width(100).height(150);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
$('#manage_book').submit(function(e){
    e.preventDefault()
    start_load();
    $.ajax({
        url:'ajax.php?action=save_book',
        method:'POST',
        data:new FormData($(this)[0]),
        enctype: 'multipart/form-data',
        contentType: false, 
        processData: false,
        error:err=>{
            console.log(err)
            alert("An error occured")
        },
        success:function(resp){
            if(resp == 1){
                alert('Data successfully saved.')
                location.reload()
            }
        }
    })
})
</script>
<style>
#img-field{
    max-height:150px;
    max-width:100px;
}
</style>