<?php

test('testando código 200')
    ->get('/')
    ->assertStatus(200)
    ->assertOk();

test('testando código 404')
    ->get('/404')
    ->assertStatus(404)
    ->assertNotFound();

test('testando código 403:: não tem permissão de acesso')
    ->get('/403')
    ->assertStatus(403)
    ->assertForbidden();
