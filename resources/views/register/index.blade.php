<head>
	<link rel = 'stylesheet' href = '/font-awesome-4.7.0/font-awesome.min.css'/>
	<link rel = 'stylesheet' href = '/css/bootstrap.min.css'/>
	<link rel ='stylesheet' href = '/css/styles.css'/> 
</head>
<style>
.lead{
	font-size: 1.1em;
	font-weight: 400;
}
body{
	background-image:url(../assets/images/abstract-geometric-pattern-background_1319-242.jpg);
}
.help-block{
	color:red;
}
sup{
	color:red;
}
button:hover{
	cursor:pointer;
}
</style>
<body>
	<div class="modal fade" id="prompt" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<p><b id = 'modal-title'></b></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class ='container'>
		<div class="modal fade in" id ='disclaimer' tabindex="-1" role="dialog">
			<div class="modal-dialog  modal-lg"  role="document">
				<div class="modal-content" style ='border-radius:10px'>
					<div class="modal-header" style ='background-color:#F7F7F7;border-top-left-radius:10px;border-top-right-radius: 10px'>
						<h5 class="modal-title" style ='font-weight:bold;color:#333333'>Disclaimer</h5>
					</div>
					<div class="modal-body" style ='padding:20px;color:#535353'>
						<p style ='text-align:justify'>&quot;The event organizers are collecting information from you as participants for
							purposes of registration and overall event management.  By giving us
							information about yourself and signing the registration form, you consent to us
						using your information where necessary for the aforementioned purposes.</p>
						<p style ='text-align: justify'>
							After conclusion of the event and completion of all necessary reports, your
							personal data will be saved in secure files for future reference and networking
							activities. If you do not wish to be contacted further after this event, kindly
						inform the organizers.&quot;</p>
					</div>
					<div class="modal-footer">
						<button type="button" id ='btnDismiss' onclick = "$('#prompt').modal('show')" class="btn btn-success btn-block" data-dismiss = 'modal'>I understood. Sign me up!</button>
					</div>
				</div>
			</div>
		</div>
		<div class = 'card col-md-8 offset-2' style ='margin-top:50px;opacity:0.95; border-radius:10px;'>
			<div class ='card-block'>
				<h4 class ='header'>Personal Information</h4>
				<hr/>
				<form method = 'post' id = 'submit-form' >
					{{ csrf_field() }}
					<div class ='row'>
						<div class ='col-md-5'>
							<div class ='form-group'>
								<label class ='lead' >Last Name<sup>*</sup></label>
								<input type = 'text' class ='form-control' pattern = "[a-zA-Z\s\.]+" placeholder = 'Last name' name ='lname' maxlength = '25' REQUIRED />

							</div>
						</div>
						<div class ='col-md-5'>
							<div class ='form-group'>
								<label class ='lead'>First Name<sup>*</sup></label>
								<input type = 'text' class ='form-control' placeholder ='First name' pattern = "[a-zA-Z\s\.]+" name ='fname' maxlength ='25' REQUIRED />
							</div>
						</div>
						<div class ='col-md-2'>
							<div class ='form-group'>
								<label class ='lead'>MI</label>
								<input type = 'text' placeholder ='MI' class ='form-control'  maxlength = '3' name ='mname' />
							</div>
						</div>
					</div>
					<div class ='row'>
						<div class ='col-md-8'>
						<div class ='form-group'>
							<label class ='lead' >School<sup>*</sup></label>
							<input type = 'text'	placeholder = 'School'class ='form-control' pattern = "[a-zA-Z\s\.]+[a-zA-Z\.]*$" name ='school' REQUIRED/>
						</div>
						</div>
						<div class ='col-md-4'>
							<div class ='form-group'>
								<label class ='lead'>Gender<sup>*</sup></label>
								<select class ='form-control' name ='gender'>
									<option selected value ='1'>Male</option>
									<option value ='0'>Female</option>
								</select>
							</div>
						</div>
					</div>
					<div class ='form-group'>
						<label class ='lead' >Email (Optional)</label>
						<input type = 'email'	placeholder = 'Email address (Use Gmail)' class ='form-control' name ='email'/>
					</div>
					<input type ='hidden' name ='submit'/>
					<button type ='submit'  class ='btn btn-primary btn-fill btn-block' style ='background-color: #00b11b; border-color:#00b11b'>Submit</button>
				</form>
			</div>
		</div>
	</div>
</body>
<script src = '/js/jquery/jquery-3.2.1.min.js' ></script>
<script src ='/js/bootstrap.min.js'></script>
<script>
	$('#submit-form').submit(function(e){
		e.preventDefault()
		$('#disclaimer').modal('show')
		$.ajax({
			url:'/addparticipant',
			type: 'POST',
			data: $(this).serialize(),
			success:function(html){	
			console.log(html) 
				$('#modal-title').html(`Welcome, ${$('input[name=fname]').val()}`)
				$('input').val("") 
			},
			error: function(html){
				console.log(html)
			}
		})
	})
</script>