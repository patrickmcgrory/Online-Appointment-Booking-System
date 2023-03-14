<html>
<head>
<link rel="stylesheet" href="main.css">
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
</head>
<?php include "dbconfig.php"; ?>
// <script>
/*function getTown(val) {
	$.ajax({
	type: "POST",
	url: "get_town.php",
	data:'countryid='+val,
	success: function(data){
		$("#town-list").html(data);
	}
	});
}
function getClinic(val) {
	$.ajax({
	type: "POST",
	url: "getclinic.php",
	data:'townid='+val,
	success: function(data){
		$("#clinic-list").html(data);
	}
	});
}
function getDoctorday(val) {
	$.ajax({
	type: "POST",
	url: "getdoctordaybooking.php",
	data:'cid='+val,
	success: function(data){
		$("#doctor-list").html(data);
	}
	});
}
*/
function getDay(val) {
	var cidval=document.getElementById("clinic-list").value;
	var didval=document.getElementById("doctor-list").value;
	$.ajax({
	type: "POST",
	url: "getDay.php",
	data:'date='+val+'&cidval='+cidval+'&didval='+didval,
	success: function(data){
		$("#datestatus").html(data);
	}
	});
}

</script>
<body style="background-image:url(images/bookback.jpg)">
	<div class="header">
		<ul>
			<li style="float:left;border-right:none"><a href="ulogin.php" class="logo"><img src="images/iti-logo.png" width="30px" height="30px"><strong> ITI </strong>Client Intake System</a></li>
			<li><a href="book.php">Book Now</a></li>
			<li><a href="ulogin.php">Home</a></li>
		</ul>
	</div>
	<form action="intake.php" method="post">
	<div class="sucontainer" style="background-image:url(images/bookback.jpg)">

	<!-- Handle Contact Type and Source -->
	<label for="contact_type">Contact Type:</label>
	<select name="contact_type" id="contact_type">
		<option value="please_select">Please select</option>
		<option value="call_answered">Call Answered</option>
		<option value="voicemail_email">Voicemail or email</option>
		<option value="website_formstack">Website or Formstack</option>
		<option value="other_email">Other Email</option>
	</select>

	<label for="contact_source">Contact Source:</label>
	<select name="contact_source" id="contact_source">
		<option value="please_select">Please select</option>
		<option value="website">Website</option>
		<option value="internet">Internet</option>
		<option value="insurance_referred">Insurance Referred</option>
		<option value="primary_physician">Primary Physician</option>
		<option value="previous_iti_client">Previous ITI Client</option>
		<option value="friend_referred">Friend Referred</option>
		<option value="marketing">Marketing</option>
		<option value="group_marketing">Group Marketing</option>
	</select>
	<br> <br>
	<!-- Handle Caller and Client Details	-->
		<label><b>Caller Name:</b></label><br>
		<input type="text" placeholder="Enter Full name of caller if different to client" name="caller_name" required><br>

		<label><b>Client First Name:</b></label><br>
		<input type="text" placeholder="Client First Name" name="client_first_name" required><br>

		<label><b>Client Last Name:</b></label><br>
		<input type="text" placeholder="Client Last Name" name="client_last_name" required><br>

		<label><b>Client Phone:</b></label><br>
		<input type="tel" placeholder="Client Phone" name="client_phone" required><br>

		<label><b>Client email:</b></label><br>
		<input type="email" placeholder="Client email" name="client_email" required><br>
		
		<label><b>Gender</b></label><br>
		<input type="radio" name="client_gender" value="female">Female
		<input type="radio" name="client_gender" value="male">Male
		<input type="radio" name="client_gender" value="other">Other<br><br>

		<label><b>Is Text OK?</b></label><br>
		<input type="radio" name="text_ok" value="yes">Yes
		<input type="radio" name="text_ok" value="no">No<br><br>
	<!--
		<label style="font-size:20px" >City:</label><br>
		<select name="city" id="city-list" class="demoInputBox"  onChange="getTown(this.value);" style="width:100%;height:35px;border-radius:9px">
		<option value="">Select City</option>
-->
		<?php
		$sql1="SELECT distinct(city) FROM clinic";
         $results=$conn->query($sql1); 
		while($rs=$results->fetch_assoc()) { 
		?>
		<option value="<?php echo $rs["city"]; ?>"><?php echo $rs["city"]; ?></option>
		<?php
		}
		?>
		</select>
        <br>
	<!--
		<label style="font-size:20px" >Town:</label><br>
		<select id="town-list" name="Town" onChange="getClinic(this.value);" style="width:100%;height:35px;border-radius:9px">
		<option value="">Select Town</option>
		</select><br>
		
		<label style="font-size:20px" >Clinic:</label><br>
		<select id="clinic-list" name="Clinic" onChange="getDoctorday(this.value);" style="width:100%;height:35px;border-radius:9px">
		<option value="">Select Clinic</option>
		</select><br>
		
		<label style="font-size:20px" >Doctor:</label><br>
		<select id="doctor-list" name="Doctor" onChange="getDate(this.value);" style="width:100%;height:35px;border-radius:9px">
		<option value="">Select Doctor</option>
		</select><br>
		
		
		<label><b>Date of Visit:</b></label><br>
		<input type="date" name="dov" onChange="getDay(this.value);" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d',strtotime('+7 day'));?>" required><br><br>
		<div id="datestatus"> </div>
	-->	
		<div class="container">
			<button type="submit" style="position:center" name="submit" value="Submit">Submit</button>
		</div>
<?php 
session_start();
if(isset($_POST['submit']))
{
		
		include 'dbconfig.php';
		$contact_type=$_POST['contact_type'];
		$contact_source=$_POST['contact_source'];
		$user=$_SESSION['username'];
		$caller_name=$_POST['caller_name'];
		$client_first_name=$_POST['client_first_name'];
		$client_last_name=$_POST['client_last_name'];
		$client_phone=$_POST['client_phone'];
		$client_email=$_POST['client_email'];
		$client_gender=$POST['client_gender'];

		$contact_status="Initiated";
		$timestamp=date('Y-m-d H:i:s');
		$sql = "INSERT INTO intake (user,caller_name,contact_type,contact_source, client_first_name,client_last_name,client_phone,client_email, contact_status, client_gender) VALUES ('$user','$caller_name','$contact_type', '$contact_source','$client_first_name','$client_last_name','$client_phone','$client_email','$contact_status', '$client_gender') ";
		echo $conn;
		echo $contact_type;
		echo $contact_source;
		echo$user;
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "wt_database";
		
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} 
	}
	?>
	
		/*
		if(!empty($_POST['caller_name'])&&!empty($_POST['contact_type'])&&!empty($_SESSION['username'])&&!empty($_POST['contact_source'])&&!empty($_POST['client_first_name']) && !empty($_POST['client_last_name']))
		{
			$checkday = strtotime($dov);
			$compareday = date("l", $checkday);
			$flag=0;
			require_once("dbconfig.php");
			$query ="SELECT * FROM doctor_availability WHERE DID = '" .$did. "' AND CID='".$cid."'";
			$results = $conn->query($query);
			while($rs=$results->fetch_assoc())
			{
				if($rs["day"]==$compareday)
				{
					$flag++;
					break;
				}
			}
			if($flag==0)
			{
				echo "<h2>Select another date as Doctor Unavailable on ".$compareday."</h2>";
			}
			else
			{
				if (mysqli_query($conn, $sql)) 
				{
						echo "<h2>Booking successful!! Redirecting to home page....</h2>";
						header( "Refresh:2; url=ulogin.php");

				} 
				else
				{
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
			}
		}
		else
		{
			echo "Enter data properly!!!!";
		}
		*/
	</form>
</body>
</html>