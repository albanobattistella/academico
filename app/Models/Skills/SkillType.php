<?php

namespace App\Models\Skills;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory(): \Database\Factories\SkillTypeFactory
    {
        return \Database\Factories\SkillTypeFactory::new();
    }
}
