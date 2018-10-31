<?php
require __DIR__ . '/../core/bootstrap_phpunit.php';

// Workaround for phpunit error
// Ref: https://qiita.com/gigatune/items/b0f9be29215b8f0668c9
new Crypt();
