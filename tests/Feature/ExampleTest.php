<?php

test('redirects the home page to the PHP exercise', function () {
    $response = $this->get(route('home'));

    $response->assertRedirect('/latihan-php');
});
