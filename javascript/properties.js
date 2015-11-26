// Declare variables
var URLS = {};
var agent = {};


/**
 * Sets some initial values so that we can get them later
 */
var initialisePage = function() {

    // Get the property id from the query string parameter
    var pageURL = window.location.search.substring(1);
    var urlVariables = pageURL.split('&');
    var paramArray = urlVariables[0].split('=');
    var property_id = paramArray[1];

    // Get the property details, links, agent etc.
    $.ajax({
        url: "../php/initialisePage.php",
        type: "POST",
		dataType: "JSON",
        data: {property_id : property_id},
        success: function (data) {
            URLS = data.URLS;
            agent = data.agent;

            setValues();
        },
        error: function () {
            console.log("Error getting the property details");
        }
    });

};

/**
 * Gets the various website URLs
 * @returns {{}}
 */
var getURLS = function() {
	console.log(URLS);
    return URLS;
};

/**
 * Gets the agent details
 * @returns {{}}
 */
var getAgent = function() {
    return agent;
};

/**
 * Sets some HTML components so that the page is rendered
 */
var setValues = function() {
    // Set iframe URL
    $("#matterPortIframe").prop("src", URLS.matterport_link);

    // Set bookInspection div contents
    $("#agentPhoto")
        .prop("src", agent.agent_photo)
        .prop("alt", agent.name)
		.width(200).height(250);

    $("#agentName").html(agent.name);
    $("#agentPosition").html(agent.position);
	
	var names = agent.name.split(' ');
	$("#desc").html("Book an inspection with " + names[0] + " at:");

    $("#agentContact")
        .html(agent.contact)
        .prop("href", "mailto:" + agent.contact);

    // Set agent website link button background
	if (agent.company_logo != null){
    $(".leftButton").css({"background" : "url('"+ agent.company_logo + "')", "background-size" : "100% 100%"});
	}
};

