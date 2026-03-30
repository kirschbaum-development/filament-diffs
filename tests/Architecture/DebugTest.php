<?php

test('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

test('will not use env')
    ->expect('env')
    ->not->toBeUsed();
