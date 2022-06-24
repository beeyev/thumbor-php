<?php

use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Thumbor;

const BASE_URL = 'https://example.com/';
const SECURITY_KEY = '784512';

test('Thumbor init', function() {
    $thumbor = new Thumbor();
    expect($thumbor)->toBeInstanceOf(Thumbor::class);

    $thumbor = new Thumbor(BASE_URL, SECURITY_KEY);
    $thumbor->imageUrl('ezhik.jpg');

    expect($thumbor)->toBeInstanceOf(Thumbor::class)
        ->and(BASE_URL)->toContain($thumbor->getBaseUrl())
        ->and(SECURITY_KEY)->toEqual($thumbor->getSecurityKey())
        ->and('ezhik.jpg')->toEqual($thumbor->getImageUrl());
});

test('Signature', function() {
    expect('oTH96xYp0Fk4Co9-aDCVeN5nHI4=')
        ->toEqual(
            (new Thumbor())->securityKey(SECURITY_KEY)->sign('string to test encryption!32/')
        );
});

test('Result link', function() {
    $thumbor = new Thumbor(BASE_URL, SECURITY_KEY);

    $resultUrl = $thumbor
        ->trim(Trim::BOTTOM_RIGHT, 55)
        ->crop(12, 23, 24, 25)
        ->fit(Fit::ADAPTIVE_FULL_FIT_IN)
        ->resize(543, 965)
        ->resizeHeight(854)
        ->halign(Halign::CENTER)
        ->valign(Valign::MIDDLE)
        ->smartCropEnable()
        ->addFilter('strip_icc')
        ->addFilter('blur', 1)
        ->imageUrl('ezhik.jpg')
        ->get();

    expect($resultUrl)->toEqual('https://example.com/-KXQ3dClEx4OEQQ4sfufNOYce-o=/trim:bottom-right:55/12x23:24x25/adaptive-full-fit-in/543x854/center/middle/smart/filters:strip_icc():blur(1)/ezhik.jpg');
});
