<?php
include '../lib.php';
$main_movie = query_row("SELECT * FROM movie WHERE id=?", 10);
$movies = query_rows("SELECT * FROM movie");
?>
<?php include 'layout.header.html'; ?>

<div class="hero">
	<div class="container">
		<h2><?= $main_movie['title'] ?></h2>
		<p><?= $main_movie['plot'] ?></p>
		<a class="btn btn-primary" href="/movies/<?= $main_movie['id'] ?>">자세히 보기</a>
	</div>
</div>

<div class="main">
	<div class="container">
	<h2>인기 영화</h2>
		<?php foreach( $movies as $movie ): ?>
		<div class="movie">
			<img alt="<?= addslashes($movie['title']) ?>" src="<?= $movie['image'] ?>"/>
			<h3><?= htmlentities($movie['title']) ?></h3>
			<p><?= $movie['year'] ?></p>
			<p><?= utf8_substr($movie['plot'], 0, 80) ?>...</p>
			<a href="/movies/<?= $movie['id'] ?>">자세히 보기</a>
		</div>
		<?php endforeach ?>
	</div>
</div>

<?php include 'layout.footer.html'; ?>