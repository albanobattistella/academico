<?php

namespace App\Models\Skills;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SkillScale extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];

    public array $translatable = ['shortname', 'name'];

    protected $appends = ['scale_name'];

    public function getScaleNameAttribute()
    {
        return $this->name;
    }

    protected static function newFactory(): \Database\Factories\SkillScaleFactory
    {
        return \Database\Factories\SkillScaleFactory::new();
    }
}
