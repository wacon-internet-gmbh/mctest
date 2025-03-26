<?php

defined('TYPO3') or die();

call_user_func(function () {
    $obj = new \Wacon\Mctest\Bootstrap\ExtLocalconf();
    $obj->invoke();
});
