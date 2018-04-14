<head>
	<link rel = 'stylesheet' href = '../font-awesome-4.7.0/font-awesome.min.css'/>
	<link rel = 'stylesheet' href = '../css/bootstrap.min.css'/>
	<link rel ='stylesheet' href = '../css/styles.css'/> 
</head>
<div class="modal fade in" id ='success' tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Success!</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Template has been loaded</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class ='container'>

	<div class ='row'>
		<div class ='col-md-4'>
			<div class ='row' style ='margin-top:50px'>
				{{ csrf_field() }}
				<div class ='form-group' style ='width:100%'>
					<label>Placeholder text</label>
					<input type ='text' name ='input' class ='form-control'>
				</div>
				<div class ='row'>
					<div class ='form-group col'>
						<div class ='input-group'>
							<span class="input-group-addon" id="basic-addon1">X</span>
							<input type ='text' name ='text_x' class ='form-control'>
						</div>
					</div>
					<div class ='form-group col' style ='padding-left:0px'>
						<div class ='input-group'>
							<span class ='input-group-addon'>Y</span>
							<input type ='text' name ='text_y' class ='form-control'>
						</div>
					</div>
					<div class = 'form-group col' style ='padding-left:0px'>
						<div class ='input-group'>
							<span class ='input-group-addon'>Align</span>
							<select class ='form-control' name ='align'>
								<option value = 'L'>Left</option>
								<option value ='C'>Middle</option>
								<option value ='R'>Right</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class ='row' style ='margin-top:25px'>
				<div class ='form-group col' style ='padding-left:0px'>
					<label>Fonts</label>
					<select name ='fonts' class ='form-control'>
						<option value ='OpenSans-Semibold.php'>Open sans</option>
						<option value ='ACaslonPro-Regular.php'>Adobe Caslon</option>
						<option value ='helvetica.php'>Helvetica</option>
						<option value ='RobotoCondensed-Regular.php'>Roboto Condensed Regular</option>
					</select>
				</div>
				<div class ='form-group col' style ='padding-right:0px' >
					<label>Font size</label>
					<input type ='number' name ='fontsize' class ='form-control'/>
				</div>
			</div>
			<div class ='row' style ='margin-top:25px'>
				<div class ='form-group' style ='width:100%'>
					<label>Template upload</label>
					<input type ='file' name ='filelist' class ='form-control'/>
				</div>
			</div>
			<div class ='row' style ='margin-top:25px'>
				<div class ='col' style ='padding-left:0px'>
					<button class = 'btn btn-success btn-block' id = 'apply'>Apply</button>
				</div>
				<div class ='col' style ='padding-right:0px'>
					<button class ='btn btn-success btn-block' id = 'save'>Save</button>
				</div>
			</div>
		</div>
		<div class ='col-md-8' >
			<iframe src = '/edit' style ='width:100%;height:100%'>
			</iframe> 
		</div>
	</div>
</div>
<script src = '../js/jquery/jquery-3.2.1.min.js' ></script>
<script src ='../js/bootstrap.min.js'></script>
<script>
	$('#apply').click(()=>{
		var querystr = 'edit='
		var text = $('input[name=input]').val() || ""
		var text_x = $('input[name=text_x]').val() || 0
		var text_y = $('input[name=text_y]').val() || 0
		var font = $('select[name=fonts]').val()
		var fontsize = $('input[name=fontsize]').val()
		var location = ''
		var align = $('select[name=align]').val() || 'L'
		var formData = new FormData();
		formData.append("files",$('input[name=filelist]')[0].files[0])
		formData.append("_token", $('input[name=_token]').val())
		$.ajax({
			url:"/gettext",
			type: "POST",
			data: formData,
			processData: false,
			contentType:false,
			success:function(data){
				location = data.split('\n')[0]
				querystr += `&input=${text}&text_x=${text_x}&text_y=${text_y}&font=${font}&location=${location}&fontsize=${fontsize}&align=${align}`
				$('iframe').attr('src',`/edit?${querystr}`)
				$( 'iframe' ).attr( 'src', function ( i, val ) { return val; })
			}
		})
		$('input').change(()=>{
			$('#apply').click()
		})
	})
	$('#save').click(()=>{
		var formData = new FormData();
		formData.append("files",$('input[name=filelist]')[0].files[0])
		formData.append("save", true)
		formData.append("font", $('select[name=fonts]').val())
		formData.append("fontsize",$('input[name=fontsize]').val())
		formData.append("x", $('input[name=text_x]').val() || 0)
		formData.append("y",$('input[name=text_y]').val() || 0)
		formData.append("align",$('input[name=align]').val() || 'L')
		$.ajax({
			url:"get_text.php",
			type:"POST",
			processData: false,
			contentType: false,
			data: formData,
			success:function(html){
				$('#success').modal('show')
			}
		})
	})
</script>