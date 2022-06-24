<?php

use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Halign;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Trim;
use Beeyev\Thumbor\Manipulations\Valign;
use Beeyev\Thumbor\Thumbor;

test('Trim', function() {
    $thumbor = new Thumbor();

    $thumbor->trim(Trim::TOP_LEFT);
    expect($thumbor->get('i.jpg'))->toContain('trim:top-left');

    $thumbor->trim(null, 42);
    expect($thumbor->get('i.jpg'))->toContain('trim:42');

    $thumbor->trim(Trim::TOP_LEFT, 42);
    expect($thumbor->get('i.jpg'))->toContain('trim:top-left:42');

    $thumbor->noTrim();
    expect($thumbor->get('i.jpg'))->not()->toContain('trim');
});

test('Crop', function() {
    $thumbor = new Thumbor();

    $thumbor->crop(10, 20, 30, 40);
    expect($thumbor->get('i.jpg'))->toContain('10x20:30x40');

    $thumbor->noCrop();
    expect($thumbor->get('i.jpg'))->not()->toContain('10x20:30x40');
});

test('Fit', function() {
    $thumbor = new Thumbor();

    $thumbor->fit(Fit::ADAPTIVE_FULL_FIT_IN);
    expect($thumbor->get('i.jpg'))->toContain('adaptive-full-fit-in');

    $thumbor->noFit();
    expect($thumbor->get('i.jpg'))->not()->toContain('adaptive-full-fit-in');
});

test('Resize', function() {
    $thumbor = new Thumbor();

    $thumbor->resize(123, 321);
    expect($thumbor->get('i.jpg'))->toContain('123x321');

    $thumbor->resizeWidth(456);
    expect($thumbor->get('i.jpg'))->toContain('456x321');

    $thumbor->resizeHeight(789);
    expect($thumbor->get('i.jpg'))->toContain('456x789');

    $thumbor->noResize();
    expect($thumbor->get('i.jpg'))->not()->toContain('456x789');

    $thumbor->resizeWidth(Resize::ORIG);
    $thumbor->resizeHeight(0);
    expect($thumbor->get('i.jpg'))->toContain('origx0');

    $thumbor->resize(null, null);
    expect($thumbor->get('i.jpg'))->toContain('origx0');

    $thumbor->noResize();
    expect($thumbor->get('i.jpg'))->not()->toContain('origx0');
});

test('Horizontal Align', function() {
    $thumbor = new Thumbor();

    $thumbor->halign(Halign::CENTER);
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/center/i.jpg');

    $thumbor->noHalign();
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/i.jpg');
});

test('Vertical Align', function() {
    $thumbor = new Thumbor();

    $thumbor->valign(Valign::MIDDLE);
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/middle/i.jpg');

    $thumbor->noValign();
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/i.jpg');
});

test('Smart Crop', function() {
    $thumbor = new Thumbor();

    $thumbor->smartCropEnable();
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/smart/i.jpg');

    $thumbor->smartCropDisable();
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/i.jpg');
});

test('Filters', function() {
    $thumbor = new Thumbor();

    $thumbor->addFilter('brightness', 42, 88);
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/filters:brightness(42,88)/i.jpg');

    $thumbor->addFilter('sun', 43);
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/filters:brightness(42,88):sun(43)/i.jpg');

    $thumbor->noFilters();
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/i.jpg');

    $thumbor->addFilter('strip_icc');
    expect($thumbor->get('i.jpg'))->toEqual('unsafe/filters:strip_icc()/i.jpg');
});
