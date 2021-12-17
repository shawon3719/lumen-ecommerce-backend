<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function features()
    {
        return $this->hasMany(CategoryFeature::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public static function getCategoryLevel($category_id, $level = 0)
    {
        $category = self::find($category_id);

        if(!is_null($category->parent_id)) {
            $level++;
            return self::getCategoryLevel($category->parent_id, $level);
        } else {
            return $level;
        }
    }

    public static function getCategoryMenuTree($parent_id = null, &$output = [])
    {
        $categories = self::where('parent_id', $parent_id)->get();
        foreach ($categories as $category) {
            $arr = [
                'id' => $category->id,
                'title' => $category->title,
                'path' => ($category->children->count() > 0 ? '#' : '/' . $category->id . '/' . self::slugify($category->title)),
                'children' => []
            ];
            if($category->children->count() > 0) {
                self::getCategoryMenuTree($category->id, $arr['children']);
            }
            $output[] = $arr;
        }
        return $output;
    }
    public static function slugify($string, $separator = "-")
    {
        // Slug
        $string = mb_strtolower($string);
        $string = @trim($string);
        $replace = "/(\\s|\\" . $separator . ")+/mu";
        $subst = $separator;
        $string = preg_replace($replace, $subst, $string);

        // Remove unwanted punctuation, convert some to '-'
        $puncTable = [
            // remove
            "'"  => '',
            '"'  => '',
            '`'  => '',
            '='  => '',
            '+'  => '',
            '*'  => '',
            '&'  => '',
            '^'  => '',
            ''   => '',
            '%'  => '',
            '$'  => '',
            '#'  => '',
            '@'  => '',
            '!'  => '',
            '<' => '',
            '>'  => '',
            '?'  => '',
            // convert to minus
            '['  => '-',
            ']'  => '-',
            '{'  => '-',
            '}'  => '-',
            '('  => '-',
            ')'  => '-',
            ' '  => '-',
            ','  => '-',
            ';'  => '-',
            ':'  => '-',
            '/'  => '-',
            '|'  => '-',
            '\\' => '-',
        ];
        $string = str_replace(array_keys($puncTable), array_values($puncTable), $string);

        // Clean up multiple '-' characters
        $string = preg_replace('/-{2,}/', '-', $string);

        // Remove trailing '-' character if string not just '-'
        if ($string != '-') {
            $string = rtrim($string, '-');
        }

        return $string;
    }
}