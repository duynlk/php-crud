<?php
	include 'backend/config.php';
	include 'backend/conn.php';
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="favicon.png">
		<title><?php echo $title; ?>&nbsp;<?php echo $copyRight; ?></title>

		<link rel="stylesheet" href="./lib/fontawesome/css/all.min.css">
		<link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="./custom/style.css">

		<script src="./lib/jquery/jquery.min.js"></script>
		<script src="./lib/bootstrap/js/bootstrap.min.js"></script>
		<script src="./custom/script.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="table-wrapper">
				<!-- Head area -->
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<h2><b><?php echo $title; ?></b></h2>
							<small><?php echo $copyRight; ?></small>
						</div>
						<div class="col-sm-6">
							<button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#addModal">
								<i class="fa-solid fa-circle-plus"></i>&nbsp;
								Add New
							</button>
							<button type="button" class="btn btn-danger float-end me-2" role="button" id="delete_multiple">
								<i class="fa-solid fa-trash-can"></i>&nbsp;
								Delete Bulk
							</button>
						</div>
					</div>
				</div>
				<!-- Filter area -->
				<div class="table-search">
					<input type="text"
							value="<?php echo isset($_SESSION['fName']) ? $_SESSION["fName"] : ''; ?>"
							id="filter-name"
							class="form-control w-25 d-inline"
							placeholder="Name">&nbsp;
					<select class="form-select d-inline w-25" id="filter-club">
						<option value="0">Choose Club</option>
						<?php
							$sql = "select * from clubs";
							$result = mysqli_query($conn, $sql);
							$clubArr = array();
							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
								array_push($clubArr, array($row["clubid"], $row["clubname"]));
							?>
						<option value="<?php echo $row["clubid"]; ?>">
							<?php echo $row["clubid"]; ?> : <?php echo $row["clubname"] ?>
						</option>
						<?php } ?>
					</select>
					<input type="hidden" id="filter-club-hid" value="<?php echo isset($_SESSION['fClub']) ? $_SESSION["fClub"] : ''; ?>">
					&nbsp;
					<select class="form-select d-inline w-25" id="filter-position">
						<option value="0">Choose Position</option>
						<?php
							$sql = "select * from positions";
							$result = mysqli_query($conn, $sql);
							$positionArr = array();
							while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
								array_push($positionArr, array($row["postid"], $row["posname"]));
							?>
						<option value="<?php echo $row["postid"]; ?>">
							<?php echo $row["postid"]; ?> : <?php echo $row["posname"] ?>
						</option>
						<?php } ?>
					</select>
					<input type="hidden" id="filter-position-hid" value="<?php echo isset($_SESSION['fPosition']) ? $_SESSION["fPosition"] : ''; ?>">
					&nbsp;
					<button type="button" class="btn btn-secondary" id="filter">
						<i class="fa-solid fa-filter"></i>&nbsp;
						Filter
					</button>
					&nbsp;
					<button type="button" class="btn btn-secondary" id="reset">
						<i class="fa-solid fa-eraser"></i>&nbsp;
						Reset
					</button>
				</div>
				<!-- List area -->
				<div>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th style="width: 5%;">
									<span class="custom-checkbox">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
									</span>
								</th>
								<th style="width: 10%;">No.</th>
								<th style="width: 20%;">Name</th>
								<th style="width: 25%;">Club</th>
								<th style="width: 25%;">Position</th>
								<th style="width: 15%;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$condArr = [];
								$condWhere = "";
								if (isset($_SESSION["fName"])){
									array_push($condArr, " fb.fbname like '%" . $_SESSION["fName"] . "%' ");
								}
								if (isset($_SESSION["fClub"])){
									array_push($condArr, " clb.clubid = " . $_SESSION["fClub"] . " ");
								}
								if (isset($_SESSION["fPosition"])){
									array_push($condArr, " pos.postid = " . $_SESSION["fPosition"] . " ");
								}
								if(count($condArr) > 0){
									$condWhere = " where " . join(" and ", $condArr);
								}

								$sql = "select fb.fbid, fb.fbname, clb.clubid, clb.clubname, pos.postid, pos.posname "
										. " from footballers fb "
										. " left join positions pos on fb.postid = pos.postid "
										. " left join clubs clb on fb.clubid = clb.clubid "
										. $condWhere
										. " order by fb.fbid desc";
								$result = mysqli_query($conn, $sql);
								$i = 1;
								while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
							?>
								<tr id="<?php echo $row["fbid"]; ?>">
									<td>
										<span class="custom-checkbox">
										<input type="checkbox" class="fbid_checkbox" data-fbid="<?php echo $row["fbid"]; ?>">
										<label for="checkbox2"></label>
										</span>
									</td>
									<td><?php echo $i; ?></td>
									<td><b class="text-success"><?php echo $row["fbname"]; ?></b></td>
									<td><?php echo $row["clubname"]; ?></td>
									<td><?php echo $row["posname"]; ?></td>
									<td>
										<button type="button" class="btn btn-primary update" data-bs-toggle="modal" data-bs-target="#editModal">
										<i class="fa-solid fa-pen-to-square"
											data-fbid="<?php echo $row["fbid"]; ?>"
											data-fbname="<?php echo $row["fbname"]; ?>"
											data-clubid="<?php echo $row["clubid"]; ?>"
											data-postid="<?php echo $row["postid"]; ?>"
										></i>
										</button>
										<button type="button" class="btn btn-danger delete" data-fbid="<?php echo $row["fbid"]; ?>" data-bs-toggle="modal" data-bs-target="#deleteScreenModal">
										<i class="fa-solid fa-circle-minus"></i>
										</button>
									</td>
								</tr>
							<?php
								$i++; }
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Add Modal -->
		<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<form id="add_form">
						<div class="modal-header">
							<h3 class="modal-title">Add Footballer</h3>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="form-group mb-3">
								<label for="fbname" class="form-label">Name</label>
								<input type="text" id="fbname" name="fbname" class="form-control" required>
							</div>
							<div class="form-group mb-3">
								<label for="clubid" class="form-label">Club</label>
								<select id="clubid" name="clubid" class="form-select">
									<option selected>---</option>
									<?php
										for($i = 0; $i < sizeof($clubArr); $i++)
										{
										?>
									<option value="<?php echo $clubArr[$i][0]; ?>">
										<?php echo $clubArr[$i][0]; ?> : <?php echo $clubArr[$i][1]; ?>
									</option>
									<?php
										}
										?>
								</select>
							</div>
							<div class="form-group mb-3">
								<label for="postid" class="form-label">Position</label>
								<select id="postid" name="postid" class="form-select">
									<option selected>---</option>
									<?php
										for($i = 0; $i < sizeof($positionArr); $i++)
										{
										?>
									<option value="<?php echo $positionArr[$i][0]; ?>">
										<?php echo $positionArr[$i][0]; ?> : <?php echo $positionArr[$i][1]; ?>
									</option>
									<?php
										}
										?>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" value="1" name="type">
							<button type="button" class="btn btn-success" id="btn-add">
								<i class="fa-solid fa-circle-plus"></i>
								Add
							</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
								<i class="fa-solid fa-xmark"></i>
								Close
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Edit Modal -->
		<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<form id="update_form">
						<div class="modal-header">
							<h3 class="modal-title">Edit Footballer</h3>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<input type="hidden" id="fbid_u" name="fbid_u" class="form-control" required>
							<div class="form-group mb-3">
								<label for="fbname_u" class="form-label">Name</label>
								<input type="text" id="fbname_u" name="fbname_u" class="form-control" required>
							</div>
							<div class="form-group mb-3">
								<label for="clubid_u" class="form-label">Club</label>
								<select id="clubid_u" name="clubid_u" class="form-select">
									<option selected>---</option>
									<?php
										for($i = 0; $i < sizeof($clubArr); $i++)
										{
										?>
									<option value="<?php echo $clubArr[$i][0]; ?>">
										<?php echo $clubArr[$i][0]; ?> : <?php echo $clubArr[$i][1]; ?>
									</option>
									<?php
										}
										?>
								</select>
							</div>
							<div class="form-group mb-3">
								<label for="postid_u" class="form-label">Position</label>
								<select id="postid_u" name="postid_u" class="form-select">
									<option selected>---</option>
									<?php
										for($i = 0; $i < sizeof($positionArr); $i++)
										{
										?>
									<option value="<?php echo $positionArr[$i][0]; ?>">
										<?php echo $positionArr[$i][0]; ?> : <?php echo $positionArr[$i][1]; ?>
									</option>
									<?php
										}
										?>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" value="2" name="type">
							<button type="button" class="btn btn-primary" id="update">
							<i class="fa-solid fa-pen-to-square"></i>
							Update
							</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
							<i class="fa-solid fa-xmark"></i>
							Close
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Delete Modal HTML -->
		<div id="deleteScreenModal" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<form>
						<div class="modal-header">
							<h3 class="modal-title">Delete Footballer</h3>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<input type="hidden" id="fbid_d" name="fbid_d" class="form-control">
							<p>Are you sure want to delete this footballer?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="delete">
								<i class="fa-solid fa-circle-minus"></i>
								Delete
							</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
								<i class="fa-solid fa-xmark"></i>
								Close
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>