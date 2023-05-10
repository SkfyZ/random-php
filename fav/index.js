const querysearch = window.location.search;
const url = `https://api.waifu.im/fav${querysearch}`;
function get() {       
    return new Promise(function (resolve, reject) {      
        var req = new XMLHttpRequest();
        req.open('GET', url, true);
		req.setRequestHeader('Accept-Version','v5');
		req.setRequestHeader('Authorization', 'Bearer Zg0zr3zvgE6Uh2FZiL9s5AQWno9en8RESfOPMH7hQicgxylPv6xxLbqnnuXC7bmogVdDVJgzlLFeu519zjw5LRGiYBiMdybkEwniYGrX4BugbNgql1VAlyzmpKIkr3pxRQKEcB6g36czybziCgv_2aGP1ypsfQ3_VF2IdInarMw');
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