
var rating = 0;

var stars = [];
for (i=0; i<5; i++) {
    let star = document.getElementById(`star${i}`);
    stars.push(star);
}

const onRatingHover = function() {
    const key = parseInt(this.getAttribute("key"));

    for(i=0; i<key+1; i++) {
        stars[i].src="/public/img/star-active.png"
    }
    for(i=key+1; i<5; i++) {
        stars[i].src="/public/img/star-inactive.png"
    }
}

const onRatingClick = function() {
    const key = parseInt(this.getAttribute("key"));
    if (rating == key+1) {
        rating = 0;
    } else {
        rating = key+1;
    }  
    document.getElementById("rating1").value = rating;
}

const onRatingOut = function() {
    if (rating == 0) {
        for (i=0; i<5;i++) {
            stars[i].src="/public/img/star-inactive.png"
        }
    } else {
        for (i=0; i<rating;i++) {
            stars[i].src="/public/img/star-active.png"
        }
        for (i=rating; i<5;i++) {
            stars[i].src="/public/img/star-inactive.png"
        }
    }
}

window.onload = function() {
    for (i=0; i<5; i++) {
        stars[i].onmouseover = onRatingHover;
        stars[i].onclick = onRatingClick;
        stars[i].onmouseout = onRatingOut;
    }
}

function validateForm() {
    var rate = document.forms["review"]["rating"].value;
    if (rate == 0) {
        alert("Rating can't be 0");
        return false;
    }

    var comment = document.forms["review"]["comment"].value;
    if (comment === "") {
        alert("Comment can't be empty");
        return false;
    }
}
