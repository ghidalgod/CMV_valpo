<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <a href="<?= site_url('inicio') ?>">
            <i class="ace-icon fa fa-home home-icon"></i>
            </a>
        </li>
        <?php foreach ($breadcrumb as $item):?>
            <li>
            <?php if(empty($item['link'])): ?>
            <?= $item['name'] ?>
            <?php else: ?>
            <?= anchor($item['link'], $item['name'], array('title' => $item['name'])) ?>
            <?php endif; ?>
            </li>
        <?php endforeach;?>
    </ul>
</div>