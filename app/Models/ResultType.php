<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ResultType extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];

    public array $translatable = ['name', 'description'];

    protected $appends = ['translated_name', 'translated_description'];

    public function getTranslatedNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }

    public function getTranslatedDescriptionAttribute()
    {
        return $this->getTranslation('description', app()->getLocale());
    }
}
