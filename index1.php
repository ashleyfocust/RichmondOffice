<!DOCTYPE html>

<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Richmond Nursing</title>
		<meta name="description" content="" />
		<meta name="author" content="A Crompton" />
		<link rel="stylesheet" href="assets/css/richmond.css" type="text/css" />
<link rel="stylesheet" href="assets/css/setcolour.css" type="text/css"/>



<noscript>
  This page needs JavaScript activated to work. 
  <style>div { display:none; }</style>
</noscript>


		<script src= "/var/www/html/jquery/jquery-1.10.1.min.js"></script>
		
		<script src= "/var/www/html/jquery/dist/js/jquery.tablesorter.js"></script>
		<script src= "/var/www/html/jquery/dist/js/jquery.tablesorter.widgets.js"></script>		
		<link rel="stylesheet" href="/var/www/html/jquery/dist/css/theme.blue.min.css">		
		
		<link rel="stylesheet" href="/var/www/html/jquery/development-bundle/themes/base/jquery.ui.all.css">
		<link rel="shortcut icon" href="assets/icons/rn2.gif" />
		<link rel="apple-touch-icon" href="assets/icons/rn2.gif" />
		<script src="/var/www/html/jquery/development-bundle/ui/jquery.ui.core.js"></script>
		<?php
			

			  
			session_start();
			
		//	header("location:http://81.130.162.215/RichmondLive/index1.php");
			
			
			require("config.php");
			include ("functions.php");
			include ("pdo_functions.php");
		?>
		

	
<script>



function clearFilters(){
	
	$('.filtertable').trigger('filterReset');
}


	$(function() {
		$("#iUser").focus();
	});

$(document).ready(function()
	{

	$('.filtertable')
	    .bind('filterInit', function() {
	        // check that storage ulility is loaded
	        if ($.tablesorter.storage) {
	            // get saved filters
	            var f = $.tablesorter.storage(this, 'tablesorter-filters') || [];
	            $(this).trigger('search', [f]);
	        }
	    })
	    .bind('filterEnd', function(){
	        if ($.tablesorter.storage) {
	            // save current filters
	            var f = $(this).find('.tablesorter-filter').map(function(){
	                return $(this).val() || '';
	            }).get();
	            $.tablesorter.storage(this, 'tablesorter-filters', f);
	        }
	    });	
			
		
	$(".delbox").click(function()
		{
		//alert (this.id);
		theBits = this.id.split("-");
		$('#del-'+theBits[2]).val('1');
 	 	$("#delnotes").submit();
  		});
	
	$(".filtertable").tablesorter({
					widthFixed: false,
					theme:'blue',
					widgets: ['saveSort','filter','stickyHeaders'],
					        	headers: {
        		0: {filter: false, sorter:false},

        		5: {filter: false, sorter:false}
        		},
        		saveSort:true
				});	
	
	
	});


function validateForm()
	{
	var x= $("#newpwd").val();
	if (x==null || x=="")
	  {
	  alert("You must enter a password");
	  return false;
	  }
	
	var y=$("#confirmpwd").val();
	if (x!==y)
	  {
	  alert("Passwords must match");
	  return false;
	  }
	 if (validatePwd(x) ==false)
	 	{
	 	alert ('Password must be at least 8 characters long, contain a mix of upper and lower case letters and at least one number');
	 	return false;
	 	}
	  
	return true;	
	}
	
	
function clearAction(el) 
	{
			var theBits = el.id.split("_");
			console.log(theBits[1]);
			data = "id=" + theBits[1] +"&type=normal";
			
		$.post("deletekeyaction.php", data, function(response,status){
			$('#keyactions').html(response);
			
			$(".filtertable").tablesorter({
					widthFixed: false,
					theme:'blue',
					widgets: ['saveSort','filter','stickyHeaders'],
					        	headers: {
        		0: {filter: false, sorter:false},

        		5: {filter: false, sorter:false}
        		},
        		saveSort:true
				});	
				$('.filtertable')
    .bind('filterInit', function() {
        // check that storage ulility is loaded
        if ($.tablesorter.storage) {
            // get saved filters
            var f = $.tablesorter.storage(this, 'tablesorter-filters') || [];
            $(this).trigger('search', [f]);
        }
    })
    .bind('filterEnd', function(){
        if ($.tablesorter.storage) {
            // save current filters
            var f = $(this).find('.tablesorter-filter').map(function(){
                return $(this).val() || '';
            }).get();
            $.tablesorter.storage(this, 'tablesorter-filters', f);
        }
    });
		
	
	});

}


function clearAction2(el) {
	var theBits = el.id.split("_");
	data = "id=" + theBits[1] +"&type=bookings";
	$.post("deletekeyaction.php", data, function(response,status){
		$('#onlinebookings').html(response);
		});
	}



function validatePwd(pwd) 
	{
    var re = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;
    return re.test(pwd);
	}
	
</script>
<style type="text/css">
.tablesorter thead .disabled {display: none}
</style>

	</head>
	<body>
	<?php
	
	
	function clearAllLocks()
	{
	global $DBH;	
	$sql = "delete FROM tblRecordLocks ;";
	$stmt=$DBH->prepare($sql);
	$stmt->execute();
	}
	
	
	function clearlocks()
	{
	require ("config.php");
	if (isset($_SESSION['username'])){
		
		$sql = "delete FROM tblRecordLocks where userid = '".$_SESSION['username']."';";
		$stmt=$DBH->prepare($sql);
		$stmt->execute();
		}
	}
		
	include "menu.html";
	?>	
	<div id = "main3" >
			
	<?php
	clearlocks();
	debug();
	
		foreach ($_POST as $key => $value) 
			{
			if (strpos($key,'del')===0 && $value =='1')
				{
				$bits = explode('-', $key)	;
				$noteid = $_POST['id-'.$bits[1]];
					
				$sql = "INSERT INTO `tblReadNotes` (`NoteId`, `User`, `Read`) VALUES (:id, :user, '1');";
				$stmt=$DBH->prepare($sql);
				$stmt->bindParam(":id",$noteid);
				$stmt->bindParam(":user",$_SESSION['username']);
				$stmt->execute();	
				}
			}
			
			
			
			
	if($_GET['flag']=="x")
		{
		echo "You have been directed to this page as you have not logged in";	
		}	

	if (isset($_POST)){
	
	if ($_POST['logout'])
		{
		session_destroy();
		echo "You have just logged out<br>";
		}
		
	if ($_POST['clearAllLocks'])
		{
		clearAllLocks();
		echo "Locks Cleared!<br>";
		}	
		

		
							

	
	if($_POST['login'] && (!isset($_SESSION['loggedin']) 	))
		{
			
		$username = $_POST['iUser'];
		$pwd=$_POST['iPwd'];
		$sql= "select `AccountStatus`, `Salt` , AccessAttempt, UserType, Password from tblUsers where `UserName` = :user  ;";
		$stmt = $DBH->prepare($sql);
		$stmt->bindParam(":user",$username);	
		$stmt->execute();
		$row = $stmt->fetch();
			//echo "<BR>>>>".$row['Password']."<BR>";
		if ($row['UserType']=='Nurse')
			{
			echo "This page is for Richmond Nursing staff only. Please log in using this link ";
			echo "<a href = 'login.php'>Log in</a>";
			return;
			}	
		
		
		if ($row['AccountStatus']=='Deactivated')
			{
			echo "You're account has been deactivated. Please contact the Richmond Office Manager";
			return;
			}
		else 
			{
				
			/*
			 * Encrypt the password using the same algorithm as was used to encrypt it for storage
			 * to allow checking against the stored value. 
			 */	
				
		    $check_password = hash('sha256', $pwd . $row['Salt']); 
			for($round = 0; $round < 65536; $round++) 
	    		{ 
	    		$check_password = hash('sha256', $check_password . $row['Salt']); 
	    		} 
			$pwd=$check_password;

			$sql= "select `UserName`, `Password`, AccessAttempt, UserType from tblUsers where `UserName` = :user and `Password` = :pwd ;";
			$stmt = $DBH->prepare($sql);
			$stmt->bindParam(":user",$username);	
			$stmt->bindParam(":pwd",$pwd);
			$stmt->execute();

			/************************************************************************** 
			 * 
			 *  CHECK IF ANY ROWS EXIST IN TBL USER THAT MATCH USERNAME AND PASSWORD
			 * 
			 ***************************************************************************/
	
	
			if (($stmt->rowCount()) >0) // i.e. if we have found a matching row...
				{
				$_SESSION['usertype']=$row['UserType'];
				/* 
				 * TEST IF PASSWORD HAS BEEN RESET BY ADMIN AND CONSTRUCT FORM FOR NEW PWD IF TRUE
				 */
						
				if ($row['AccountStatus']=='Reset by Admin')
					{
					echo "You need to enter a new password, which must be at least 8 characters long, contain at least
					one upper case letter, one lower case letter and one number.";
				
					echo "<form onsubmit = 'return validateForm()' action='resetpwd_user.php' method='POST' >";
					echo "<input type = 'hidden' name = 'userid' value = '$username'>";
	
					?>

					<table >
						<tr>
							<td>
								New Password: 
							</td>
							<td>
								<input type="password" size = '10' name="newpwd" id="newpwd">
							</td>
						</tr>
						<tr>
							<td>
							</td> 
							<td>
							</td>
						</tr>
						<tr>
							<td>
								ConfirmPassword:
							</td> 
							<td>
								<input type="password" size = '10' name="confirmpwd" id="confirmpwd">
							</td>
						</tr>
					 <tr>
					 	<td colspan="2">
					 		<input type="submit" name="login" value="Save"> 
				 		</td>
			 		</tr>	
					</table>
					</form>
							
													
					<?php 	
					return;
					}		
						
				$_SESSION['loggedin']=TRUE;
				$_SESSION['username']=$_POST['iUser'];
				$_SESSION['usertype']=$row['UserType'];
								
				
				} //end of if row found for user/password 
			else 
				{
						
				if ($row['AccessAttempt'] <5)	
					{
					$sql = "update tblUsers set   AccessAttempt=AccessAttempt+1 where Username   = :un;";	
					$stmt2 = $DBH->prepare($sql);
			        $query_params = array(':un' =>$username); 
					$stmt2->execute($query_params);			
					echo "You have entered an unknown User id and password combination. Please try again <BR>";
					}
				else 
					{
					$sql = "update tblUsers set   AccessAttempt=0, AccountStatus = 'Deactivated' where Username   = :un;";	
					$stmt2 = $DBH->prepare($sql);
			        $query_params = array(':un' =>$username); 
					$stmt2->execute($query_params);			
						
					echo "Account deactivated as you've exceeded the allowed number of password attempts";
					return;
					}	
				}
 			} // end of if account not deactivated
		} // end of if form posted 
	}
	if ($_SESSION['loggedin'] && empty($_POST['logout']))	
		{
		$sql = "update tblUsers set  LastAccessed = now(), AccessAttempt=0 where Username   = :un;";	
		$stmt2 = $DBH->prepare($sql);
        $query_params = array(':un' => $_SESSION['username']); 
		$stmt2->execute($query_params);			
		echo "You are logged in as ".$_SESSION['username']." <BR><BR>";
		?>
		
		
		<form style = 'display: inline' action="index1.php" method="POST" >
			<input type="submit" name="logout" value="Log Out">
		</form>	
		<form style = 'display: inline' action = "CreateNote.php">
			<input type="submit" value="Create a Note">
		</form>
		<form style = 'display: inline' action = "pageloader.php" method = 'post'>
		    <input type="hidden" name = 'page' value="dashboard.php">
		    <input type="hidden" name = 'title' value="Dashboard">
		    <input type="submit" value="Dashboard">
		</form>		
		<form style = 'display: inline'  method = 'post'  action = "index1.php">
		    <input type="submit"  name ='clearAllLocks' value="Clear All Locks">
		</form>			
					 		
 		<?php
 		//var_dump($_SESSION);
 		if ($_SESSION['usertype'] == 'GroupAdmin' )// || $_SESSION['username'] == 'Tony' || $_SESSION['username'] == 'AdrianH' || $_SESSION['username'] == 'Debug')
			{
		?>
		<form style = 'display: inline' action = "useradmin.php">
			<input type="submit" value="User Admin">
		</form>

		<form style = 'display: inline' action = "whosreadwhat.php">
		    <input type="submit" value="Who's read what">
		</form>	
		<form style = 'display: inline' action = "checkbug2.php">
		    <input type="submit" value="Check Bugs">
		</form>	
		<form style = 'display: inline'  method = 'post'  action = "index1.php">
		    <input type="submit"  name ='clearAllLocks' value="Clear All Locks">
		</form>			
								
	<?php
		}				 		
	?>
							
							
	<?php
	if ($_SESSION['username'] == 'Ashley' || $_SESSION['username'] == 'Andy')// || $_SESSION['username'] == 'AdrianH' || $_SESSION['username'] == 'Debug')
		{
	?>
	<form style = 'display: inline' action = "getdistance_batchrun.php">
		<input type="submit" value="Distance - BatchRun">
	</form>

	<form style = 'display: inline' action = "go.php">
	    <input type="submit" value="SysAdmin Utils">
	</form>		
								
								
																
								
	<?php
		}				 		
	?>				
							

	<?php
	echo "<BR><BR>";
	include('dashboard_new.php'); 
		echo "		<BR>	";		
		//getUnreadNotes();
	
		//echo "		<BR>	";		
		//getTodaysNote();
		
		//echo "<a href= 'whosworkingtoday.php'>Nurses Availability (Who's working today)</a>";	
		}
	else 
		{	
		?>
				
		<form action="index1.php" method="POST" >
	
			<table >
				<tr>
					<td>
						User Name: 
					</td>
					<td>
						<input type="text" size = '10' name="iUser" id = 'iUser'>
					</td>
				</tr>
				<tr>
					<td>
					</td> 
					<td>
					</td>
				</tr>
				<tr>
					<td>
						Password:
					</td> 
					<td>
						<input type="password" size = '10' name="iPwd">
					</td>
				</tr>
			 <tr>
			 	<td colspan="2">
			 		<input type="submit" name="login" value="Log In"> 
			 		<input type="submit" name="logout" value="Log Out">
			 		<!--<a href="login.php">Log in as Nurse</a>-->
		 		</td>
	 		</tr>	
			</table>

		</form>	
	<?php 
		} 
		?>



	</div>
	</body>
</html>
