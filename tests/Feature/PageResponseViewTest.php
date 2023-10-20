<?php

test('a rota products está utilizando a view products')
    ->get('/products')
    ->assertViewIs('products');

test('a rota products está passando uma lista de produtos para a view products')
    ->get('/products')
    ->assertViewIs('products')
    ->assertViewHas('products');
