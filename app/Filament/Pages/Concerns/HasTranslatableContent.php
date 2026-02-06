<?php

namespace App\Filament\Pages\Concerns;

use App\Support\SpatieTranslatableContentDriver;
use Filament\Support\Contracts\TranslatableContentDriver;

trait HasTranslatableContent
{
    public ?string $activeLocale = null;

    public function mountHasTranslatableContent(): void
    {
        $this->activeLocale = app()->getLocale();
    }

    public function getActiveSchemaLocale(): ?string
    {
        return $this->activeLocale;
    }

    public function getActiveTableLocale(): ?string
    {
        return $this->activeLocale;
    }

    /**
     * @return class-string<TranslatableContentDriver>|null
     */
    public function getFilamentTranslatableContentDriver(): ?string
    {
        return SpatieTranslatableContentDriver::class;
    }
}
