<h1>Upcoming Events at the Salina Public Library</h1>
<ul id="evlist"></ul>

<script>
    const ul = document.getElementById('evlist');
    const list = document.createDocumentFragment();
<?php foreach($page->embed()->toStructure() as $links): ?>
    const url = '<?= $links->link() ?>'; 
<?php endforeach ?>        
    fetch(url) 
        .then((response) => { 
            return response.json(); 
        }) 
        .then((json) => { 
            json.map(function(evnt) { 
                let branchName = Object.values(evnt.branch)?.[0];
                let roomName = Object.values(evnt.room)?.[0];
                let li = document.createElement('li'); 
                let title = document.createElement('h2');
                let start_time = document.createElement('span');
                let start_date = document.createElement('span');
                let raw_date = `${evnt.start_date}`;
                let date = new Date(raw_date);
                let options_date = {  
                    weekday: "long", month: "long",  
                    day: "numeric"
                };
                let options_time = {  
                    hour: "numeric", minute: "2-digit"
                };

    title.innerHTML = `${evnt.title}` + " | " + `${branchName}` + " - " + `${roomName}`;

    start_date.innerHTML = date.toLocaleDateString("en-us", options_date);
    start_time.innerHTML = date.toLocaleTimeString("en-us", options_time);

    li.appendChild(title);
    li.appendChild(start_time).classList.add("time");;
    li.appendChild(start_date);
    list.appendChild(li);
    ul.appendChild(list);
});
})
.catch(function(error) {
console.log(error);
});
</script>