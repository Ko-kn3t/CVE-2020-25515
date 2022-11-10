<?php
include 'db_connect.php';
if(isset($_GET['id'])){
$book = $conn->query("SELECT * FROM borrowers where id=".$_GET['id'])->fetch_assoc();
foreach($book as $k => $v){
    $meta[$k] = $v;
}
}
?>
<div class="container-fluid">
    <form action="" id="manage_borrower">
        <div class="">
            <label for="location">Student ID #</label>
        <input type="text" id="student_id_no" name="student_id_no" class="form-control" value="<?php echo isset($meta['student_id_no']) ? $meta['student_id_no'] : "" ?>" required>
        </div>
        <div class=" mt-3">
            <label for="name"  >Name</label>
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : "" ?>">
            <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : "" ?>" required>
        </div>
        <div class="">
            <label for="address">Address</label>
            <textarea id="address" class="md-textarea form-control" rows="2" name="address" required><?php echo isset($meta['address']) ? $meta['address'] : "" ?></textarea>
        </div>
        <div class="">
            <label for="location">Contact</label>
        <input type="text" id="contact" name="contact" class="form-control" value="<?php echo isset($meta['contact']) ? $meta['contact'] : "" ?>" required>
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
$('#manage_borrower').submit(function(e){
    e.preventDefault()
    start_load();
    $.ajax({
        url:'ajax.php?action=save_borrower',
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