<?php # CONNECT TO MySQL DATABASE.

# Connect/Link  on 'localhost' .
$link = mysqli_connect('localhost:2306','root','','CodeSpace');
if (!$link) {
# Otherwise fail gracefully and explain the error.
    die('Could not connect to MySQL: ' . mysqli_error());
}
return $link;
//echo 'Connected to the database successfully!';
