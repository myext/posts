<p id="pages">
    <?php if ($this->last > 1): ?>
        <a href="<?= $this->url.'1'; ?>" title="atgal">atgal </a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $this->last; $i++) :?>
        <?php if ($i == $this->current): ?>
            <?= $i.' '; ?>
        <?php else: ?>
            <a href="<?= $this->url.$i; ?>" title="<?= $i; ?>"><?= $i.' '; ?></a>
        <?php endif; ?>
    <?php endfor;?>

    <?php if ($this->last > 1): ?>
        <a href="<?= $this->url.$this->last; ?>" title="toliau">toliau</a>
    <?php endif; ?>
</p>