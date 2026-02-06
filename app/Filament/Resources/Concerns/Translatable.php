<?php

namespace App\Filament\Resources\Concerns;

use Spatie\Translatable\HasTranslations;

trait Translatable
{
    /**
     * @return array<string>
     */
    public static function getTranslatableAttributes(): array
    {
        $model = static::getModel();

        if (! method_exists($model, 'getTranslatableAttributes')) {
            throw new \Exception("Model [{$model}] must use trait [".HasTranslations::class.'].');
        }

        $attributes = app($model)->getTranslatableAttributes();

        if (! count($attributes)) {
            throw new \Exception("Model [{$model}] must have [\$translatable] properties defined.");
        }

        return $attributes;
    }

    /**
     * @return array<string>
     */
    public static function getTranslatableLocales(): array
    {
        return config('app.translatable_locales', ['en', 'es', 'fr']);
    }

    public static function getDefaultTranslatableLocale(): string
    {
        return static::getTranslatableLocales()[0];
    }
}
