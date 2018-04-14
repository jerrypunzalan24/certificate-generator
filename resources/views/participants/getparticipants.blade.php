<?php include_once('../connectDB.php');
$query = mysqli_query($con, "SELECT * FROM data ORDER BY id DESC");
?>
<table class = 'table  table-bordered' >
	<thead  style ='border-bottom:none'>
		<th style = 'font-weight: bold; background-color: #F9F9F9' >Full Name</th>
		<th style = 'font-weight: bold; background-color: #F9F9F9'>School</th>
		<th style ='font-weight:bold; background-color: #F9F9F9'>Action</th>
	</thead>
	<div style ='max-height:400px;  overflow-x: hidden;overflow-y:scroll;'>
		<?php while($row = mysqli_fetch_assoc($query)){?>
		<tr>
			<td><?= strtoupper($row['last_name']) .", {$row['first_name']} {$row['middle_initial']}" ?></td>
			<td><?= $row['school'] ?></td>
			<td><a class ='btn btn-success btn-block' href = '/attendance-system/generate?id=<?=$row['id']?>'>Print</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>