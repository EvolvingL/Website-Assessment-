<!DOCTYPE html>
<html>
  <head>
     <title> Homepage </title>
       <link href="mystyles.css" type="text/css" rel="stylesheet">
  </head>
  <body>
  <h1> The Albert Theatre </h1>

     <?php 
       
       echo "<span style='color:white;'> Welcome to the Albert, " . $_POST["name"] . ", 
             have a look at what we have on below!";
       include 'connect.php'; 
       
       //connects to database
       $conn = myConnect(); 
       
       //accesses list of performances from database
       $sql = "SELECT *
              FROM Performance p JOIN Production r
              ON p.Title=r.Title;"; 
       $handle = $conn->prepare($sql);
       $handle->execute();
       $conn = null;
       $res = $handle->fetchAll();
       
       //form for each performance each with it's own button to check availability, 
       //hidden input fields used to pass data to seats.php
       foreach($res as $row) {       
	       echo "<br><li>".$row['Title']." - ".$row['PerfDate']."- ".$row['PerfTime']." </li>".
	       "<form action='seats.php' method='post'>
            <input type='submit' value='See Availability' />
            <input type='hidden' name='Title' value={$row['Title']}>
            <input type='hidden' name='perfDate' value={$row['PerfDate']}>
            <input type='hidden' name='perfTime' value={$row['PerfTime']}>
            </form>";  }
       
       //Use of sessions to pass personal data to seats.php & book.php 
       session_start();
       $_SESSION['name'] = $_POST["name"];
       $_SESSION['email'] = $_POST["email"];
       
    ?>
    
  </body>
</html>
   