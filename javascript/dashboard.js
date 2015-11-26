var companyLogo;
var agentPhoto;

/**
 * Submits the new agent to the database
 */
var submitNewAgent = function () {

    var name = $("#agentName").val().trim();
    var position = $("#agentPosition").val().trim();
    var contact = $("#agentContact").val().trim();
    var website = $("#agentWebsite").val().trim();

    if (name.length == 0 || position.length == 0 || contact.length == 0 || website.length == 0) {

        swal("Warning", "Something is missing..", "warning");

    } else {

        $.ajax({
            url: "../php/submitNewAgent.php",
            type: "POST",
            data: {
                name: name,
                position: position,
                contact: contact,
                website: website,
                agent_photo: agentPhoto,
                company_logo: companyLogo
            },
            success: function (success) {
				console.log(success);
                if (parseInt(success)) {
					

                    loadAgentList("#editAgentSelect");
                    loadAgentList("#propertyAgentSelect");

                    swal("Success", "Successfully added agent", "success");

                } else {
                    swal("Error", "Failed to add agent", "error");
                }
            },
            error: function () {
                swal("Error", "Error submitting new agent", "error");
            }
        });

    }

};

/**
 * Submits the new property to the database
 */
var submitNewProperty = function () {

    var address = $("#propertyAddress").val().trim();
    var matterport_link = $("#matterPortLink").val().trim();
    var realestate_link = $("#realestateLink").val().trim();
    var googlemaps_link = $("#googlemapsLink").val().trim();

    if (address.length == 0 || matterport_link.length == 0 || realestate_link.length == 0 || googlemaps_link.length == 0) {

        swal("Warning", "Something is missing..", "warning");

    } else {

        $.ajax({
            url: "../php/submitNewProperty.php",
            type: "POST",
            data: {
                address: address,
                matterport_link: matterport_link,
                realestate_link: realestate_link,
                googlemaps_link: googlemaps_link,
                agent_id: $("#propertyAgentSelect").val()
            },
            success: function (success) {
                if (parseInt(success)) {

                    loadPropertyList();

                    swal("Success", "Successfully added property", "success");

                } else {
                    swal("Error", "Failed to add property", "error");
                }
            },
            error: function () {
                swal("Error", "Failed to add property", "error");
            }
        });

    }
};

/**
 * Sets the input fields for agent modification
 */
var setEditAgentFields = function () {

    $.ajax({
        url: "../php/setEditAgentFields.php",
        type: "POST",
        dataType: "json",
        data: {
            selectedAgent: $("#editAgentSelect").val()
        },
        success: function (data) {
            $("#editAgentName").val(data.name);
            $("#editAgentPosition").val(data.position);
            $("#editAgentContact").val(data.contact);
            $("#editAgentWebsite").val(data.website);

            $("#editAgentName, #editAgentPosition, #editAgentContact, #editAgentWebsite, #submitEditAgentBtn, #cancelAgentChangesBtn, #editCompanyLogo, #editAgentPhoto").prop("disabled", false);
        },
        error: function () {
            swal("Error", "Error at setting the agent fields for edit", "error");
        }
    });

};

var setEditPropertyFields = function () {
    $.ajax({
        url: "../php/setEditPropertyFields.php",
        type: "POST",
		dataType: "json",
        data: {
            selectedProperty: $("#editPropertySelect").val()
        },
        success: function (data) {
            $("#editPropertyAddress").val(data.address);
            $("#editMatterPortLink").val(data.matterport_link);
            $("#editRealestateLink").val(data.realestate_link);
            $("#editGooglemapsLink").val(data.googlemaps_link);

			loadAgentList("#editPropertyAgentSelect");

            //Wait 200ms for the option list to populate before selecting the agent
			setTimeout(function(){
			  $("#editPropertyAgentSelect").val(data.agent_id);
			}, 200);
			
           
            $("#editPropertyAddress, #editMatterPortLink, #editRealestateLink, #editGooglemapsLink, #editPropertyAgentSelect, #submitEditPropertyBtn, #cancelPropertyChangesBtn").prop("disabled", false);
        },
        error: function () {
            swal("Error", "Error at setting the property fields for edit", "error");
        }
    });

};

/**
 * Submits the modified agent
 */
var editAgent = function () {

    var name = $("#editAgentName").val().trim();
    var position = $("#editAgentPosition").val().trim();
    var contact = $("#editAgentContact").val().trim();
    var website = $("#editAgentWebsite").val().trim();

    if (name.length == 0 || position.length == 0 || contact.length == 0 || website.length == 0) {

        swal("Warning", "Something is missing..", "warning");

    } else {

        $.ajax({
            url: "../php/editAgent.php",
            type: "POST",
            data: {
                id: $("#editAgentSelect").val(),
                name: name,
                position: position,
                contact: contact,
                website: website,
                agent_photo: agentPhoto,
                company_logo: companyLogo
            },
            success: function (success) {	
console.log(success);			
                if (parseInt(success)) {

                    loadAgentList("#editAgentSelect");
                    loadAgentList("#propertyAgentSelect");

                    swal("Success", "Agent saved", "success");

                } else {
                    swal("Error", "Agent not saved", "error");
                }
            },
            error: function () {
                swal("Error", "Error at editing the agent", "error");
            }
        });

    }

};

var editProperty = function () {

    var address = $("#editPropertyAddress").val().trim();
    var matterport_link = $("#editMatterPortLink").val().trim();
    var realestate_link = $("#editRealestateLink").val().trim();
    var googlemaps_link = $("#editGooglemapsLink").val().trim();

    if (address.length == 0 || matterport_link.length == 0 || realestate_link.length == 0 || googlemaps_link.length == 0) {

        swal("Warning", "Something is missing..", "warning");

    } else {
        $.ajax({
            url: "../php/editProperty.php",
            type: "POST",
            data: {
                id: $("#editPropertySelect").val(),
                address: address,
                matterport_link: matterport_link,
                realestate_link: realestate_link,
                googlemaps_link: googlemaps_link,
                agent_id: $("#editPropertyAgentSelect").val()
            },
            success: function (success) {
				console.log(success);
                if (parseInt(success)) {

                    loadPropertyList();

                    swal("Success", "Property saved", "success");

                } else {
                    swal("Error", "Property not saved", "error");
                }
            },
            error: function () {
                swal("Error", "Issue editing property", "error");
            }
        });

    }

};

/**
 * Loads the option fields for the edit agent select
 */
var loadAgentList = function (id) {

    $.ajax({
        url: "../php/loadAgentList.php",
        type: "POST",
		dataType: "json",
        data: {},
        success: function (data) {
            var optionHTML = "<option value='' disabled selected>Select agent</option>";

            $.each(data, function (index, agent) {
				
                optionHTML += "<option value='" + agent.id + "'>" + agent.name + "</option>";
            });

            $(id).html(optionHTML);
        },
        error: function (data) {
            swal("Error", "Error loading agent list", "error");
        }
    });

};

/**
 * Loads the option fields for the edit property select
 */
var loadPropertyList = function (id) {

    $.ajax({
        url: "../php/loadPropertyList.php",
        type: "POST",
		dataType: "json",
        data: {},
        success: function (data) {
            var optionHTML = "<option value='' disabled selected>Select property</option>";

            $.each(data, function (index, property) {
                optionHTML += "<option value='" + property.id + "'>" + property.address + "</option>";
            });

            $(id).html(optionHTML);
        },
        error: function () {
            swal("Error", "Error loading property list", "error");
        }
    });

};

/**
 * Uploads a new agent photo
 *
 * @param id of the file input where the photo is coming from
 */
var uploadAgentPhoto = function(id) {
    var data = new FormData();

    data.append("file", $(id)[0].files[0]);

    $.ajax({
        url: "",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function(data) {
        },
        error: function() {
            swal("Error", "Issue uploading agent photo", "error");
        }
    });
};

/**
 * Uploads a new property logo
 *
 * @param id of the file input where the logo is coming from
 */
var uploadCompanyLogo = function(id) {
    var data = new FormData();

    data.append("file", $(id)[0].files[0]);

    $.ajax({
        url: "",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        success: function(data) {
        },
        error: function() {
            swal("Error", "Issue uploading property logo", "error");
        }
    });
};

/**
 * Generates a URL for clients to link to based off the current URL and property ID
 */
var generateURL = function () {

    $.ajax({
        url: "../php/createURL.php",
        type: "POST",
		dataType: "text",
        data: {
            id: $("#generateURLSelect").val()
        },
        success: function (data) {
            $("#uniqueURLContainer").val(data);
        },
        error: function () {
            swal("Error", "Error retrieving a URL for that property", "error");
        }
    });

};

/**
 * Turns image into base64 string
 * @param input to turn into base 64 string
 */
var readAgentPhoto = function(input) {
    if ( input.files && input.files[0] ) {
        var FR = new FileReader();

        FR.onload = function(e) {
            agentPhoto = e.target.result;
        };

        FR.readAsDataURL( input.files[0] );
    }
};

/**
 * Turns image into base64 string
 * @param input to turn into base 64 string
 */
var readCompanyLogo = function(input) {
    if ( input.files && input.files[0] ) {
        var FR = new FileReader();

        FR.onload = function(e) {
             companyLogo = e.target.result;
        };

        FR.readAsDataURL( input.files[0] );
    }
};

/**
 * Sets the agent photo to false - this happens when a file is selected for upload but is cancelled.
 */
var setAgentPhotoFalse = function() {
    agentPhoto = false;
};

/**
 * Sets the company logo to false - this happens when a file is selected for upload but is cancelled.
 */
var setCompanyLogoFalse = function() {
    companyLogo = false;
};

