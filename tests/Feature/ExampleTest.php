<?php

it('redirects home to products', function () {
    $response = $this->get('/');

    $response->assertStatus(301);
    $response->assertRedirect('/products');
});
