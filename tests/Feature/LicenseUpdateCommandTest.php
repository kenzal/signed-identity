<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->licensePath = base_path('LICENSE');
    $this->originalLicense = File::exists($this->licensePath)
        ? File::get($this->licensePath)
        : null;
});

afterEach(function () {
    if ($this->originalLicense === null) {
        File::delete($this->licensePath);

        return;
    }

    File::put($this->licensePath, $this->originalLicense);
});

it('updates LICENSE from SPDX using the default MIT identifier', function () {
    Http::fake([
        'raw.githubusercontent.com/spdx/license-list-data/main/text/MIT.txt' => Http::response(
            "MIT License\n\nCopyright (c) <year> <copyright holders>\n",
            200
        ),
    ]);

    $this->artisan('license:update')
        ->expectsOutput('Updated LICENSE using SPDX "MIT".')
        ->assertExitCode(0);

    $licenseContent = File::get($this->licensePath);

    expect($licenseContent)
        ->toContain('MIT License')
        ->toContain((string) now()->year)
        ->toContain('Laravel contributors');
});

it('uses the APP_LICENSE config value when no argument is given', function () {
    config(['app.license' => 'Apache-2.0']);

    Http::fake([
        'raw.githubusercontent.com/spdx/license-list-data/main/text/Apache-2.0.txt' => Http::response(
            "Apache License\nVersion 2.0\n\nCopyright (c) [year] [fullname]\n",
            200
        ),
    ]);

    $this->artisan('license:update')
        ->expectsOutput('Updated LICENSE using SPDX "Apache-2.0".')
        ->assertExitCode(0);

    expect(File::get($this->licensePath))
        ->toContain('Apache License')
        ->toContain((string) now()->year)
        ->toContain('Laravel contributors');
});

it('returns an error when SPDX does not return a license', function () {
    Http::fake([
        'raw.githubusercontent.com/spdx/license-list-data/main/text/NOPE.txt' => Http::response('', 404),
    ]);

    $this->artisan('license:update NOPE')
        ->expectsOutput('Could not fetch SPDX license "NOPE" (HTTP 404).')
        ->assertExitCode(1);

    expect(File::get($this->licensePath))->toBe($this->originalLicense);
});
