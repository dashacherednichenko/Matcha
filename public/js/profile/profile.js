let choose_file = function (label_name) {
    document.getElementById(label_name).click();
};
let avatar = document.getElementById('avatar').src;
console.log('avatar', avatar);

if (avatar.indexOf('images/service/default_avatar.png') !== -1) {
    document.getElementById('delete_btn').hidden = true;
};

document.addEventListener('DOMContentLoaded', function() {



    let gallery = document.getElementsByClassName('usr_photo');
    console.log('gallery', gallery);
    let count = 1;
});