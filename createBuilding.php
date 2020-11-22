<?php
use Phppot\building;
if (! empty($_POST["create-btn"])) {
    require_once './Model/building.php';
    $building = new building();
    $response = $building->insertBuilding();
}
?>
<HTML>
<HEAD>
<TITLE>Create building</TITLE>
<link href="assets/css/phppot-style.css" type="text/css"
	rel="stylesheet" />
<link href="assets/css/user-registration.css" type="text/css"
	rel="stylesheet" />
<script src="vendor/jquery/jquery-3.3.1.js" type="text/javascript"></script>
</HEAD>
<BODY>
	<div class="phppot-container">
		<div class="sign-up-container">
			<div class="">
                            <form name="sign-up" action="Model/building.php" method="insertBuilding()"
					onsubmit="return signupValidation()">
					<div class="signup-heading">Registration</div>
				<?php
    if (! empty($response["status"])) {
        ?>
                    <?php
        if ($response["status"] == "error") {
            ?>
				    <div class="server-response error-msg"><?php echo $response["message"]; ?></div>
                    <?php
        } else if ($response["status"] == "success") {
            ?>
                    <div class="server-response success-msg"><?php echo $response["message"]; ?></div>
                    <?php
        }
        ?>
				<?php
    }
    ?>                   
                    <div class="row">
                            <div class="inline-block">
                                    <div class="form-label">
                                            <span id="buildingName">BuildingName</span>
                                    </div>
                                    <input type="text" name="buildingName" id="buildingName">
                            </div>
                    </div>
                    <div class="row">
                            <input class="btn" type="submit" name="create-btn"
                                    id="create-btn" value="Sign up">
                    </div>
				</form>
			</div>
		</div>
        </DIV>
    
    <script>
function signupValidation() {
	var valid = true;

	$("#buildingName").removeClass("error-field");

	var BuildingName = $("#buildingName").val();

	$("#buildingName-info").html("").hide();

	if (BuildingName.trim() == "") {
		$("#buildingName-info").html("required.").css("color", "#ee0000").show();
		$("#buildingName").addClass("error-field");
		valid = false;
	}
	if (valid == false) {
		$('.error-field').first().focus();
		valid = false;
	}
	return valid;
}
</script>
</BODY>
</HTML>
