<?php
global $link;
include 'includes/nav.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    # Connect to the database.
    require('connect_db.php');

    # Initialize an error array.
    $errors = array();

    # Check for item name .
    if ( empty( $_POST[ 'item_name' ] ) )
    { $errors[] = 'Enter the item name.' ; }
    else
    { $n = mysqli_real_escape_string( $link, trim( $_POST[ 'item_name' ] ) ) ; }

    # Check for a item decription.
    if (empty( $_POST[ 'item_desc' ] ) )
    { $errors[] = 'Enter the item decription.' ; }
    else
    { $d = mysqli_real_escape_string( $link, trim( $_POST[ 'item_desc' ] ) ) ; }

    # Check for a item image.
    if (empty( $_POST[ 'item_img' ] ) )
    { $errors[] = 'Enter the item image.' ; }
    else
    { $img = mysqli_real_escape_string( $link, trim( $_POST[ 'item_img' ] ) ) ; }

    # Check for a item price.
    if (empty( $_POST[ 'item_price' ] ) )
    { $errors[] = 'Enter the item image.' ; }
    else
    { $p = mysqli_real_escape_string( $link, trim( $_POST[ 'item_price' ] ) ) ; }


    # On success data into my_table on database.
    if ( empty( $errors ) )
    {
        $q = "INSERT INTO products (item_name, item_desc, item_img, item_price) 
	VALUES ('$n','$d', '$img', '$p' )";
        $r = @mysqli_query ( $link, $q ) ;
        if ($r)
        { echo '<p>New record created successfully</p>'; }

        # Close database connection.
        mysqli_close($link);

        exit();
    }

    # Or report errors.
    else
    {
        echo '<p>The following error(s) occurred:</p>' ;
        foreach ( $errors as $msg )
        { echo "$msg<br>" ; }
        echo '<p>Please try again.</p></div>';
        # Close database connection.
        mysqli_close( $link );

    }
}

?>


<h1>Add Item</h1>
<form action="create.php" method="post" >
    <!-- input box for item name  -->
    <label for="name">Item Name:</label>
    <input type="text"
           id="item_name"
           class="form-control"
           name="item_name"
           required
           value="<?php if (isset($_POST['item_name'])) echo $_POST['item_name']; ?> ">

    <!-- input box for item description -->
    <label for="description">Description:</label>
    <textarea id="item_desc"
              class="form-control"
              name="item_desc"
              required
              value="<?php if (isset($_POST['item_desc'])) echo $_POST['item_desc']; ?>">
	  </textarea>

    <!-- input box for image path -->
    <label for="image">Image:</label>
    <input type="text"
           id="item_img"
           class="form-control"
           name="item_img"
           required
           value="<?php if (isset($_POST['item_img'])) echo $_POST['item_img']; ?>">

    <!-- input box for item price -->
    <label for="price">Price:</label>
    <input
        type="number"
        id="item_price"
        class="form-control"
        name="item_price"
        min="0" step="0.01"
        required
        value="<?php if (isset($_POST['item_price'])) echo $_POST['item_price']; ?>"><br>
    <!-- submit button -->
    <input type="submit" class="btn btn-dark" value="Submit">
</form>
</div>

<?php
include 'includes/footer.php';
?>