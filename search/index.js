const querysearch = window.location.search;
const url = `https://waifu.api.ey.ax/search${querysearch}`;
var cdnurl = 'https://waifu.cdn.ey.ax/';

function get() {
    return new Promise(function (resolve, reject) {
        var req = new XMLHttpRequest();
        req.open('GET', url, true);
        req.responseType = 'json';
        req.onload = function () {
            if (req.status == 200) {
                resolve(req.response.images[0].url);
                imageUrl = cdnurl + req.response.images[0].image_id + req.response.images[0].extension
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