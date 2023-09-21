let refresh = () => {
    window.location = '../view/index.html';
}
let go_to_admin_btn = () => {
    if (localStorage.getItem('is_admin') == 'no') {
        document.getElementsByClassName('popup')[0].classList.add("active");
    } else {
        localStorage.setItem('is_admin', 'no')
        refresh()
    }

}
let pop_btn = () => {
    document.getElementsByClassName('popup')[0].classList.remove("active");
}
let admin_btn = () => {
    var admin_login = (document.getElementById('admin_login').value).toLowerCase();
    var admin_password = document.getElementById('admin_password').value;

    if ((admin_login == 'albert') && (admin_password == '@ank0123')) {
        localStorage.setItem('is_admin', 'yes')
        refresh()
    } else { alert('Failed to login as admin !') }
    document.getElementsByClassName('popup')[0].classList.remove("active");
}
let content_btn = () => {
    document.getElementsByClassName('show_news_content')[0].classList.remove("active");
}