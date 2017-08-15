<?php
/*
Template Name: Admin
*/

?>

<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>


<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Officer</title>
  <link rel="stylesheet" type="text/css" href="http://localhost/wordpress/wordpress/wp-content/themes/sydney/style.css" />
</head>
<body class = "officerbody">
  <h1 style = "text-align:center" class = "h1officer">Hello Admin</h1>

<?php
  require_once(dirname(__FILE__).'/connectvars.php');
    $a = dirname(__FILE__).'/images/';
  define('GW_UPLOADPATH',$a);
  define('GW_MAXFILESIZE', 327680); 

  // Generate the navigation menu
  if (isset($_SESSION['username'])) {

    echo '&#10084 <a href="http://localhost/wordpress/wordpress/officerlogout/">Log Out (' . $_SESSION['username'] . ')</a>';
  }
  else {
    echo '&#10084; <a href="http://localhost/wordpress/wordpress/officer-login/">Log In</a><br />';
  }
  if (isset($_SESSION['user_id']))
  { // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Error ."); 
  $use = $_SESSION['username'];
  $count =0;
  // Retrieve the user data from MySQL
  $query = "SELECT fname,lname,user_id,username,profilephoto,field FROM officers WHERE username = '$use'";
  $data = mysqli_query($dbc, $query);
  $row = mysqli_fetch_array($data);
  $field = $row['field'];
  echo'<div class = "officers">';
  echo'<div class = "officerbasic">';
  echo'<p><strong> Name : </strong>'.$row['fname'].' '.$row['lname'].' </p>';
  echo'<p><strong> User Id : </strong>'.$row['user_id'].' </p>';
  echo'<p><strong> User Name : </strong>'.$row['username'].' </p>';
  // Loop through the array of user data, formatting it as HTML
  echo'</div>';
  echo'<div class = "officercomplaints">';
  $query1 = "SELECT * FROM complaint WHERE approve = 0 ";
   $data1 = mysqli_query($dbc, $query1) or die("Queery no twok");
  echo '<h2> Id of the  unapproved complaints are given below</h2>';
  echo '<p> click on the approve link to approve the complaint </p></br>';  
  echo '<table>';
  echo '<tr><th>Complaint_id    </th><th>Starting Date    </th><th>Approve link</th></tr>';
  while($row1 = mysqli_fetch_array($data1))
  { if($row1['approve'] ==0){
     $count++;
     echo '<tr class="scorerow"><td><strong>' . $row1['id'] . '</strong></td>';
    echo '<td>' . $row1['start'] . '</td>'; 
     echo '<td><a href="http://localhost/wordpress/wordpress/approve/?id=' . $row1['id'] . '&amp;start=' . $row1['start'] . '&amp;fname=' . $row1['fname'] . '&amp;lname=' . $row1['lname'] . '&amp;description=' . $row1['descrip'].
      '&amp;email=' . $row1['email'] . '&amp;designation=' . $row1['designation']. '&amp;field=' . $row1['field']. '&amp;compphoto=' . $row1['compphoto']. '&amp;contact=' . $row1['contact'].
	   '&amp;idno=' . $row1['idno'].'&amp;photoid='. $row1['photoid'].' ">Approve</a>';	
     }
  
  }
  echo'</table>';
  if($count == 0)
      echo'<p style = "color:rgb(256,0,0); font-size : 200%"> no files are pending for approving</p>';
   echo'</div>';
  mysqli_close($dbc);
     echo '<p><a href="http://localhost/wordpress/wordpress/">&lt;&lt; Back to home page</a></p>';
  
  }
  ?>
  </body>
  </html>