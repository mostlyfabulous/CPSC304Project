<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<?php include 'Utility.php'; ?>
<h>Chef PHP table</h>
<a href="index.php">Index page</a>
<br><br>
<form method="GET" action="Chef.php">
Input Chef ID to see items you're responsible for cooking:
<p> <input type="text" name="insChefID" size="10"placeholder="Chef ID">
<!--define 3 variables to pass the value-->
<input type="submit" value="submit" name="listsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->

<form method="GET" action="Chef.php">
Update the ingredient quantity to reflect the amount used
<p> <input type="text" name="branchID" size="18" placeholder="Branch ID">
<!--define two variables to pass the value-->
<input type="submit" value="Update ingredient quantity" name="updatesubmit">
</form> <br>

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
// Connect Oracle...
if ($db_conn) {
		if (array_key_exists('listsubmit', $_GET)) {
      // echo gettype($_GET['insMenuItemID']), "\n";
      // echo gettype($_GET['insBranchID']), "\n";
      // $result = executePlainSQL("select * from Contains inner join MenuItem on
      // Contains.MenuItemID = MenuItem.MenuItemID and Contains.branchID = MenuItem.branchID
      // where Contains.menuItemID='" . $_GET['insMenuItemID'] . "' and Contains.branchID='" . $_GET['insBranchID'] . "'");

      $result = executePlainSQL("select * from MenuItem where chefID='" . $_GET['insChefID'] . "'");
      // $result = executePlainSQL("select * from Contains inner join MenuItem on Contains.MenuItemID = MenuItem.MenuItemID and Contains.branchID = MenuItem.branchID where Contains.MenuItemID='" . $_GET['insMenuItemID'] . "' and Contains.branchID='" . $_GET['insBranchID'] . "'");
      // $result = executePlainSQL("select * from Contains
      //     inner join MenuItem on Contains.MenuItemID = MenuItem.MenuItemID and Contains.branchID = MenuItem.branchID
      //     where Contains.MenuItemID='MI006' and Contains.branchID='B1235'");


      // select * from Contains inner join MenuItem on Contains.MenuItemID = MenuItem.MenuItemID
      // and Contains.branchID = MenuItem.branchID where Contains.menuItemID='MI006' and Contains.branchID='B1235';

      printIList($result);
		} else
			if (array_key_exists('updatesubmit', $_GET)) {
        // echo "here now";
        // echo  $_GET['quantity'];
        // echo $_GET['ingredientName'];
        // echo  $_GET['branchID'];
        // echo $_GET['lotNumber'];
        // $result = executePlainSQL("select * from IngredientsInStock
        // where ingredientName = '" . $_GET['ingredientName'] . "' and branchID = '" . $_GET['branchID'] . "'
        // and lotNumber = " . $_GET['lotNumber'] . "");
        $result = executePlainSQL("select * from IngredientsInStock where branchID ='" . $_GET['branchID'] . "'");
        // executePlainSQL("update IngredientsInStock
        // set quantityLeft = quantityLeft - 1
        // where ingredientName = 'Russet Potato' and
        // branchID = 'B1234' and
        // lotNumber = 60");

				OCICommit($db_conn);
        // $result = executePlainSQL("select * from IngredientsInStock
        // where ingredientName = '" . $_GET['ingredientName'] . "' and
        // branchID = '" . $_GET['branchID'] . "' and
        // lotNumber = '" . $_GET['lotNumber'] . "'");

        // $result = executePlainSQL("select * from IngredientsInStock where ingredientName = 'Russet Potato'
        // and branchID = 'B1234' and lotNumber = 60");
        printUpdateIList($result);

        // select * from IngredientsInStock where ingredientName = 'Russet Potato'
        // and branchID = 'B1234' and lotNumber = '60'

        // update IngredientsInStock
        // set quantityLeft = quantityLeft - 1
        // where ingredientName = 'Russet Potato' and
        // branchID = 'B1234' and
        // lotNumber = '60'
			}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: Chef.php");
	} else {
		// Select data...
	}
	//Commit to save changes...
	pg_close($db_conn);
} else {
	echo "cannot connect";
	$e = pg_last_error();
	echo htmlentities($e);
}

?>
