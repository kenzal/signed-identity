<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('license:update {license?}', function () {
    $spdxId = trim($this->argument('license') ?? config('app.license', 'MIT'));

    if ($spdxId === '') {
        $this->error('Please provide a valid SPDX license identifier.');

        return 1;
    }

    $url = sprintf(
        'https://raw.githubusercontent.com/spdx/license-list-data/main/text/%s.txt',
        $spdxId
    );

    try {
        $response = Http::accept('text/plain')->timeout(15)->get($url);
    } catch (Throwable $exception) {
        $this->error('Failed to fetch license text: '.$exception->getMessage());

        return 1;
    }

    if (! $response->successful()) {
        $this->error(sprintf('Could not fetch SPDX license "%s" (HTTP %d).', $spdxId, $response->status()));

        return 1;
    }

    $licenseText = trim($response->body());

    if ($licenseText === '') {
        $this->error(sprintf('SPDX license "%s" returned empty content.', $spdxId));

        return 1;
    }

    $replacements = [
        '<year>' => (string) now()->year,
        '<copyright holders>' => sprintf('%s contributors', config('app.name', 'Project')),
        '[year]' => (string) now()->year,
        '[fullname]' => sprintf('%s contributors', config('app.name', 'Project')),
    ];

    $licenseText = str_replace(array_keys($replacements), array_values($replacements), $licenseText);

    File::put(base_path('LICENSE'), $licenseText.PHP_EOL);

    $this->info(sprintf('Updated LICENSE using SPDX "%s".', $spdxId));

    return 0;
})->purpose('Fetch a license from SPDX and write it to LICENSE');

