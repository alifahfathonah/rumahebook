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
<table class="table" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
	<thead class="thead-dark text-center">
		<tr>
			<th scope="col">No</th>
			<th scope="col">Foto</th>
			<th scope="col" style="min-width: 180px;">Username</th>
			<th scope="col" style="min-width: 120px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		<?php foreach($alladmin as $alladmin2) : ?>
		<tr class="text-center">
			<th class="align-middle"><?= $i++; ?></th>
			<th><img src="../asset/imgAdmin/<?= $alladmin2['adminfoto']; ?>" title="<?= $alladmin2['adminname']; ?>" width="100px" height="100px" id="adminfoto"></th>
			<td class="align-middle"><?= $alladmin2['adminname']; ?></td>
			<td class="align-middle">
				<a href="../edit/?idadmin=<?= $alladmin2['id']; ?>" class="btn btn-warning pt-2 pl-3 pr-3 pb-1">
					<img src="../asset/imgBground/edit.svg" width="24px"></i></a>
				<a href="../method/delete.php?xx=<?= $alladmin2['id']; ?> & table=admin & colom=id" onclick="return confirm('yakin ingin menghapus?');" class="btn btn-danger ml-2 pt-2 pl-3 pr-3 pb-0">
					<img src="../asset/imgBground/delete.svg" width="24px"></i></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>