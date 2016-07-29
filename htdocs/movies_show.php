<?php
include '../lib.php';
$id = 1*GET('id', 0);
if( $id == 0 ) goto_url('/movies');

$movie = query_row("SELECT *
	FROM movie m 
	WHERE id = ?", $id);
$actors = query_rows("SELECT a.*
	FROM part p, actor a
	WHERE p.actor_id = a.id
	AND p.movie_id = ?", $id);

if( $movie === false ) goto_url('/movies');
?>
<?php include 'layout.header.html'; ?>

<div class="main movie-show">
	<div class="container">
		<h2 class="movie-title"><?= htmlentities($movie['title']) ?></h2>
		<div class="movie">
			<div class="info">
				<img alt="<?= addslashes($movie['title']) ?>" src="<?= $movie['image'] ?>"/>
				<p class="movie-release-year"><?= $movie['year'] ?></p>
				<p class="movie-plot"><?= $movie['plot'] ?></p>
			</div>
		</div>

		<h2>출연</h2>
		<?php foreach( $actors as $actor ): ?>
		<div class="actor">
			<img alt="<?= $actor['name'] ?>" src="<?= $actor['image'] ?>"/>
			<h3 class="actor-name"><?= $actor['name'] ?></h3>
			<p class="actor-bio"><?= utf8_substr($actor['bio'], 0, 80) ?>...</p>
			<a href="/actors/<?= $actor['id'] ?>">자세히 보기</a>
		</div>
		<?php endforeach ?>
	</div>
</div>

<?php include 'layout.footer.html'; ?>