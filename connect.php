<!DOCTYPE html>
<html>
<head></head>
<body>
     <?php
     function myConnect() {       
	    $host = 'dragon.ukc.ac.uk';
	    $dbname = 'lbca3';
	    $user = 'lbca3';
	    $pwd = 'umopee6';
	    try {
		    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    if ($conn) {
			    echo '';
			    // here goes some other code that uses $conn ...
			    //$conn = null; //(Uncomment to kill the connection)
		    } else {
			    echo 'Failed to connect';
		    }
	    } catch (PDOException $e) {
		    echo "PDOException: ".$e->getMessage();
	    }
	    return $conn;
	    }
    ?>



</body>   
</html>