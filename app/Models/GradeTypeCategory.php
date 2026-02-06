<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class GradeTypeCategory extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'grade_type_categories';

    public $timestamps = false;

    protected $guarded = ['id'];

    public array $translatable = ['name'];

    protected $appends = ['translated_name'];

    public function getTranslatedNameAttribute()
    {
        return $this->getTranslation('name', app()->getLocale());
    }
}
