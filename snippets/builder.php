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
                    ->images()
                    ->filterBy('tags', 'in', $page->tags()->split(','), ',');
    
    // Filters images further by orientation
    $gallery = $gallery->filter(function ($image) use ($orientation) {
        return $image->orientation() == $orientation;
    });

    // Filters the images to only show ones that appear between
    // the campaigns start and end date
    $gallery = $gallery->filter(function ($image) {
        return 
            $image
                ->expire()
                ->toDate('Y-m-d') > date('Y-m-d')
            &&
            $image
                ->start()
                ->toDate('Y-m-d') <= date('Y-m-d');
    });

    // Fetches the selected video gallery based on the campaign page
    // then filters the gallery based on the selected tags.
    $videos = page('videogalleries')
                   ->children()
                   ->videos()
                   ->filterBy('tags', 'in', $page->tags()->split(','), ',');

    // Filters videos further by orientation
    $videos = $videos->filter(function ($video) use ($orientation) {
        return $video->orientation() == $orientation;
    });

    // Filters the videos to only show ones that appear between
    // the campaigns start and end date
    $videos = $videos->filter(function ($video) {
        return 
            $video
                ->expire()
                ->toDate('Y-m-d') > date('Y-m-d')
            &&
            $video
                ->start()
                ->toDate('Y-m-d') <= date('Y-m-d');
    });

    // Queries the web-slides page and gets an array of it's child pages,
    // it then filters the pages based on the selected tags. The error page
    // will never be selected as it does not have any set tags.
    $webslides = page('web-slides')
                    ->children()
                    ->listed()
                    ->filterBy('tags', 'in', $page->tags()->split(','), ',');

    $webslides = $webslides->filter(function ($webslide) {
        return
            $webslide
                ->expire()
                ->toDate('Y-m-d') > date('Y-m-d')
            &&
            $webslide
                ->start()
                ->toDate('Y-m-d') <= date('Y-m-d');
    });

    // Creates an empty array then assembles the slides into strings
    // then assembles the html and outputs the result into the array.
    $slides = array();
    $class = 'class="carousel-cell ad" style="background-image:url(';
    foreach ($gallery as $image){
        $string = "<a ";
        if ($image->link()->isNotEmpty()){
            $string .= "href={$image->link()->url()} ";
        }
        $string .= $class;
        if($image->orientation() == 'portrait'){
            $string .= $image->resize(null, 1080)->url();
        }
        else { 
            $string .= $image->resize(1080, null)->url();
        }
        $string .= ')"></a>';
        array_push($slides, $string);
    }

    foreach ($videos as $file){
        $string = '<video autoplay muted loop> <source src="';
        $string .= $file->url();
        $string .= '"></video>';
        array_push($slides, $string);
    }

    foreach ($webslides as $webslide){
        $string = '<iframe class="carousel-cell" src="';
        $string .= $webslide->url();
        $string .= '" scrolling="no"></iframe>';
        array_push($slides, $string);
    }    

    // Counts the number of slides in the array, if it's zero, throws error slide 
    if (count($slides) <= 0){
        $string = '<iframe class="carousel-cell" src="';
        $string .= $site->page('web-slides/error-slide')->url();
        $string .= '" scrolling="no"></iframe>';
        array_push($slides, $string);
    }
    // Sorts the sides (random) and then prints each slide into html
    shuffle($slides);
    foreach($slides as $slide){
        echo $slide . "\n";
    }
    
?>
