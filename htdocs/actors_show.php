<?php
include '../lib.php';
$id = 1*GET('id', 0);
if( $id == 0 ) goto_url('/actors');

$actor = query_row("SELECT *
	FROM actor
	WHERE id = ?", $id);
$movies = query_rows("SELECT m.*
	FROM part p, movie m
	WHERE p.movie_id = m.id
	AND p.actor_id = ?", $id);

if( $actor === false ) goto_url('/actors');
?>
<?php include 'layout.header.html'; ?>

<div class="main">
	<div class="container">
		<h2><?= htmlentities($actor['name']) ?></h2>
		<div class="actor">
			<img alt="<?= addslashes($actor['name']) ?>" src="<?= $actor['image'] ?>"/>
			<div class="info">
				<p><?= $actor['bio'] ?></p>
			</div>
		</div>
		<h2>영화</h2>
		<?php foreach( $movies as $movie ): ?>
		<div class="movie">
			<img alt="<?= addslashes($movie['title']) ?>" src="<?= $movie['image'] ?>"/>
			<h3 class="movie-title"><?= htmlentities($movie['title']) ?></h3>
			<p class="movie-year"><?= $movie['year'] ?></p>
			<p class="movie-plot"><?= utf8_substr($movie['plot'], 0, 80) ?>...</p>
			<a href="/movies/<?= $movie['id'] ?>">자세히 보기</a>
		</div>
		<?php endforeach ?>
	</div>
</div>

<?php include 'layout.footer.html'; ?>