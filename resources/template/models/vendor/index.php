<?php

$link = '../';

function get_redirect_url()
{
    return '../';
}

$link = get_redirect_url();

header('Location: ' . $link);
exit();
