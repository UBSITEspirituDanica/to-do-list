<?php 
require 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <h2 class="mb-3">To-Do List:</h2>
       <div class="add-section">
          <form action="app/add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                     name="title" 
                     style="border-color: #ff6666"
                     placeholder="This field is required!" />
              <button type="submit" class="btn btn-primary">Add +</button>

             <?php }else{ ?>
              <input type="text" 
                     name="title" 
                     placeholder="What do you need to do?" />
              <button type="submit" class="btn btn-primary">Add +</button>
             <?php } ?>
          </form>
       </div>
       <?php 
          $lists = $conn->query("SELECT * FROM lists ORDER BY id DESC");
       ?>
       <div class="show-list-section">
            <?php if($lists->rowCount() <= 0){ ?>
                <div class="list-item">
                    <div class="empty">
                        <img src="img/f.png" width="100%" />
                        <img src="img/Ellipsis.gif" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while($list = $lists->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="list-item">
                    <span id="<?php echo $list['id']; ?>"
                          class="remove-list">x</span>
                    <?php if($list['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-list-id ="<?php echo $list['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $list['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-list-id ="<?php echo $list['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $list['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>Created: <?php echo $list['date_time'] ?></small> 
                </div>
            <?php } ?>
       </div>

       <div class="pdf-section">
        <form action="app/pdf.php" method="POST">
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </form>
       </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.remove-list').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/delete.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-list-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>