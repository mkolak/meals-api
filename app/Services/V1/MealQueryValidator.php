<?php

namespace App\Services\V1;

use Exception;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;

class MealQueryValidator
{
    protected static $allowedParameters = [
        'category',
        'tags',
        'page',
        'per_page',
        'lang',
        'with',
        'diff_time'
    ];

    public static function validate(Request $request)
    {
        $query = $request->query();
        foreach ($query as $param => $val) {
            if (!in_array(strtolower($param), self::$allowedParameters)) {
                throw new Exception('Unknown parameter: ' . $param);
            }

            if ($param == 'category') self::validateCategory($val);
            else if ($param == 'tags') self::validateTags($val);
            else if ($param == 'with') self::validateWith($val);
            else if ($param == 'lang') self::validateLang($val);
            else if ($param == 'diff_time') self::validateDiffTime($val);
        }
    }

    private static function validateCategory($id)
    {
        if (strtolower($id) == 'null' || strtolower($id) == '!null') return;
        if (!Category::find($id)) throw new Exception('Invalid category: ' . $id);
    }

    private static function validateTags($id)
    {
        $ids = explode(',', $id);
        if (!Tag::find($ids)) throw new Exception('Invalid tag');
    }

    private static function validateWith($with)
    {
        $fields = explode(',', $with);
        foreach ($fields as $field) {
            if (!in_array($field, ['tags', 'category', 'ingredients'])) throw new Exception('Invalid field selected: ' . $field);
        }
    }

    private static function validateLang($lang)
    {
        if (!in_array($lang, Language::pluck('locale')->toArray())) throw new Exception('Invalid language: ' . $lang);
    }

    private static function validateDiffTime($diff_time)
    {
        if (intval($diff_time) <= 0) throw new Exception('Invalid diff_time');
    }
}
