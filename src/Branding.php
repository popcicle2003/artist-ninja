<?php

namespace ArtistNinja;

class Branding
{
    public static function public(): array
    {
        if (! class_exists('App\\Models\\Company')) {
            return self::defaults();
        }

        $company = \App\Models\Company::query()->first();

        return $company ? self::fromCompany($company, $company->settings) : self::defaults();
    }

    public static function contact(object $contact): array
    {
        $company = $contact->company;
        $settings = $contact->client->getMergedSettings();

        return self::fromCompany($company, $settings);
    }

    private static function fromCompany(object $company, object $settings): array
    {
        $logo = null;

        try {
            $logo = $company->present()->logo($settings);
        } catch (\Throwable) {
            $logo = null;
        }

        return [
            'name' => $company->present()->name(),
            'logo' => $logo,
            'primary_color' => $settings->primary_color ?? '#1c64f2',
            'custom_css' => $settings->portal_custom_css ?? '',
            'font_url' => asset('css/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4gaVI.woff2'),
            'date_format' => method_exists($company, 'date_format') ? $company->date_format() : 'M j, Y',
            'time_format' => method_exists($company, 'time_format') ? $company->time_format() : 'g:i A',
        ];
    }

    private static function defaults(): array
    {
        return [
            'name' => 'Artist Ninja',
            'logo' => null,
            'primary_color' => '#1c64f2',
            'custom_css' => '',
            'font_url' => asset('css/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4gaVI.woff2'),
            'date_format' => 'M j, Y',
            'time_format' => 'g:i A',
        ];
    }
}
