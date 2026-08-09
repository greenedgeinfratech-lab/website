<?php
include 'db.php';

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM news WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$news = $stmt->get_result()->fetch_assoc();
?>
<h2><?= htmlspecialchars($news['title']); ?></h2>
<p><?= date("d M Y", strtotime($news['created_at'])); ?></p>

<?php if($news['image']): ?>
<img src="uploads/<?= $news['image']; ?>" width="600">
<?php endif; ?>

<div>
<?= $news['content']; ?>
</div>
