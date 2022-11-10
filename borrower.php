<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12">
            <button class="float-right btn btn-primary btn-sm" id='new_borrower'><i class="fa fa-plus"></i> New Borrower</button>
        </div>
    </div>
</div>
<?php 

    $borrower = $conn->query("SELECT * FROM borrowers order by `name` asc ");
    
?>
<div class="card card-cascade wider ml-1 mr-1  col-md-12" >
    <div class="card-header">
        
        <div class="card-title">
            Borrower List
        </div>
    </div>
    <div class="card-body">
    <table class="table table-bordered">
        <colgroup>
            <col width="10%">
            <col width="10%">
            <col width="20%">
            <col width="20%">
            <col width="10%">
            <col width="20%">
        </colgroup>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            while($row= $borrower->fetch_assoc()){   
                ?>
                <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td><?php echo $row['student_id_no']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td>
                        <center>
                            <button class="btn btn-sm btn-primary edit_borrower" data-id="<?php echo $row['id'] ?>">Edit</button>
                            <button class="btn btn-sm btn-danger remove_borrower" data-id="<?php echo $row['id'] ?>">Delete</button>
                        </center>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</div>
<script>
$('table').dataTable();
$('#new_borrower').click(function(){
    uni_modal('Add New borrower','manage_borrower.php')
})
$('.edit_borrower').click(function(){
    uni_modal('Edit borrower','manage_borrower.php?id='+$(this).attr('data-id'))
})
$('.remove_borrower').click(function(){
    var _conf = confirm("Are you sure to delete this data?");
    if(_conf == true){
        $.ajax({
            url:'ajax.php?action=delete_borrower',
            method:'POST',
            data:{id:$(this).attr('data-id')},
            error:err=>{
                console.log(err)
            },
            success:function(resp){
                if(resp == 1){
                    alert('Data successfully deleted');
                    location.reload()
                }
            }
        })
    }

})
</script>