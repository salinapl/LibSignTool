<?php 

return function ($page, $site) {

    // determine orientation by looking at the URL
    $orientation = get('orientation');

    // Check if a rotation of the slides is requested.
    $rotate = get('rotate');

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
            $slideTags  = array_unique(
                            array_merge($pageTags, $eventTags)
                        );
            $filterTags = array_unique(
                            array_merge($pageTags, $eventTags, [$dayTag])
                        );
            $pages      = $page->gallery()->toPages();
        } else {
            $slideTags  = $eventTags;
            $filterTags = array_unique(
                            array_merge($eventTags, [$dayTag])
                        );
            $pages = $activeEvent->orgallery()->isNotEmpty()
                    ? $activeEvent->orgallery()->toPages()
                    : $page->gallery()->toPages();
        }

        $delay          = $activeEvent->ordelay()->isNotEmpty()
                            ? $activeEvent->ordelay()
                            : $page->delay();
        
    } else {
        $slideTags      = $pageTags;
        $filterTags     = array_unique(array_merge($slideTags, [$dayTag]));
        $delay          = $page->delay();
        $pages          = $page->gallery()->toPages();
    }

    $sourceFiles = $pages->files();

    // Fetches the selected gallery based on the campaign page
    // then filters the gallery based on the selected tags.
    $gallery = $sourceFiles
                    ->filterBy('tags', 'in', $filterTags, ',')
                    ->filter(function($file) use($orientation, $now, $dayTag, $slideTags) {
                        // orientation match
                        if($orientation && $file->orientation() != $orientation) {
                            return false;
                        }
                    // Filters the images to only show ones that appear between
                    // the campaigns start and end date
                    $slidestart = new DateTime($file->start());
                    $slideend = new DateTime($file->expire());
                    if(!($slideend > $now && $slidestart <= $now)) {
                        return false;
                    }

                    // If it's a reccuring (day-tag) slide, it must also share
                    // at least one of the set slideshow tags.
                    $fileTags = $file->tags()->split(',');
                    if (in_array($dayTag, $fileTags, true)) {
                        $common = array_intersect($fileTags, $slideTags);
                        if (empty($common)) {
                            return false;
                        }
                    }

                    return true;
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
    //Build rotate class
    $rotate = get('rotate') ? (int)get('rotate') : 0;
    $rotateClass = '';
    if ($rotate > 0) {
        $rotateClass = $orientation . '-' . $rotate;
    }
    $bgimage = 'style="background-image:url(';
    foreach($gallery as $file) {
    
        // Images
        if($file->type() === 'image') {
            $url = $file->orientation() === 'portrait'
                ? $file->resize(null, 1080)->url()
                : $file->resize(1080, null)->url();

            // Link logic
            $linkStart = '';
            $linkEnd   = '';
            if ($file->link()->isNotEmpty()) {
                $href = $file->link()->url();
                $linkStart = '<a href="' . $href . '" target="_blank">';
                $linkEnd   = '</a>';
            }

            // Output structure:
            // <div class="carousel-cell">
            //     <a><img class="image-inner landscape-90" src="..."></a>
            // </div>
            $slides[] =
                '<div class="carousel-cell">' .
                    $linkStart .
                        '<img class="image-inner ' . $rotateClass . '" src="' . $url . '">' .
                    $linkEnd .
                '</div>';
        }
        // Videos
        elseif($file->type() === 'video') {

            $slides[] =
                '<div class="carousel-cell">' .
                    '<video class="video-inner ' . $rotateClass . '" autoplay muted loop>' .
                        '<source src="' . $file->url() . '">' .
                    '</video>' .
                '</div>';

        }
    }

    foreach ($webslides as $webslide){
       
        $slides[] =
        '<div class="carousel-cell">' .
            '<iframe class="iframe-inner ' . $rotateClass . '" src="' . $webslide->url() . '"></iframe>' .
        '</div>';
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
        'delay'     => $delay,
        'rotate'    => $rotate
    ];
};

?>
