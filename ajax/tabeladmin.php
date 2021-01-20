<!-- ------------------
		Get Data
------------------- -->
<?php 
	require '../method/function.php';
	$key = $_GET["key"];
	$alladmin = tampil("SELECT*FROM admin WHERE id LIKE '%$key%' OR adminname LIKE '%$key%'");
?>

<!-- ------------------
	Response Text
------------------- -->
<table class="table table-bordered table-hover">
	<thead class="thead-dark">
		<tr>
			<th scope="col">
				No
			</th>
			<th scope="col">
				Foto
			</th>
			<th scope="col" style="min-width: 180px;">
				Username
			</th>
			<th scope="col" style="min-width: 120px;">
				Aksi
			</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		<?php foreach($alladmin as $alladmin2) : ?>
		<tr class="text-center" style="background-color: rgba(255, 255, 255, 0.5);">
			<th scope="row" class="align-middle">
				<?= $i++; ?>
			</th>
			<th scope="row">
				<img src="../asset/imgAdmin/<?= $alladmin2['adminfoto']; ?>" title="<?= $alladmin2['adminname']; ?>" width="100px" height="100px" id="adminfoto">
			</th>
			<td class="align-middle">
				<?= $alladmin2['adminname']; ?>
			</td>
			<td class="align-middle">
				<a href="edit.php?idadmin=<?= $alladmin2['id']; ?>" class="btn btn-warning">
					<i class="fas fa-edit"></i>
				</a>
				<a href="delete.php?xx=<?= $alladmin2['id']; ?> & table=admin & colom=id" onclick="return confirm('yakin ingin menghapus?');" class="btn btn-danger">
					<i class="fas fa-trash-alt"></i>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>