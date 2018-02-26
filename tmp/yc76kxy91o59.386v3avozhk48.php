<?php echo $this->render('view/header.html',NULL,get_defined_vars(),0); ?>
    <div class = "container">
        <?php foreach (($octaves?:[]) as $octave): ?>
            <div class = "row">

                <?php foreach (($notes?:[]) as $note): ?>
                    <div class = "col-sm-1">
                        <?php if (substr($note, -1) == "#"): ?>
                            <button type = "button" class = "btn btn-dark"><?= ($note) ?></button>
                            <?php else: ?><button type = "button" class = "btn btn-light"><?= ($note) ?></button>

                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

<?php echo $this->render('view/footer.html',NULL,get_defined_vars(),0); ?>