
<table class = 'table  table-bordered' >
	<thead  style ='border-bottom:none'>
		<th style = 'font-weight: bold; background-color: #F9F9F9' >Full Name</th>
		<th style = 'font-weight: bold; background-color: #F9F9F9'>School</th>
		<th style ='font-weight:bold; background-color: #F9F9F9'>Action</th>
	</thead>
	<div style ='max-height:400px;  overflow-x: hidden;overflow-y:scroll;'>
		@foreach($users as $user)
		<tr>
			<td> {{strtoupper($user->last_name)}}, {{$user->first_name}} {{$user->middle_initial}}</td>
			<td>{{ $user->school }}</td>
			<td><a class ='btn btn-success btn-block' href = "/generate/{{$user->id}}">Print</a></td>
		</tr>
		@endforeach
	</tbody>
</table>