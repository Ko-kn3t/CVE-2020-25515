<?php
include 'db_connect.php';
if(isset($_GET['id'])){
$borrowed = $conn->query("SELECT * FROM borrowed_books where id=".$_GET['id'])->fetch_assoc();
foreach($borrowed as $k => $v){
    $meta[$k] = $v;
}
}
$books = $conn->query("SELECT *,concat(title,' | ',author) as book FROM books order by concat(title,' | ',author) asc ");
$borrower = $conn->query("SELECT * FROM borrowers order by name asc ");
?>
<div class="container-fluid">
    <form action="" id="manage_borrow">
        <div class="mt-3">
            <label for="book_number">Book #</label>
            <input type="text" id="book_number" name="book_number" class="form-control" value="<?php echo isset($meta['book_number']) ? $meta['book_number']: "" ?>" required>
        </div>
        <div class="mt-3">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : "" ?>">
            <label for="name" >Book</label>
            <select type="text" id="book_id" name="book_id" class="custom-select browser-default  select2"  required>
                <option value="" ></option>
            <?php 
            while($row=$books->fetch_assoc()){
            ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['book_id']) && $meta['book_id'] == $row['id'] ? "selected" : "" ?>><?php echo $row['book'] ?></option>
            <?php } ?>
            </select>
        </div>
        <div class="mt-3">
            <label for="name"  >Borrower</label>
            <select type="text" id="borrower_id" name="borrower_id" class="custom-select browser-default select2" required>
                <option value=""></option>

                 <?php 
            while($row=$borrower->fetch_assoc()){
            ?>
                <option value="<?php echo $row['id'] ?>" <?php echo isset($meta['borrower_id']) && $meta['borrower_id'] == $row['id'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
            <?php } ?>
            </select>
        </div>
        <div class="mt-3">
            <label for="date_borrowed">Borrowing Date</label>
            <input type="text" id="date_borrowed" name="date_borrowed" class="form-control datepicker" value="<?php echo isset($meta['date_borrowed']) ? date('Y-m-d',strtotime($meta['date_borrowed'])) : date('Y-m-d') ?>" required>
        </div>
        <div class="mt-3">
            <label for="date_return">Returning Date</label>
            <input type="text" id="date_return" name="date_return" class="form-control datepicker" value="<?php echo isset($meta['date_return']) ? date('Y-m-d',strtotime($meta['date_return'])) : date('Y-m-d',strtotime(date('Y-m-d'). '+3 days')) ?>" required>
        </div>
        <?php if(isset($_GET['id'])): ?>
         <div class="mt-3">
            <label for="status">Status</label>
            <select type="text" id="status" name="status" class="custom-select browser-default" required>
                <option value="0" <?php echo $meta['status'] == 0 ? "selected" : '' ?>>Pending</option>
                <option value="1" <?php echo $meta['status'] == 1 ? "selected" : '' ?>>Returned</option>
            </select>
        </div>

        <?php if(($meta['status'] == 0) && ( date('Ymd') > date("Ymd",strtotime($meta['date_return'])) )): 
            $calc_over = abs(strtotime(date("Y-m-d")." 23:59:59")) - strtotime($meta['date_return']." 00:00:00") ; 
            $calc_over =floor($calc_over / (60*60*24)  );
        ?>
        <div class="badge badge-danger"><?php echo $calc_over.($calc_over > 1 ? ' days' : ' day').' Overdue'; ?></div>

        <?php endif; ?>
        <?php if(($meta['status'] == 1) && ( date("Ymd",strtotime($meta['date_received'])) > date("Ymd",strtotime($meta['date_return'])) )): 
            $calc_over = abs(strtotime($meta['date_received']." 23:59:59")) - strtotime($meta['date_return']." 00:00:00") ; 
            $calc_over =floor($calc_over / (60*60*24)  );
        ?>
    <div class="badge badge-danger"><?php echo $calc_over.($calc_over > 1 ? ' days' : ' day').' Overdue'; ?></div>

        <?php endif; ?>
        <?php endif; ?>
    </form>
</div>
<style type="text/css">
    .select2{
        width: 100%;
    }
</style>
<script>
    $('.select2').select2({
        placeholder:'Please Select here',
        width:'resove'
    })
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    })
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
$('#manage_borrow').submit(function(e){
    e.preventDefault()
    start_load();
    $.ajax({
        url:'ajax.php?action=save_borrow',
        method:'POST',
        data:$(this).serialize(),
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