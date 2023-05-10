function get() {       
    return new Promise(function (resolve, reject) {      
        var req = new XMLHttpRequest();
        req.open('GET', 'https://api.waifu.im/search?orientation=LANDSCAPE&is_nsfw=true', true);
		req.responseType = 'json';
        req.onload = function () {
            if (req.status == 200) {
                resolve(req.response.images[0].url);
				imageUrl = req.response.images[0].url
            } else {
                reject(Error(req.statusText));
            }
        };
        req.onerror = function () {
            reject(Error("Network Error"));
        };
        req.send();
    });
}

get().then(function (response) {
window.location.replace(imageUrl); 
}, function (error) {
    console.error("Failed!", error);
}); 