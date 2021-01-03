<!-- ------------------
		Get Data
------------------- -->
<?php
	require '../method/function.php';
	$key = $_GET['key'];
	
	$jmlDataPerhalaman = 12;
	$totalDataEbook = count(tampil("SELECT*FROM ebook WHERE judulbuku LIKE '%$key%'"));
	$jmlHalaman = ceil($totalDataEbook / $jmlDataPerhalaman);
	if(isset($_GET['halaman'])){
		$halamanAktiv = $_GET['halaman'];
	}
	else{
		$halamanAktiv = 1;
	}
	$indexAwal = ($jmlDataPerhalaman*$halamanAktiv) - $jmlDataPerhalaman;
	$dataebook1 = tampil("SELECT*FROM ebook WHERE judulbuku LIKE '%$key%' LIMIT $indexAwal,$jmlDataPerhalaman");
?>

<!-- ------------------
	Response Text
------------------- -->
<?php foreach($dataebook1 as $dataebook2) : ?>
	<a href="download/?idbuku=<?= $dataebook2['id']; ?>" id="MyCard" title="<?= $dataebook2['judulbuku']; ?>">
		<img src="asset/imgEbook/<?= $dataebook2['fotobuku']; ?>">
	</a>
<?php endforeach; ?>

<ul class="pagination">
	<?php if($halamanAktiv > 1) : ?>
	<li class="page-item">
		<a class="page-link" href="?halaman=<?= $halamanAktiv - 1; ?>" aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
		</a>
	</li>
	<?php endif; ?>

	<?php for($i=1; $i<=$jmlHalaman; $i++) : ?>
		<?php if($i == $halamanAktiv) : ?>
		<li class="page-item active" aria-current="page">
			<a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
		</li>
		<?php else : ?>
		<li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
		<?php endif; ?>
	<?php endfor; ?>

	<?php if($halamanAktiv < $jmlHalaman) : ?>
	<li class="page-item">
		<a class="page-link" href="?halaman=<?= $halamanAktiv + 1; ?>" aria-label="Next">
			<span aria-hidden="true">&raquo;</span>
		</a>
	</li>
	<?php endif; ?>
</ul>