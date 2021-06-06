<!DOCTYPE html>
<html>
  <head>
     <title> Homepage </title>
       <link href="mystyles.css" type="text/css" rel="stylesheet">
     
     <script type="text/javascript">
       var seats = document.getElementsByClassName("seats");
       
       //Function to calculate cost of selected seats and to present total and the seats 
       //selected, called when seat checkboxes are selected. Also assigns this data to  
       //form['selected'] which passes this data to book.php on submittal.
       function runningTotal() {
           var selectedSeats = " ";
           var total = 0;
           for (var i = 0; i < seats.length; i++) {
               var seatCost = parseFloat(seats[i].value); 
               if (seats[i].checked == true) {
                   total = total + seatCost;
                   selectedSeats = selectedSeats + seats[i].name + " ";
               }
           }
       
           document.getElementById('totalCost').innerHTML = total.toFixed(2);
           document.getElementById('myPrice').value = total.toFixed(2);
           document.getElementById('mySeats').value = selectedSeats;
           document.getElementById('selectedSeats').innerHTML = selectedSeats;
       }
       
       //Function ensures that client has selected at least one seat before attempting 
       //to 'book'. Called on submittal of form
       function bookingCheck() {
          var noOfSeats = 0;
          for (var i = 0; i < seats.length; i++) {
              if (seats[i].checked) {
                  noOfSeats++;                  
              }
          }
          if(noOfSeats >= 1) {
              document.getElementById("selected").submit();
          }
       }
          
     </script>  
  </head>
  <body>
  <h1> The Albert Theatre </h1>
     <?php 
          
       session_start();       
       echo "<span style='color:white;'> Hi " . $_SESSION['name']. 
            ", please select one or more seats 
             and click 'Book'.";
       $_SESSION['perfTime'] = $_POST['perfTime'];
       $_SESSION['perfDate'] = $_POST['perfDate'];
       $_SESSION['Title'] = $_POST['Title'];
       
       
     ?>
     
     <!--Presents selected seats and running total to client-->
     <p> The total is :  <span id='totalCost'></span></p> 
     <p> You have selected: <span id='selectedSeats'></span></p>
     
     
     <!--Form passes data necessary to write a new booking into the database in book.php-->
     <form action="book.php" id="selected" method="post">
      <input type="hidden" id="myPrice" name="prices" value="">
      <input type="hidden" id="mySeats" name="seats" value="">
      <input style="text-align:left;" type="button" value="Book" onclick="bookingCheck()" >
     </form>
     
     <?php   
    
       echo "<span style='color:white;'> <br>Available seats & corresponding prices for "
            . $_POST['Title']. " at " .
            $_POST['perfTime'] . " on " . $_POST['perfDate'];
    
       include 'connect.php';
       $conn = myConnect();
       
       //Selects the available seats and corresponding prices from database dependent on 
       // which performance client selected in perf.php. 
       if($_POST['Title'] != 'Tosca') {
           $sql = "SELECT Seat.RowNumber, ROUND(Zone.PriceMultiplier * 15.00, 2) AS 'Price'
                   FROM Seat JOIN Zone ON Zone.Name=Seat.Zone
                   WHERE Seat.RowNumber NOT IN
                   (SELECT Booking.RowNumber FROM Booking
                   WHERE Booking.PerfTime='{$_POST['perfTime']}'
                   AND Booking.PerfDate='{$_POST['perfDate']}')";
       } else {
           $sql = "SELECT Seat.RowNumber, ROUND(Zone.PriceMultiplier * 30.00, 2) AS 'Price'
                   FROM Seat JOIN Zone ON Zone.Name=Seat.Zone
                   WHERE Seat.RowNumber NOT IN
                   (SELECT Booking.RowNumber FROM Booking
                   WHERE Booking.PerfTime='{$_POST['perfTime']}'
                   AND Booking.PerfDate='{$_POST['perfDate']}')";
       } 
       $handle = $conn->prepare($sql);
       $handle->execute();
       $conn = null;
       $res = $handle->fetchAll();
       
       //Presents each seat with corresponding price with checkbox that calculates a 
       //running total when checked
       foreach($res as $row) {
	          echo "<li>".$row['RowNumber']." - ".$row['Price']." </li>".   
              "<input type='checkbox' name={$row['RowNumber']} value={$row['Price']} 
                class='seats' onClick='runningTotal()'> " ;}
     ?>
     
    
  </body>
</html>