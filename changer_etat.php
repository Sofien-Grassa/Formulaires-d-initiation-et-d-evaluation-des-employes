     <?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "stipdb";
$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
extract($_POST);
$query="UPDATE t_fi001_parent SET etat='$etat' where id='$id'";
// echo $query;
$res=mysqli_query($conn, $query);
if($res)
echo '1';
else 
echo '2'

?>