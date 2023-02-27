<?php
include("db_conn.php");

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
     ?>
     <!DOCTYPE html>
     <html>

     <head>
          <title>HOME</title>
          <link rel="stylesheet" type="text/css" href="home.css">
     </head>

     <body>

          <div class="container">
          <a href="logout.php"><button>Logout </button></a>
               <h1>Hello,
                    <?php echo $_SESSION['name'];  ?>
                   💅
               </h1>
     
               <h2>Add New Task</h2>
               <form action="input_task.php" method="POST">
                    <p>Task Name : </p>
                    <input type="text" name="task_name">
                    <br>
                    <p>Deadline : </p>
                    <input type="date" name="date">
                    <br>
                    <input type="submit" value="Submit" name="add">
               </form>
               <br>
               <div>
                    <h2>Task</h2>
                    <ol>
                         <?php
                         $user_id = $_SESSION['id'];

                         $sql = "SELECT * FROM `task` WHERE `user_id` =  $user_id AND `status` = 0";
                         $query = mysqli_query($conn, $sql);

                         $x = 0;
                         while($task = mysqli_fetch_array($query)) {
                              $x++;
                              $vars = array('id' => $task['task_id'], 'value' => $task['status']);
                              $querystring = http_build_query($vars);

                              $edit_url = "change_status.php?" . $querystring;

                              echo "<li>";
                              echo "$task[task_name] - $task[date] ";
                              echo "<a href='$edit_url'><button>Done</button></a>";
                              echo "<a href='delete_task.php?id=" . $task['task_id'] . "'><button>Delete</button></a>";
                              echo "</li>";
                    
                         }
                         if($x==0){
                         echo "There's no task todo"; }
                         ?>
                    </ol>
               </div>
               <div>
                    <h2>Completed Task</h2>
                    <ol>
                         <?php
                         $user_id = $_SESSION['id'];

                         $sql = "SELECT * FROM `task` WHERE `user_id` =  $user_id AND `status` = 1";
                         $query = mysqli_query($conn, $sql);


                         $y = 0;
                         while ($task = mysqli_fetch_array($query)) {
                              $y++;
                              $vars = array('id' => $task['task_id'], 'value' => $task['status']);
                              $querystring = http_build_query($vars);

                              $edit_url = "change_status.php?" . $querystring;

                              echo "<li>";
                              echo "<s>$task[task_name] - $task[date]</s> ";
                              echo "<a href='$edit_url'><button>Restore</button></a>";
                              echo "</li>";
                         }
                         if($y==0 ){
                              echo "There's no completed task"; }
                         ?>
                    </ol>
               </div>
          </div>


     </body>

     </html>

<?php
} else {
     header("Location: index.php");
     exit();
}
?>