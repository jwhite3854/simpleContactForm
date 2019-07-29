<?php 

$token = filter_input(INPUT_POST, 'c_token');
if ( !empty($token) ) {

	$data = array(
		'secret' => 'YOUR_SECRET_KEY_HERE',
		'response' => $token
	);

	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($ch, CURLOPT_POST, true); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
	$response = curl_exec($ch); 
	curl_close($ch); 
	
	$results = json_decode( $response, true ); 
	if ( $results->success ) {

	}

	echo $response;
	die();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Contact Form</title>
	<style>
		.c_error { style="color:#f00; font-size: 12px; }
		#c_spinner { position: relative; height: 19px; border: 2px solid transparent; border-radius: 5px; cursor: pointer; }
		@keyframes spinner {
			to {transform: rotate(360deg);} 
		}
		#c_spinner:before { content: ''; box-sizing: border-box; position: absolute; top: 2px; left: -22px; width: 16px; height: 16px; border-radius: 50%; border: 2px solid #3E5C76; }
		#c_spinner.activate:before { border-top-color: rgba(255,255,255,0.7); border-right-color: #fff; animation: spinner .6s linear infinite; }
	</style>
</head>
<body>
	<!-- Contact start -->

	<section id="contact">
		<div class="container">
			<div id="c_form_wrapper">
				<form id="contact_form" action="" method="post">
					<div class="form-group">
						<label class="sr-only" for="c_name">Name</label>
						<input type="text" id="c_name" class="form-control" name="c_name" placeholder="Name"/>
						<div id="c_name_error"></div>
					</div>

					<div class="form-group">
						<label class="sr-only" for="c_email">Email</label>
						<input type="text" id="c_email" class="form-control" name="c_email" placeholder="Email" />
						<div id="c_email_error"></div>
					</div>

					<div class="form-group">
						<textarea class="form-control" id="c_message" name="c_message" rows="3" placeholder="Message" ></textarea>
						<div id="c_message_error"></div>
					</div>

					<button id="c_submit" class="btn">
						<span id="c_spinner" class="spinner-element">Send Message</span>
					</button>
				</form>
				<p>Protected by reCAPTCHA; the Google <a href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> &amp; <a href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.</p>
			</div>
		</div><!-- .container -->
	</section>
	<!-- Contact end -->

	<!-- Javascript files -->
	<script src="contact-form.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=YOUR_PUBLIC_KEY_HERE"></script>
</body>
</html>