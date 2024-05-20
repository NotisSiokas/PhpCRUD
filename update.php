<?php
# Include navigation
global $link;
include('includes/nav.php');

# Open database connection.
require('connect_db.php');

# Check if item_id is provided in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($link, trim($_GET['id']));

    # Retrieve the item from the database
    $q = "SELECT * FROM products WHERE item_id = $id";
    $r = mysqli_query($link, $q);

    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    } else {
        echo '<p>Item not found.</p>';
        $row = null; // Set $row to null if item not found to avoid errors in the form
    }
} else {
    echo '<p>Invalid item ID.</p>';
    $row = null; // Set $row to null if item_id not provided
}
?>

<h1>Update Item</h1>
<form action="update.php?id=<?php echo $row ? $row['item_id'] : ''; ?>" method="post">
    <input type="hidden" name="item_id" value="<?php echo $row ? $row['item_id'] : ''; ?>">

    <label for="name">Item Name:</label>
    <input type="text" id="item_name" name="item_name" value="<?php echo $row ? $row['item_name'] : ''; ?>"><br><br>

    <label for="desc">Description:</label>
    <textarea id="item_desc" name="item_desc"><?php echo $row ? $row['item_desc'] : ''; ?></textarea><br><br>

    <label for="img">Image:</label>
    <input type="text" id="item_img" name="item_img" value="<?php echo $row ? $row['item_img'] : ''; ?>"><br><br>

    <label for="price">Price:</label>
    <input type="number" id="item_price" name="item_price" value="<?php echo $row ? $row['item_price'] : ''; ?>"><br><br>

    <input type="submit" value="Update">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Initialize an error array.
    $errors = array();

    # Validate and Sanitize input
    if (empty($_POST['item_id'])) { $errors[] = 'Update item ID.'; }
    else { $id = mysqli_real_escape_string($link, trim($_POST['item_id'])); }

    if (empty($_POST['item_name'])) { $errors[] = 'Update item name.'; }
    else { $n = mysqli_real_escape_string($link, trim($_POST['item_name'])); }

    if (empty($_POST['item_desc'])) { $errors[] = 'Update item description.'; }
    else { $d = mysqli_real_escape_string($link, trim($_POST['item_desc'])); }

    if (empty($_POST['item_img'])) { $errors[] = 'Update image address.'; }
    else { $img = mysqli_real_escape_string($link, trim($_POST['item_img'])); }

    if (empty($_POST['item_price'])) { $errors[] = 'Update item price.'; }
    else { $p = mysqli_real_escape_string($link, trim($_POST['item_price'])); }

    # On success data into my_table on database.
    if (empty($errors)) {
        $q = "UPDATE products SET item_name=?, item_desc=?, item_img=?, item_price=? WHERE item_id=?";
        $stmt = mysqli_prepare($link, $q);

        // Bind parameters (data types ssssd for string, string, string, string, double)
        mysqli_stmt_bind_param($stmt, "sssdi", $n, $d, $img, $p, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: read.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt); // Close prepared statement

    } else {
        echo '<p>The following error(s) occurred:</p>';
        foreach ($errors as $msg) {
            echo "$msg<br>";
        }
        echo '<p>Please try again.</p></div>';
    }
}

include('includes/footer.php');
?>
