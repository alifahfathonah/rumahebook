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
<table class="table table-bordered table-hover">
	<thead class="thead-dark text-center">
		<tr>
			<th scope="col">
				Foto
			</th>
			<th scope="col" style="min-width: 200px;">
				Judul
			</th>
			<th scope="col" style="min-width: 160px;">
				Kategori
			</th>
			<th scope="col" style="min-width: 120px;">
				Aksi
			</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($ebook as $eb) : ?>
		<tr class="text-center" style="background-color: rgba(255, 255, 255, 0.5);">
			<th>
				<img src="../asset/imgEbook/<?= $eb['fotobuku']; ?>" title="<?= $eb['judulbuku']; ?>" width="100px" height="120px" id="ebookfoto">
			</th>
			<th class="align-middle">
				<?= $eb['judulbuku']; ?>
			</th>
			<td class="align-middle">
				<?= $eb['kategori']; ?>
			</td>
			<td class="align-middle">
				<a href="edit.php?idbuku=<?= $eb['id']; ?>" class="btn btn-warning">
					<i class="fas fa-edit"></i>
				</a>
				<a href="delete.php?xx=<?= $eb['judulbuku']; ?> & table=ebook & colom=judulbuku" class="btn btn-danger" onclick="return confirm('yakin ingin menghapus?');">
					<i class="fas fa-trash-alt"></i>
				</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>