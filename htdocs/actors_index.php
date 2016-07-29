<?php
include '../lib.php';
$actors = query_rows("SELECT * FROM actor");
?>
<?php include 'layout.header.html'; ?>

<div class="main">
	<div class="container">
		<h2>인기 배우</h2>
		<div class="row">
			<?php foreach( $actors as $actor ): ?>
			<div class="actor col-xs-2">
				<img alt="<?= $actor['name'] ?>" src="<?= $actor['image'] ?>"/>
				<h3><?= $actor['name'] ?></h3>
				<a href="/actors/<?= $actor['id'] ?>">자세히 보기</a>
			</div>
			<?php endforeach ?>
		</div>
	</div>
</div>

<?php include 'layout.footer.html'; ?>