<?php
session_start();

if (!isset($_SESSION["username"]))
{

    header("location:login.php");

}
else
{
  $current = $_SESSION['username'];
}
?>


<?php


include("config/db_connect");

$errors = array('username'=>'','title'=>'','content'=>'','emptyE'=>'','emptyT'=>'','emptyI'=>'');
  
//     echo $_GET['username'];
//     echo $_GET['title'];
//     echo $_GET['content'];
//    }
$username = $title = $content = '';
if(isset($_POST["submit"]))
{
 
 if(empty($_POST['username']))
 {
    $errors['emptyE']= 'AN username IS REQUIRED <br />';
 }else{
    //echo htmlspecialchars($_POST['username']);
    $username = $_POST['username'];
     if($username != $current)
     {
         $errors['username'] =  'Wrong Username <br/>';
     }
 }
 if(empty($_POST['title']))
 {
       $errors['emptyT']= 'TITLE IS REQUIRED <br/>';
 }    else{ 
    //echo htmlspecialchars($_POST['title']);
    $title = $_POST['title'];
    // if(!preg_match('/^[a-zA-Z\s]+$/',$title))
    // {
    //   $errors['title'] = 'TITLE MUST BE LETTERS AND SPACES ONLY <br/>';
    // }     
 }
 if(empty($_POST['content']))
 {
    $errors['emptyI']= 'content MUST BE ENTERED <br/>';
 }else{     
    //echo htmlspecialchars($_POST['content']);
    $content = $_POST['content'];
    // if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$content))
    // {
    //   $errors['content'] = 'no special characters allowed "," <br/>';
    // }  
 }

 if(array_filter($errors))
 {
   echo 'there are errors in the form';
 }
 else
 {
$username = mysqli_real_escape_string($conn, $_POST['username']);
$title = mysqli_real_escape_string($conn, $_POST['title']);
$content = mysqli_real_escape_string($conn, $_POST['content']);

  $sql = "INSERT INTO stories(title,username,content) VALUES('$title' ,'$username' , '$content')";

  if(mysqli_query($conn, $sql))
  {

    header('Location: index.php')  ;

  }
  else{
    echo 'query error' . mysqli_error($conn);
  }




  
 }
}
 


?>
<!DOCTYPE html>
<html lang="en">
<style>
body {
  background-color: #f0f0f0; 
}
.container_ {
  background-color: #ffffff; 
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  max-width: 600px; 
  margin: 0 auto; 
}

    </style>

<?php include('templates/backtohome.php') ?>  

<section class="container_ grey-text">
    <h4 class="center">Add a story</h4>
    <form class="white" action="add.php" method="POST">
        <label for="">Your username:</label>
        <input type="text" name="username" value = "<?php echo  htmlspecialchars($username); ?>">
        <div class="red-text"><?php echo $errors['emptyE']; ?></div>
        <div class="red-text"><?php echo $errors['username']; ?></div>
        <label for="">story title:</label>
        <input type="text" name="title" value = "<?php echo  htmlspecialchars($title); ?>">
        <div class="red-text"><?php echo $errors['emptyT']; ?></div>
        <div class="red-text"><?php echo $errors['title']; ?></div>
        <label for="">content (you can style your content ;)):</label>
        <input type="text" name="content" value = "<?php echo $content ; ?>">
        <div class="red-text"><?php echo $errors['emptyI']; ?></div>
        <div class="red-text"><?php echo $errors['content']; ?></div>
        <div class="center">
        <br>
            <input type="submit" value="submit" name="submit" class="btn waves-effect waves-light">
        </div>
    </form>
    <div class="center" style="margin-top: 20px;">
      <strong> ------------- or -------------</strong>
      <br>
      <br>
        <a href="idea.php" class="btn waves-effect waves-light">Get idea from external website</a>
    </div>
</section>



    
</body>
</html>