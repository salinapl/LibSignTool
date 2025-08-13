<?php

return function($page) {

    $feedUrl = $page->embed();
    // $feedFlags = $page->feedflags();
    // $jsonUrl = $feedUrl . $feedFlags;

    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "$feedUrl",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET"
    ]);

    $jsonFull = curl_exec($curl);
    
    // Decodes, cleans up, then rebuilds the json array
    function rebuildArray($json, $page) {
        
        // List of keys to keep in the array then 
        // flip array so keys not in array are removed
        $keptKeys = [
            'title', 
            'start_date', 
            'end_date', 
            'branch',
            'room',
            'moderation_state'
        ];
        $keptKeys = array_flip($keptKeys);

        // Pull in the array from the website
        $jsonArray = json_decode($json, true);

        foreach ($jsonArray as &$item) {
            $item['branch'] =
                isset($item['branch']) && is_array($item['branch'])
                ? reset($item['branch'])
                : ($item['branch'] ?? '');
            $item['room'] =
                isset($item['room']) && is_array($item['room'])
                ? reset($item['room'])
                : ($item['room'] ?? '');
        }
        unset($item);

        // Filter out cancelled events from the array and reset array index
        $jsonArray = array_values(
            array_filter(
                $jsonArray, 
                fn($item) => ($item['moderation_state'] ?? null) !== 'cancelled'
            )
        );
        $jsonArray = array_map(
            fn(array $row) => array_intersect_key($row, $keptKeys),
            $jsonArray
        );

        unset($item);
        
        // Prep today and tommorow variables
        $today = new DateTime();
        $tomorrow = (clone $today)->modify('+1 day');
        $todayName = $today->format('l');
        $tomorrowName = $tomorrow->format('l');
        
        $eventsArray = $jsonArray;
        return $eventsArray;
    }
    
    $arrayReady = rebuildArray($jsonFull, $page);

    return [
        'arrayReady' => $arrayReady
    ];
};

?>
