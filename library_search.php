<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $title = isset($_GET['title']) ?$_GET['title'].' | ': '';  ?>
    <title><?php echo ucwords($title) ?>Library Management System </title>
    <?php include('header.php') ?>

    <style>
       body {
        background-image: url(./assets/img/library.jpg);
        height: 96vh;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
        #load_modal{
            background: #00000026;
            height:calc(100%);
            width:calc(100%);
            position:fixed;
            top:0;
            left:0;
            display:none;
            align-items:center;
            z-index:99999
        }
        #load_modal .card{
            margin:auto;
        }
    </style>
</head>
<body>
<header>
<?php 
    include 'db_connect.php';
?>
</header>

<main class="" id='ls'>
    <div class="container-fluid mt-5">
       <div class="col-md-12">
            <div class="row">
                <div class="col-md-5 offset-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" >Search</span>
                        </div>
                        <input type="text" class="form-control" id="filter">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <?php 

            $books = $conn->query("SELECT * FROM books order by `location` asc ");
            while($row=$books->fetch_assoc()){
        ?>
        <div class="col-md-12 books-field" id="" data-id="<?php echo $row['id'] ?>">
            <div class="card card-cascade wider ml-1 mr-1 float-left" style="width:20%">
                <div class="view view-cascade overlay">
                    <?php  if(empty($row['img_path'])): ?>
                <img class="card-img-top" src="assets/img/book.jpg" alt="Card image cap">
                    <?php  else: ?>
                <img class="card-img-top" src="<?php echo $row['img_path'] ?>" alt="Card image cap">
                    <?php  endif; ?>
                <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                </a>
                </div>

                <div class="card-body card-body-cascade text-center pb-0">

                <h4 class="card-title"><strong><?php echo $row['title'] ?></strong></h4>
                <h5 class="blue-text pb-2"><strong><?php echo $row['author'] ?></strong></h5>
                <p class="card-text text-truncate"><?php echo $row['description'] ?></p>

               
                </div>

            </div>
        </div>
            <?php } ?>
        <script>
          $('.books-field').click(function(){
            uni_modal('Book Details and Location','locate_book.php?id='+$(this).attr('data-id'))
          })
        $(document).ready(function(){
            $('#filter').on('keyup', function(){
                var _field = $('.books-field')
                var filter = $(this).val().toLowerCase()
                _field.each(function(){
                    var title = $(this).find('.card-title strong').text()
                    var author = $(this).find('.blue-text strong').text()
                    var description = $(this).find('.card-text').text()
                   title =  title.toLowerCase();
                   author =  author.toLowerCase();
                  description =   description.toLowerCase();
                    if(title.includes(filter) || author.includes(filter) || description.includes(filter))
                        $(this).toggle(true)
                    else
                        $(this).toggle(false)

                })
            })
        })
        </script>

    </div>
  </main>

  <div class="modal fade" id="delete_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      
      </div>
    </div>
  </div>
  <div id="load_modal">
      <div class="card">
        <div class="card-body">
        <center><div class="spinner-border text-info" role="status">
        <span class="sr-only">Loading...</span>
      </div>  <br>
      <small><b>Please wait...</b></small>
        
      </center>
        </div>
      </div>
  </div>
</body>
<script>
window.uni_modal = function($title = '' , $url=''){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occured")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                $('#uni_modal').modal('show')
                end_load()
            }
        }
    })
}
window.start_load = function(){
    $('#load_modal').css({'display':'flex'})
}
window.end_load = function(){
    $('#load_modal').css({'display':'none'})
}
</script>
</html>