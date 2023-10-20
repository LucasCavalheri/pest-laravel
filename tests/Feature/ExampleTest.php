<?php

test('the application returns a successful response')
    ->get('/')
    ->assertSuccessful();
