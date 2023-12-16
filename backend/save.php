<?php
	include 'conn.php';

	// add
	if(count($_POST) > 0){
		if($_POST['type'] == 1) {
			$fbname = $_POST['fbname'];
			$clubid = $_POST['clubid'];
			$postid = $_POST['postid'];

			$sql = "insert into footballers ("
						. "fbname "
						. ", clubid "
						. ", postid "
					. ") values ( "
						. "'" . $fbname . "'"
						. ", '" . $clubid . "'"
						. ", '" . $postid . "'"
					. ");";
 
			if (mysqli_query($conn, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			mysqli_close($conn);
		}
	}

	// update
	if(count($_POST) > 0) {
		if($_POST['type'] == 2) {
			$fbid = $_POST['fbid_u'];
			$fbname = $_POST['fbname_u'];
			$clubid = $_POST['clubid_u'];
			$postid = $_POST['postid_u'];
 
			$sql = "update footballers set "
						. " fbname = '$fbname' "
						. ", clubid = '$clubid' "
						. ", postid = '$postid' "
					. " where fbid = '$fbid'";
 
			if (mysqli_query($conn, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
 
			mysqli_close($conn);
		}
	}

	// delete one
	if(count($_POST) > 0) {
		if($_POST['type'] == 3) {
			$id = $_POST['fbid'];

			$sql = "delete from footballers where fbid = '$id'";
			if (mysqli_query($conn, $sql)) {
				echo json_encode(array("id" => $id));
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			mysqli_close($conn);
		}
	}

	// delete bulk
	if(count($_POST) > 0){
		if($_POST['type'] == 4){
			$id = $_POST['id'];
 
			$sql = "delete from screens where screenid in ($id)";
 
			if (mysqli_query($conn, $sql)) {
				echo $id;
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
 
			mysqli_close($conn);
		}
	}
?>