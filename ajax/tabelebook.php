<!-- ------------------
		Get Data
------------------- -->
<?php 
	require '../method/function.php';
	$key = $_GET["key"];
	$ebook = tampil("SELECT*FROM ebook WHERE id LIKE '%$key%' OR judulbuku LIKE '%$key%' ORDER BY id DESC");
?>

<!-- ------------------
	Response Text
------------------- -->
<table class="table" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
	<thead class="thead-dark text-center">
		<tr>
			<th scope="col">Foto</th>
			<th scope="col" style="min-width: 200px;">Judul</th>
			<th scope="col" style="min-width: 160px;">Kategori</th>
			<th scope="col" style="min-width: 120px;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($ebook as $eb) : ?>
		<tr class="text-center">
			<th><img src="../asset/imgEbook/<?= $eb['fotobuku']; ?>" title="<?= $eb['judulbuku']; ?>" width="100px" height="120px" id="ebookfoto"></th>
			<th class="align-middle"><?= $eb['judulbuku']; ?></th>
			<td class="align-middle"><?= $eb['kategori']; ?></td>
			<td class="align-middle">
				<a href="../edit/?idbuku=<?= $eb['id']; ?>" class="btn btn-warning pt-2 pl-3 pr-3 pb-1">
					<img src="../asset/imgBground/edit.svg" width="24px"></i></a>
				<a href="../method/delete.php?xx=<?= $eb['judulbuku']; ?> & table=ebook & colom=judulbuku" class="btn btn-danger ml-2 pt-2 pl-3 pr-3 pb-0" onclick="return confirm('yakin ingin menghapus?');">
					<img src="../asset/imgBground/delete.svg" width="24px"></i></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>