<?php 
    $url = $_SERVER['REQUEST_URI'];

    // orientation can be passed by snippet if the inclusion
    // Is embeded into the page (see opac page for example)
    // Otherwise, it determines orientation by looking at the URL
    if(strpos($url, 'portrait')) {
        $orientation = 'portrait';
    } elseif(strpos($url, 'landscape')){
        $orientation = 'landscape';
    }

    // Fetches the selected gallery based on the campaign page
    // then filters the gallery based on the selected tags.
    $gallery = $page->gallery()
					->toPages()
                    ->files()
                    ->filterBy('tags', 'in', $page->tags()->split(','), ',')
                    ->filter(function($file) use($orientation) {
                        // orientation match
                        if($orientation && $file->orientation() != $orientation) {
                            return false;
                        }
                    // Filters the images to only show ones that appear between
                    // the campaigns start and end date
                    $today = date('Y-m-d');
                    return $file->expire()->toDate('Y-m-d') > $today
                        && $file->start()->toDate('Y-m-d') <= $today;
    });

    // Queries the children of slideshows for templates matching lst-web,
    // it then filters the pages based on the selected tags. The error page
    // will never be selected as it does not have any set tags and is unlisted.
    $webslides = page('slideshows')
                    ->children()
                    ->listed()
                    ->filterBy('template', '*', '/^lst-web/')
                    ->filterBy('tags', 'in', $page->tags()->split(','), ',');

    $webslides = $webslides->filter(function ($webslide) {
        // Filters the webslides to only show ones that appear between
        // the campaigns start and end date
        $today = date('Y-m-d');
        return $webslide->expire()->toDate('Y-m-d') > $today
            && $webslide->start()->toDate('Y-m-d') <= $today;
    });

    // Creates an empty array then assembles the slides into strings
    // then assembles the html and outputs the result into the array.
    $slides = array();
    $class = 'class="carousel-cell ad" style="background-image:url(';
    foreach($gallery as $file) {
        // Images
        if($file->type() === 'image') {
            $url = $file->orientation() === 'portrait'
                ? $file->resize(null, 1080)->url()
                : $file->resize(1080, null)->url();

            $link = $file->link()->isNotEmpty()
                ? ' href="' . $file->link()->url() . '"'
                : '';

            $slides[] = "<a{$link} {$class}{$url})\"></a>";
        }
        // Videos
        elseif($file->type() === 'video') {
            $slides[] = sprintf(
                '<video autoplay muted loop class="carousel-cell"><source src="%s"></video>',
                $file->url()
            );
        }
    }

    foreach ($webslides as $webslide){
        $string = '<iframe class="carousel-cell" src="';
        $string .= $webslide->url();
        $string .= '" scrolling="no"></iframe>';
        array_push($slides, $string);
    }    

    // if the slides array is empty, throws error slide
    if (empty($slides)) {
        $errUrl   = $site->page('slideshows/web-slide-error')->url();
        $slides[] = "<iframe class=\"carousel-cell\" src=\"{$errUrl}\" scrolling=\"no\"></iframe>";
    }
    // Sorts the sides (random) and then prints each slide into html
    shuffle($slides);
    echo implode("\n", $slides);

?>
