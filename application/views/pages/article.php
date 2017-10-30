<?php if (!$article): ?>
    <p>This article is not available in the selected language.</p>
<?php else: ?>
    <h3><?= $article['title'] ?></h3>
    <div>
        <p><?= $article['date'] ?></p>
        <p><?= $article['main_pic'] ?></p>
        <p><?= $article['content'] ?></p>
        <p><?= $article['slug'] ?></p>
    </div>
<?php endif; ?>
