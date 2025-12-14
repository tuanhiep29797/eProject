<?php if (!empty($breadcrumb)): ?>
    <div class="mt-3">
        <nav aria-label="breadcrumb" class="mt-3">
            <ol class="breadcrumb align-items-center">

                <?php foreach ($breadcrumb as $index => $b): ?>

                    <li class="breadcrumb-item <?= $index === count($breadcrumb)-1 ? 'active' : '' ?>">
                        <?php if (!empty($b["url"])): ?>
                            <a href="<?= $b["url"]; ?>" 
                                class="d-flex align-items-center text-decoration-none">
                                <?php if (!empty($b["icon"])): ?>
                                    <i class="bi <?= $b["icon"]; ?> me-1"></i>
                                <?php endif; ?>
                                <?= htmlspecialchars($b["label"]); ?>
                            </a>
                        <?php else: ?>
                            <span class="d-flex align-items-center">
                                <?php if (!empty($b["icon"])): ?>
                                    <i class="bi <?= $b["icon"]; ?> me-1"></i>
                                <?php endif; ?>
                                <?= htmlspecialchars($b["label"]); ?>
                            </span>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>

            </ol>
        </nav>
    </div>
<?php endif; ?>
