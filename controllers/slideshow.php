<?php 

return function ($page, $site) {

    // determine orientation by looking at the URL
    $orientation = get('orientation');

    // Grab the current time and check for an active event
    $now = new DateTime();

    // Set active event to null, then check the events table for an event
    // Set an event period to active event if it falls between the start/end
    $activeEvent = null;
    foreach ($page->events()->toStructure() as $event) {
        $start  = new DateTime($event->start());
        $end    = new DateTime($event->expire());

        if($start <= $now && $now < $end) {
            $activeEvent = $event;
            break;
        }
    }

    // Pulls day of the week and the page tags for use in append/recurring
    // tag operations below
    $dayTag = strtolower(date('l'));
    $pageTags = $page->tags()->split(',');

    // Chose tags, delay, and gallery based on event or normal status
    // Check if append flag is set, and locate event and normal tags
    // Append event tags to normal tags if set, else replace tags
    if($activeEvent){
        $append         = $activeEvent->append()->bool();
        $eventTags      = $activeEvent->ortags()->split(',');
        if ($append) {
            $filterTags     = array_unique(
                                array_merge($pageTags, $eventTags, [$dayTag])
                            );
            $pages          = $page->gallery()->toPages();
            $sourceFiles    = $pages->files();
        } else {
            $filterTags = $eventTags;
            $pages = $activeEvent->orgallery()->isNotEmpty()
                    ? $activeEvent->orgallery()->toPages()
                    : $page->gallery()->toPages();
            $sourceFiles = $pages->files();
        }

        $delay          = $activeEvent->ordelay()->isNotEmpty()
                            ? $activeEvent->ordelay()
                            : $page->delay();
        
    } else {
        $filterTags     = array_unique(array_merge($pageTags, [$dayTag]));
        $delay          = $page->delay();
        $pages          = $page->gallery()->toPages();
        $sourceFiles    = $pages->files();
    }

    // Fetches the selected gallery based on the campaign page
    // then filters the gallery based on the selected tags.
    $gallery = $sourceFiles
                    ->filterBy('tags', 'in', $filterTags, ',')
                    ->filter(function($file) use($orientation, $now) {
                        // orientation match
                        if($orientation && $file->orientation() != $orientation) {
                            return false;
                        }
                    // Filters the images to only show ones that appear between
                    // the campaigns start and end date
                    $slidestart = new DateTime($file->start());
                    $slideend = new DateTime($file->expire());
                    return $slideend > $now
                        && $slidestart <= $now;
    });

    // Queries the children of slideshows for templates matching lst-web,
    // it then filters the pages based on the selected tags. The error page
    // will never be selected as it does not have any set tags and is unlisted.
    $webslides = page('slideshows')
                    ->children()
                    ->listed()
                    ->filterBy('template', '*', '/^lst-web/')
                    ->filterBy('tags', 'in', $filterTags, ',')
                    ->filter(function($webslide) use($now){
                        $webstart = new DateTime($webslide->start());
                        $webend = new DateTime($webslide->expire());
                        return $webend > $now && $webstart <= $now;
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
                ? ' href="' . $file->link()->url() . '"' . 'target="_blank"'
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

    // Expose slides and delay time to template
    return [
        'slides'    => $slides,
        'delay'     => $delay
    ];
};

?>
