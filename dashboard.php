<!DOCTYPE html>
<html>
<head lang="en">
<?php
include 'php/security.php';
session_start();
$allowed = allowed();
if ($allowed == true){
} else {
	header("Location: login.html");
}
?>
    <script src="javascript/jquery.js"></script>
    <script src="javascript/bootstrap/bootstrap.js"></script>
    <script src="javascript/dashboard.js"></script>
    <script src="javascript/sweetalert.min.js"></script>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/bootstrap/bootstrap.css" />
    <link rel="stylesheet" href="css/bootstrap/bootstrap-theme.css" />	
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script>
        $(document).ready(function() {
            $("#editAgentDiv, #newPropertyDiv, #editPropertyDiv, #generateURLDiv").css("display", "none");

            // Loads the options for the edit agent select
            loadAgentList("#editAgentSelect");
            loadAgentList("#propertyAgentSelect");
            loadPropertyList();

            $("#newAgentBtn").click(function() {
                $("#editAgentPill, #newPropertyPill, #editPropertyPill, #generateURLPill").removeClass('active');
                $("#newAgentPill").addClass('active');

                $("#newAgentDiv").css("display", "block");
                $("#editAgentDiv, #newPropertyDiv, #editPropertyDiv, #generateURLDiv").css("display", "none");
            });

            $("#submitNewAgentBtn").click(function() {
                submitNewAgent();
            });

            $("#clearAgentFieldsBtn").click(function() {
                $("#editAgentName, #editAgentPosition, #editAgentContact, #editAgentWebsite").val("");
            });

            $("#editAgentBtn").click(function() {
                // Loads the options for the edit agent select
                loadAgentList("#editAgentSelect");
                loadAgentList("#propertyAgentSelect");

                $("#editAgentSelect").val("default");

                $("#newAgentPill, #newPropertyPill, #editPropertyPill, #generateURLPill").removeClass('active');
                $("#editAgentPill").addClass('active');

                $("#editAgentDiv").css("display", "block");
                $("#newAgentDiv, #newPropertyDiv, #editPropertyDiv, #generateURLDiv").css("display", "none");

                $("#editAgentName, #editAgentPosition, #editAgentContact, #editAgentWebsite, #submitEditAgentBtn, #cancelAgentChangesBtn, #editCompanyLogo, #editAgentPhoto").prop("disabled", true);
            });

            $("#submitEditAgentBtn").click(function() {
                editAgent();
            });

            $("#cancelAgentChangesBtn").click(function() {
                $("#editAgentSelect").val("default");

                $("#editAgentName, #editAgentPosition, #editAgentContact, #editAgentWebsite").val("");

                $("#editAgentName, #editAgentPosition, #editAgentContact, #editAgentWebsite, #submitEditAgentBtn, #cancelAgentChangesBtn, #editCompanyLogo, #editAgentPhoto").prop("disabled", true);
            });

            $("#editAgentSelect").change(function() {
                // Sets the input fields according to what is selected
                setEditAgentFields();
            });

            $("#newPropertyBtn").click(function() {
                $("#newAgentPill, #editAgentPill, #editPropertyPill, #generateURLPill").removeClass('active');
                $("#newPropertyPill").addClass('active');

                $("#newPropertyDiv").css("display", "block");
                $("#editAgentDiv, #newAgentDiv, #editPropertyDiv, #generateURLDiv").css("display", "none");
            });

            $("#submitNewPropertyBtn").click(function() {
                submitNewProperty();
            });

            $("#clearPropertyFieldsBtn").click(function() {
                $("#propertyAddress, #matterPortLink, #realestateLink, #googlemapsLink").val("");
            });

            $("#editPropertyBtn").click(function() {
                loadPropertyList("#editPropertySelect");

                $("#editPropertySelect").val("default");

                $("#newAgentPill, #editAgentPill, #newPropertyPill, #generateURLPill").removeClass('active');
                $("#editPropertyPill").addClass('active');

                $("#editPropertyDiv").css("display", "block");
                $("#editAgentDiv, #newAgentDiv, #newPropertyDiv, #generateURLDiv").css("display", "none");

                $("#editPropertyAddress, #editMatterPortLink, #editRealestateLink, #editGooglemapsLink, #editPropertyAgentSelect, #submitEditPropertyBtn, #cancelPropertyChangesBtn").prop("disabled", true);
            });
			
			$("#generateURLBtn").click(function() {
			    $("#editAgentPill, #newPropertyPill, #newAgentPill,#editPropertyPill, #generateURLPill").removeClass('active');
                loadPropertyList("#generateURLSelect");
                $("#generateURLPill").addClass('active');

                $("#generateURLDiv").css("display", "block");
                $("#editAgentDiv, #newAgentDiv, #newPropertyDiv, #editPropertyDiv").css("display", "none");
            });

            $("#editPropertySelect").change(function() {
                // Sets the input fields according to what is selected
                setEditPropertyFields();
            });
			
			$("#generateURLSelect").change(function() {
                // Sets the input fields according to what is selected
                generateURL();
            });

            $("#submitEditPropertyBtn").click(function() {
                editProperty();
            });

            $("#cancelPropertyChangesBtn").click(function() {
                $("#editPropertySelect").val("default");

                $("#editPropertyAddress, #editMatterPortLink, #editRealestateLink, #editGooglemapsLink").val("");

                $("#editPropertyAddress, #editMatterPortLink, #editRealestateLink, #editGooglemapsLink, #editPropertyAgentSelect, #submitEditPropertyBtn, #cancelPropertyChangesBtn").prop("disabled", true);
            });

            $("#uniqueURLContainer")
                    .on("focus",function(e){
                        $(this).select();
                    })
                    .on("mouseup",function(e){
                        return false;
                    }
            );

            $("#agentPhoto, #editAgentPhoto").change(function(){
                if ((this).files.length == 1) {
                    readAgentPhoto( this );
                } else {
                    setAgentPhotoFalse();
                }
            });

            $("#companyLogo, #editCompanyLogo").change(function(){
                if ((this).files.length == 1) {
                    readCompanyLogo( this );
                } else {
                    setCompanyLogoFalse();
                }
            });

            $("#logoutBtn").click(function() {
                window.location.href = "/php/logout.php";
                return false;
            });

        });
    </script>
</head>
<body>

<div class="row" id="heading">
    <div class="col-md-9 col-md-offset-3 col-xs-11 col-xs-offset-1">
        <h3>Agent and Property Dashboard</h3>
    </div>
</div>

<div class="row">

<div id="navColumn" class="col-md-2 col-md-offset-3 col-xs-3 col-xs-offset-1">

    <ul class="nav nav-pills nav-stacked">
        <li class="active" id="newAgentPill" role="presentation">
            <a href="#" id="newAgentBtn">New Agent</a>
        </li>
        <li id="editAgentPill" role="presentation">
            <a href="#" id="editAgentBtn">Edit Agent</a>
        </li>
    </ul>

    <hr />

    <ul class="nav nav-pills nav-stacked">

        <li id="newPropertyPill" role="presentation">
            <a href="#" id="newPropertyBtn">New Property</a>
        </li>
        <li id="editPropertyPill" role="presentation">
            <a href="#" id="editPropertyBtn">Edit Property</a>
        </li>
    </ul>
	
	<hr />
	
	<ul class="nav nav-pills nav-stacked">

        <li id="generateURLPill" role="presentation">
            <a href="#" id="generateURLBtn">Generate Customer URL</a>
        </li>
    </ul>

    <hr />

    <button class="btn btn-default btn-md btn-block" id="logoutBtn" onclick="void(0)">Logout</button>

</div>

<div class="col-md-4 col-xs-7">
    <div class="col-xs-12" id="newAgentDiv">

        <div class="row">
            <form>
                <div class="form-group">
                    <label for="agentName">Name</label>
                    <input class="form-control" id="agentName" type="text" name="agentName" />

                    <label for="agentPosition">Position</label>
                    <input class="form-control" id="agentPosition" type="text" name="agentPosition" />
                </div>
                <div class="form-group">
                    <label for="agentContact">Contact (Email)</label>
                    <input class="form-control" id="agentContact" type="text" name="agentContact" />

                    <label for="agentWebsite">Website</label>
                    <input class="form-control" id="agentWebsite" type="text" name="agentWebsite" />
                </div>
                <div class="form-group">
                    <label for="companyLogo">Company Logo</label>
                    <input type="file" id="companyLogo"/>
                </div>
                <div class="form-group">
                    <label for="agentPhoto">Agent Photo</label>
                    <input type="file" id="agentPhoto" />
                </div>
            </form>
        </div>

        <div class="row submitBtns">
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="submitNewAgentBtn" onclick="void(0)">Submit</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="clearAgentFieldsBtn" onclick="void(0)">Clear Fields</button>
            </div>
        </div>

    </div>

    <div class="col-xs-12" id="editAgentDiv">

        <div class="row">
            <select class="form-control" id="editAgentSelect">
                <option value="default" disabled selected>Select agent</option>
            </select>
            <hr />
        </div>

        <div class="row">
            <form>
                <div class="form-group">
                    <label for="editAgentName">Name</label>
                    <input class="form-control" id="editAgentName" type="text" name="editAgentName" disabled/>

                    <label for="editAgentPosition">Position</label>
                    <input class="form-control" id="editAgentPosition" type="text" name="editAgentPosition" disabled/>
                </div>
                <div class="form-group">
                    <label for="editAgentContact">Contact (Email)</label>
                    <input class="form-control" id="editAgentContact" type="text" name="editAgentContact" disabled/>

                    <label for="editAgentWebsite">Website</label>
                    <input class="form-control" id="editAgentWebsite" type="text" name="editAgentWebsite" disabled/>
                </div>
                <div class="form-group">
                    <label for="editCompanyLogo">Company Logo</label>
                    <input type="file" id="editCompanyLogo" />
                </div>
                <div class="form-group">
                    <label for="editAgentPhoto">Agent Photo</label>
                    <input type="file" id="editAgentPhoto" />
                </div>
            </form>
        </div>

        <div class="row submitBtns">
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="submitEditAgentBtn" onclick="void(0)" disabled>Modify</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="cancelAgentChangesBtn" onclick="void(0)" disabled>Cancel</button>
            </div>
        </div>

    </div>

    <div class="col-xs-12" id="newPropertyDiv">

        <div class="row">
            <form>
                <div class="form-group">
                    <label for="propertyAddress">Address</label>
                    <input class="form-control" id="propertyAddress" type="text" name="propertyAddress" />
                </div>
                <div class="form-group">
                    <label for="matterPortLink">Matterport URL</label>
                    <input class="form-control" id="matterPortLink" type="text" name="matterPortLink" />

                    <label for="realestateLink">RealEstate.com.au URL</label>
                    <input class="form-control" id="realestateLink" type="text" name="realestateLink" />

                    <label for="googlemapsLink">Google Maps URL</label>
                    <input class="form-control" id="googlemapsLink" type="text" name="googlemapsLink" />
                </div>
                <div class="form-group">
                    <label for="editPropertyAgentSelect">Property agent</label>
                    <select class="form-control" id="propertyAgentSelect">
                        <option value="default" disabled selected>Select agent</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="row submitBtns">
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="submitNewPropertyBtn" onclick="void(0)">Submit</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="clearPropertyFieldsBtn" onclick="void(0)">Clear Fields</button>
            </div>
        </div>

    </div>

    <div class="col-xs-12" id="editPropertyDiv">

        <div class="row">
            <select class="form-control" id="editPropertySelect">
                <option value="default" disabled selected>Select property</option>
            </select>
            <hr />
        </div>

        <div class="row">
            <form>
                <div class="form-group">
                    <label for="editPropertyAddress">Address</label>
                    <input class="form-control" id="editPropertyAddress" type="text" name="editPropertyAddress" />
                </div>
                <div class="form-group">
                    <label for="editMatterPortLink">Matterport URL</label>
                    <input class="form-control" id="editMatterPortLink" type="text" name="editMatterPortLink" />

                    <label for="editRealestateLink">RealEstate.com.au URL</label>
                    <input class="form-control" id="editRealestateLink" type="text" name="editRealestateLink" />

                    <label for="editGooglemapsLink">Google Maps URL</label>
                    <input class="form-control" id="editGooglemapsLink" type="text" name="editGooglemapsLink" />
                </div>
                <div class="form-group">
                    <label for="editPropertyAgentSelect">Property agent</label>
                    <select class="form-control" id="editPropertyAgentSelect" >
                        <option value="default" disabled selected>Select agent</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="row submitBtns">
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="submitEditPropertyBtn" onclick="void(0)">Modify</button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-default btn-md btn-block" id="cancelPropertyChangesBtn" onclick="void(0)">Cancel</button>
            </div>
        </div>

    </div>
	
	<div class="col-xs-12" id="generateURLDiv">

        <div class="row">
            <select class="form-control" id="generateURLSelect">
                <option value="default" disabled selected>Select property</option>
            </select>
            <hr />
        </div>

        <div class="row">
            <form>
                <div class="form-group">
                    <label for="uniqueURLContainer">Unique Property URL</label>
                    <input class="form-control" id="uniqueURLContainer" type="text" name="uniqueURLContainer" />
                </div>
            </form>
        </div>

    </div>
</div>

</div>

</body>
</html>