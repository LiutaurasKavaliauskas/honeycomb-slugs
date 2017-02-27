<?php

use interactivesolutions\honeycombslugs\models\HCSlugs;

if (!function_exists('generateHCSlug')) {
    /**
     * Generating path based slug from string
     *
     * @param $path
     * @param $string
     * @param string $separator
     * @return string
     */
    function generateHCSlug($path, $string, $separator = '-')
    {
        $slug = str_slug($string, $separator);

        //TODO check if $path has '/' on both sides

        $record = HCSlugs::where('path', $path)->where('slug', $slug)->first();

        if (!$record) {
            HCSlugs::create([
                "path"       => $path,
                "slug"       => $slug,
                'slug_count' => 1
            ]);

            return $slug;
        }

        DB::table(HCSlugs::getTableName())->where('path', $path)->where('slug', $slug)->increment('slug_count');

        $slug .= $separator . $record->slug_count;

        return $slug;
    }
}