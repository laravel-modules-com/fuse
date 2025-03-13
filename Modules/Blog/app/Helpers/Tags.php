<?php

declare(strict_types=1);

namespace Modules\Blog\Helpers;

class Tags
{
    public static function get(string $string): string
    {
        // current year
        $string = str_replace('[year]', date('Y'), $string);

        // name of website
        $string = str_replace('[sitename]', config('app.name'), $string);

        // youtube embeds
        $string = preg_replace_callback("(\[youtube (.*?)])is", function (array $matches) {
            $params = self::clean($matches);

            // if key exits use it
            $video = $params[0];
            $width = ($params['width'] ?? '560');
            $height = ($params['height'] ?? '360');

            return "<iframe width='$width' height='$height' src='//www.youtube.com/embed/$video' frameborder='0' allowfullscreen></iframe>";
        }, $string);

        // youtube subscribe
        $string = preg_replace_callback("(\[youtubesub(.*?)])is", function ($matches) {
            $params = self::clean($matches);

            if (! isset($params['count'])) {
                $params['count'] = null;
            }

            $username = ($params['username'] ?? '');
            $layout = ($params['layout'] == 'full' ? 'full' : 'default');
            $count = ($params['count'] == 'no' ? 'hidden' : 'default');

            return "<script src='https://apis.google.com/js/platform.js'></script>
                <div class='g-ytsubscribe' data-channel='$username' data-layout='$layout' data-count='$count'></div>";
        }, $string);

        // vimeo embeds
        $string = preg_replace_callback("(\[vimeo (.*?)])is", function ($matches) {
            $params = self::clean($matches);

            // if key exits use it
            $video = ($params['video'] ?? '');
            $video = str_replace('https://vimeo.com/', '', $video);
            $width = (isset($params['width']) ? $params['width'] : '640');
            $height = (isset($params['height']) ? $params['height'] : '360');

            return "<iframe width='$width' height='$height' src='https://player.vimeo.com/video/$video' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
        }, $string);

        return $string;
    }

    /**
     * @param  array|string  $data<string,  string>
     * @return array<int|string, string>
     */
    private static function clean(array|string $data): array
    {
        // Check if $data is an array and extract the string to be processed.
        $stringToProcess = is_array($data) && isset($data[1]) ? $data[1] : $data;

        // Ensure that the stringToProcess is actually a string.
        if (! is_string($stringToProcess)) {
            // Handle error or return an empty array
            return [];
        }

        $parts = explode(' ', $stringToProcess);
        $params = [];

        foreach ($parts as $part) {
            if (! empty($part)) {
                if (str_contains($part, '=')) {
                    [$name, $value] = explode('=', $part, 2);
                    $value = self::removeCharsFromString($value);
                    $name = self::removeCharsFromString($name);
                    $params[$name] = $value;
                } else {
                    $params[] = self::removeCharsFromString($part);
                }
            }
        }

        return $params;
    }

    private static function removeCharsFromString(string $value): string
    {
        $search = ['http:', 'https:', '&quot;', '&rdquo;', '&rsquo;', '&nbsp;'];

        return str_replace($search, '', $value);
    }
}
