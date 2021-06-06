<!DOCTYPE html>
<html>
<head>
    <title> Homepage </title>
           <link href="mystyles.css" type="text/css" rel="stylesheet">
           
</head> 
<body>
    <h1> The Albert Theatre </h1>
    
    <?php 
       
       session_start();
       echo "<span style='color:white;'> Hi " . $_SESSION['name']. ", thank you for your purchase. <br><br>
             Booking summary for: ";
       
       echo "<span style='color:white;'> <br><br>Our performance of " . $_SESSION['Title']. " at " .
             $_SESSION['perfTime'] . " on " . $_SESSION['perfDate']. "<br><br>";
    

       // server side validation 
       if (isset ($_POST['seats'])) {
       
           // Receives string of selected seats from seats.php ($_POST['seats']) and divides it into
           //an array of individual seats 
           $seats = explode(" ", $_POST['seats']);
           include 'connect.php';
           $conn = myConnect();
       
          //loops through array and creates an entry in Booking database for client before 
          // informing client that the booking has been successful
          for ($i = 1; $i < count($seats)-1; $i++) {
             $sql = "INSERT INTO Booking
                     VALUES (:n ,'{$_SESSION['perfDate']}',
                     '{$_SESSION['perfTime']}','$seats[$i]')";
             $handle = $conn->prepare($sql);
             $email = $_SESSION['email'];
             $handle->execute(array(':n' => $email));
             echo "<li>Seat " . $seats[$i]." successfully booked.<br>";
          }
          $conn = null;
    
          echo "<br><br>Total paid = " . $_POST['prices'];           
          echo "<br><br>We hope you enjoy your visit to the Albert!";
       
       } else {
           echo "No seats selected";
       }
       
              
      session_destroy()
    ?>
    
    
</body>
</html>