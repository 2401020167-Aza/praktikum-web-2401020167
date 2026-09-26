<?php

it('renders five scores and a passing average by default', function () {
    $this->get('/latihan-php')
        ->assertOk()
        ->assertSee('Nama Mahasiswa')
        ->assertSee('80')
        ->assertSee('75')
        ->assertSee('90')
        ->assertSee('85')
        ->assertSee('95')
        ->assertSee('Rata-rata: 85.00')
        ->assertSee('Status: Lulus');
});

it('renders a needs-improvement status for the alternate scores', function () {
    $this->get('/latihan-php?uji=perbaikan')
        ->assertOk()
        ->assertSee('Rata-rata: 67.00')
        ->assertSee('Status: Perlu Perbaikan');
});
