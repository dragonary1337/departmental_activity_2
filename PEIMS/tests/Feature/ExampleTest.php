<?php

it('redirects guests to the login page from the home page', function () {
    $this->get('/')->assertRedirect(route('login'));
});
