<PHP> <link rel="stylesheet" type="text/css" href="enjoy.css"></head> <PHP>
<?php include 'Utility.php'; ?>
<h>Manager PHP table</h><a href="index.php">Index page</a>
<!-- <p>If you wish to reset the table, press the reset button.</p>
<form method="POST" action="Manager.php">
<p><input type="submit" value="Reset" name="reset"></p>
</form> -->

<p> TODO: DELETE Ingredient when Manager transfers Ingredient to Place </p>
<p>Retrieve Ingredients in Stock TODO: at a Branch ID:</p>
<form method="POST" action="Manager.php">
<!--refresh page when submit-->
<p> <input type="text" name="insBranchID" size="10"placeholder="Branch ID">

<input type="submit" value="insert" name="insertsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to
get the values-->

<?php
  // Create's drown down selection menu based on availble restaurants
  $statement = "Select E.BRANCHID, COUNT(*) From Employee E, Restaurant R Where E.branchid=R.branchid GROUP BY E.branchid";
  $result = executePlainSQL($statement);
  printCountEmployeesByBID($result);

?>

<!-- <input type="submit" value="run hardcoded queries" name="dostuff"></p> -->
</form>

<?php

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table ORDERHAS");

		// Create new table...
		echo "<br> creating new table <br>";
		executePlainSQL("create table ORDERHAS (ORDERID CHAR(30), MENUITEMID CHAR(30), primary key (ORDERID, MENUITEMID))");
		OCICommit($db_conn);

	} else
		if (array_key_exists('insertsubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insORDERID'],
				":bind2" => $_POST['insMenuItemID'],
        ":bind3" => $_POST['insBranchID']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into ORDERHAS values (:bind1, :bind2, :bind3)", $alltuples);
			OCICommit($db_conn);

		} else
			if (array_key_exists('updatesubmit', $_POST)) {
				// Update tuple using data from user
				$tuple = array (
					":bind1" => $_POST['oldName'],
					":bind2" => $_POST['newName']
				);
				$alltuples = array (
					$tuple
				);
				executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
				OCICommit($db_conn);

			} else
				if (array_key_exists('dostuff', $_POST)) {
					// Insert data into table...
					// executePlainSQL("insert into Orders values (10, 'Frank')");
					// Inserting data into table using bound variables
					$list1 = array (
						":bind1" => 'O0001',
						":bind2" => 'Grass'
					);
					$list2 = array (
						":bind1" => 'O0002',
						":bind2" => 'Water'
					);
					$allrows = array (
						$list1,
						$list2
					);
					executeBoundSQL("insert into OrderHas values (:bind1, :bind2)", $allrows); //the function takes a list of lists
					// Update data...
					//executePlainSQL("update tab1 set nid=10 where nid=2");
					// Delete data...
					//executePlainSQL("delete from tab1 where nid=1");
					OCICommit($db_conn);
				}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: Manager.php");
	} else {
		// Select data...
		// $result = executePlainSQL("select * from ORDERHAS");
		// printResult($result);
	}
	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

?>
<!--
$result = executePlainSQL("select * from Restaurant");
"echo <form method="GET" action='Manager.php'>"
dropdownBranches($result);
echo "<p><input type='submit' value='Submit'></p>";
echo "</form>";
if ($db_conn && array_key_exists('selectbid', $_GET)) {
Get MenuItems by BranchID
echo "<p> Fetching Menu Items from Branch: " . $_GET['selectbid'] . "</p>";
$sqlquery = "select * from MenuItem where BRANCHID='" . $_GET['selectbid'] . "'";
$result = executePlainSQL($sqlquery);
printMenuItems($result);
} -->
