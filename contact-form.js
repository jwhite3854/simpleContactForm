function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function onContactFormSubmit(token) {

    var form_data = new FormData();

    var contact_name = document.getElementById('c_name').value;
	var contact_email = document.getElementById('c_email').value;
	var contact_message = document.getElementById('c_message').value;

	form_data.append('c_name', contact_name);
	form_data.append('c_email', contact_email);
	form_data.append('c_message', contact_message);
    form_data.append('c_token', token);


    var xhr = new XMLHttpRequest();
    var action = contact_form.getAttribute("action");
	xhr.open('POST', action, true);
	xhr.overrideMimeType('text/xml; charset=UTF-8');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.onreadystatechange = function() {

        console.log(xhr.responseText);

		if (xhr.readyState == 4 && xhr.status == 200) {
			var result = xhr.responseText;
			if ( result ) {
				document.getElementById('c_form_wrapper').innerHTML = "<p>Thank you for contacting Julia! She will respond to your message shortly.</p>";
			} else {
				document.getElementById('c_form_wrapper').innerHTML = '<p>There was an error processing your message. Please <a href="mailto:jwhite3854@gmail.com">email Julia</a> directly with any questions.</p>';
			}
		}
	};
	xhr.send(form_data);
}

function contactFormValidate(event) {
	event.preventDefault();

	document.getElementById("c_spinner").style.display = "inline";

	document.getElementById('c_name_error').innerHTML = "";
	document.getElementById('c_email_error').innerHTML = "";
	document.getElementById('c_message_error').innerHTML = "";
	
	var name = document.getElementById('c_name').value;
	var email = document.getElementById('c_email').value;
	var message = document.getElementById('c_message').value;
	var errors = false;
	
	if ( name.length == 0 ) {
		document.getElementById('c_name_error').innerHTML = '<span class="c_error">Your name is required.</span>';
		errors = true;
	}
	
	if ( email.length == 0 || isEmail(email) == false ) {
		document.getElementById('c_email_error').innerHTML = '<span class="c_error">Valid email address is required.</span>';
		errors = true;
	}

	if ( message.length == 0 ) {
		document.getElementById('c_message_error').innerHTML = '<span class="c_error">Your message is required.</span>';
		errors = true;
	} 

	if ( errors == false ) {
        grecaptcha.ready(function() {
            grecaptcha.execute('YOUR_PUBLIC_KEY_HERE', {action: 'send_message'}).then(function(token) {
                onContactFormSubmit(token);
            });
        });
    }
    
    document.getElementById("c_spinner").style.display = "none";
}

function onContactFormLoad() {
	var element = document.getElementById('c_submit');
	element.onclick = contactFormValidate;
}

onContactFormLoad();