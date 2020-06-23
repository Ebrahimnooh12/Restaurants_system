

function setCookeis(name) 
{

    var url = new URL(window.location.href);

    var query_string = url.search;

    var search_params = new URLSearchParams(query_string); 

    var id = search_params.get(name);

    
    if(id != null)
        document.cookie = name +"=" + id + ";";

}


setCookeis('d');










