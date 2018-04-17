
<head>
	<link rel = 'stylesheet' href = '../font-awesome-4.7.0/font-awesome.min.css'/>
	<link rel = 'stylesheet' href = '../css/bootstrap.min.css'/>
	<link rel ='stylesheet' href = '../css/styles.css'/> 
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
</style>
<body>
	<div class ='container'>
		<div class = 'card col-md-10 offset-1' style ='margin-top:50px;opacity:0.95; border-radius:10px;'>
			<div class ='card-block' >

				<div class ='row'>
					<div class= 'col-md-4'>
						<h4 class ='header' style ='margin-top:5px'>Registered Participants</h4>
					</div>
					<div class = 'col-md-2' style ='padding-right:1px'>
						<a href = '/reports' class ='btn btn-success btn-block'>View reports</a>
					</div>
					<div class = 'col-md-2' style ='padding-left:5px'>
						<a href = '/generate/all' class ='btn btn-success btn-block'>Print all</a>
					</div>
					<div class = 'col-md-4' style ='padding-left:5px'>
						<input type ='text' class ='form-control' name ='search' placeholder ='Search'/>
					</div>
				</div>
				<hr/>

				<div id ='content' ></div>

			</div>
		</div>
	</div>
</body>
<script src = '../js/jquery/jquery-3.2.1.min.js'></script>
<script src ='../js/bootstrap.min.js'></script>
<script>
	$(document).ready(function(){
		var autoupdate = true
		$('input[name=search]').keyup(function(){
			var inputVal = $(this).val()
			autoupdate = (inputVal == '')
			$('tbody tr').each(function(){
				var data = ''
				$(this).each(function(){
					data += $(this).text()
				})
				if(data.toLowerCase().indexOf(inputVal) > -1)
					$(this).show()
				else
					$(this).hide()
			})
		})
		$('#content').load('getparticipants.php')
		setInterval(function(){
			if(autoupdate){
				$('#content').load('/getparticipants')
			}
		},2000)
	})
</script>