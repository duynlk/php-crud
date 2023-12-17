// submit add
$(document).on('click', '#btn-add',function(e) {
	var data = $("#add_form").serialize();
	$.ajax({
		data: data,
		type: "post",
		url: "backend/save.php",
		dataType: "json",
		success: function(dataResult){
			if(dataResult.statusCode==200){
				alert('Data added successfully !');
				location.reload();
			}else if(dataResult.statusCode==201){
				alert(dataResult);
			}
		}
	});
});

// show dialog update
$(document).on('click','.update',function(e) {
	var fbid = $(this).find('i').data("fbid");
	var fbname = $(this).find('i').data("fbname");
	var clubid = $(this).find('i').data("clubid");
	var postid = $(this).find('i').data("postid");

	$('#fbid_u').val(fbid);
	$('#fbname_u').val(fbname);
	$('#clubid_u').val(clubid);
	$('#postid_u').val(postid);
});

// submit update
$(document).on('click','#update',function(e) {
	var data = $("#update_form").serialize();
	$.ajax({
		data: data,
		type: "post",
		url: "backend/save.php",
		dataType: "json",
		success: function(dataResult){
			if(dataResult.statusCode==200){
				alert('Data updated successfully!');
				location.reload();
			}
		}
	});
});

// show dialog delete one
$(document).on("click", ".delete", function() {
	var id = $(this).attr("data-fbid");
	$('#fbid_d').val(id);
});

// submit delete one
$(document).on("click", "#delete", function() {
	$.ajax({
		url: "backend/save.php",
		type: "POST",
		cache: false,
		dataType: "json",
		data:{
			type : 3,
			fbid : $("#fbid_d").val()
		},
		success: function(dataResult){
			$("#" + dataResult.id).remove();
			alert('Data deleted successfully!');
			location.reload();
		}
	});
});

// submit delete bulk
$(document).on("click", "#delete_multiple", function() {
	var chks = [];
	$(".fbid_checkbox:checked").each(function() {
		chks.push($(this).data('fbid'));
	});
	if(chks.length <=0) {
		alert("Please select records."); 
	} 
	else { 
		WRN_PROFILE_DELETE = "Are you sure you want to delete "+(chks.length>1?"these":"this")+" row?";
		var checked = confirm(WRN_PROFILE_DELETE);
		if(checked == true) {
			var selected_values = chks.join(",");
			$.ajax({
				type: "POST",
				url: "backend/save.php",
				data:{
					type: 4,
					fbid : selected_values
				},
				success: function(response) {
					var ids = response.split(",");
					for (var i=0; i < ids.length; i++ ) {
						$("#"+ids[i]).remove(); 
					}
					alert('Data deleted successfully!');
				}
			});
		}
	}
});

// filter
$(document).on("click", "#filter", function() {
	var filterName = $("#filter-name").val();
	var filterClub = $("#filter-club").val();
	var filterPosition = $("#filter-position").val();
	$.ajax({
		type: "POST",
		url: "backend/save.php",
		data:{
			type: 5,
			fName : filterName,
			fClub : filterClub,
			fPosition : filterPosition
		},
		success: function(response) {
			location.reload();
		}
	});
});

// reset
$(document).on("click", "#reset", function() {
	$.ajax({
		type: "POST",
		url: "backend/save.php",
		data:{
			type: 6
		},
		success: function(response) {
			location.reload();
		}
	});
});

$(document).ready(function(){
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;
			});
		} else{
			checkbox.each(function(){
				this.checked = false;
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
	if($("#filter-club-hid").val() != ""){
		$('#filter-club').val($("#filter-club-hid").val());
	}
	if($("#filter-position-hid").val() != ""){
		$('#filter-position').val($("#filter-position-hid").val());
	}
});