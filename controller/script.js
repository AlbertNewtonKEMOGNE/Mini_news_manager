document.getElementById('add_news_btn').addEventListener("click", function() {

    var id_news = document.getElementById('id_news').value;
    var title = document.getElementById('title').value;
    var content = document.getElementById('content').value;
    var action = localStorage.getItem('action');
    var id_author = document.getElementById('author').value;

    if (parseInt(id_author) == -1) {
        alert('please select author');
    } else {
        $.ajax({
            type: "POST",
            url: '../controller/news_threatment.php',
            data: {
                id_news: id_news,
                title: title,
                content: content,
                id_author: id_author,
                action: action
            },
            success: function(res) {
                alert(res)
                window.location = '../view/';
                localStorage.setItem('action', 'addNews');
            }
        });
    }

});
// document.getElementById('cancel_news_btn').addEventListener("click", function() {

//     document.getElementById('id_news').value = '';
//     document.getElementById('title').value = '';
//     document.getElementById('content').value = '';
//     localStorage.setItem('action', 'addNews');
// });

let load = () => {
    $.ajax({
        type: "POST",
        url: '../controller/news_threatment.php',
        data: {
            id_news: null,
            title: null,
            content: null,
            id_author: null,
            action: 'getNewsList'
        },
        success: function(response) {
            loadNews(response)
        }
    });
}
let loadNews = (news) => {
    //news = JSON.stringify(news)
    // alert(news[0])
    // news = JSON.parse(news)
    // alert(news)
    // alert(news[0])
    // news_res = JSON.parse(news[0])
    // alert(news_res['id_news'])
    news = JSON.parse(news)

    //alert(Object.keys(news))
    size = news.length

    //alert(size)

    if (localStorage.getItem('is_admin') == 'yes') {

        localStorage.setItem('action', 'addNews');

        document.getElementsByClassName('admin_section')[0].classList.add("visible");
        document.getElementsByClassName('recents_news')[0].classList.add("not_visible");
        document.getElementsByClassName('more_news')[0].classList.add("not_visible");
        document.getElementById('go_to_admin_btn').value = ' View as simple user ';
        document.getElementById('go_to_admin_text').textContent = '';

        for (var i = 0; i < size; i++) {
            news_res = JSON.parse(news[i]) //news_res['is_published']//id_news, title, content, author_name, is_published, id_author
            var _published = parseInt(news_res['is_published']) == 0 ? 'publish' : 'unpublish'
            var front_check = parseInt(news_res['is_published'])
            $('.news_list_table_body').append(`
                <tr>
                    <td>` +
                news_res['id_news'] +
                `</td>
                    <td>` +
                news_res['title'] +
                `</td>
                    <td class="news_list_content"><input type="button" id="news_content" onclick="viewNewsContent(this.dataset.id_news, this.dataset.id_author)" value="click to see..."data-id_news = "` +
                news_res['id_news'] +
                `" data-id_author = "` +
                news_res['id_author'] +
                `"></td>
                    <td>` +
                news_res['author_name'] + `</td>
                    <td>
                        <div class="drop_down_content">
                            <input type="button" value="` +
                _published + `" id="` +
                _published + `_btn" onclick="publishNews(this.dataset.id_news, this.dataset.id_author, this.dataset.front_check)" data-id_news = "` +
                news_res['id_news'] +
                `" data-id_author = "` +
                news_res['id_author'] +
                ` " data-front_check = "` +
                front_check +
                `">
                            <input type="button" value="delete" id="delete_btn" onclick="deleteNews(this.dataset.id_news, this.dataset.id_author)" data-id_news = "` +
                news_res['id_news'] +
                `" data-id_author = "` +
                news_res['id_author'] +
                `">
                            <input type="button" value="update" id="update_btn" onclick="updateNews(this.dataset.id_news, this.dataset.id_author)" data-id_news = "` +
                news_res['id_news'] +
                `" data-id_author = "` +
                news_res['id_author'] +
                `">
                            
                        </div>
                    </td>
            </tr>
            `);
        }
        $.ajax({
            type: "POST",
            url: '../controller/news_threatment.php',
            data: {
                id_news: null,
                title: null,
                content: null,
                id_author: null,
                action: 'getAuthors'
            },
            success: function(response) {
                // alert(response)
                // response = JSON.parse(response)
                // alert(response[0])
                authors = JSON.parse(response)
                authors_length = authors.length
                    // alert(authors[0])
                for (var j = 0; j < authors_length; j++) {

                    authors_res = JSON.parse(authors[j]) //authors_res['id_author']//id_author, author_name

                    // alert(authors_res['id_author'])
                    $('.select_options').append(`
                        <option value="` +
                        authors_res['id_author'] + `">` +
                        authors_res['author_name'] + `</option>
                    `);
                }
            }
        });
    } else {
        document.getElementsByClassName('recents_news')[0].classList.remove("not_visible"); //more_news
        document.getElementsByClassName('more_news')[0].classList.remove("not_visible");
        document.getElementsByClassName('admin_section')[0].classList.remove("visible");
        document.getElementById('go_to_admin_btn').value = ' View as admin ';
        document.getElementById('go_to_admin_text').textContent = 'For more actions ( create, read, update, delete news, authors and published news ), view it as admin';

        var j = 0;
        // alert(news[size - 1])
        // alert(size)
        for (var i = size - 1; i >= 0; i--) {
            news_res = JSON.parse(news[i])
                // alert(news_res['id_author'])
            var published = parseInt(news_res['is_published']) == 0 ? false : true
            if (published && (j < 5)) {
                content = news_res['content'] != undefined ? news_res['content'].substring(0, 200) : null
                $('.recents_news').prepend(`
                    <div class="news_card">
                        <input type="hidden" name="" id="news_id">
                        <div class="news_header">
                            <h1>` +
                    news_res['author_name'] + `</h1>
                            <input type="button" title="Read more on this..." value="` +
                    news_res['title'] +
                    `" onclick="viewNewsContent(this.dataset.id_news, this.dataset.id_author)" data-id_news = "` +
                    news_res['id_news'] +
                    `" data-id_author = "` +
                    news_res['id_author'] +
                    `">
                        </div>
                        <p>` +
                    content + `
                        ...</p>
                    </div>
                `);
                j++
            }
        }
    }
}
let publishNews = (id_news, id_author, front_check) => {

    if (parseInt(front_check) == 0) {

        $.ajax({
            type: "POST",
            url: '../controller/news_threatment.php',
            data: {
                id_news: id_news,
                title: null,
                content: null,
                id_author: id_author,
                action: 'publishNews'
            },
            success: function(res) {
                window.location = '../view/';
                localStorage.setItem('action', 'addNews');
            }
        });

    } else {

        $.ajax({
            type: "POST",
            url: '../controller/news_threatment.php',
            data: {
                id_news: id_news,
                title: null,
                content: null,
                id_author: id_author,
                action: 'unPublishNews'
            },
            success: function(res) {
                window.location = '../view/';
                localStorage.setItem('action', 'addNews');
            }
        });

    }


}
let deleteNews = (id_news, id_author) => {

    $.ajax({
        type: "POST",
        url: '../controller/news_threatment.php',
        data: {
            id_news: id_news,
            title: null,
            content: null,
            id_author: id_author,
            action: 'deleteNews'
        },
        success: function(res) {
            window.location = '../view/';
            localStorage.setItem('action', 'addNews');
        }
    });
}
let updateNews = (id_news, id_author) => {

    var action = localStorage.getItem('action');

    if (action == 'addNews') {
        $.ajax({
            type: "POST",
            url: '../controller/news_threatment.php',
            data: {
                id_news: id_news,
                title: null,
                content: null,
                id_author: id_author,
                action: 'preUpdateNews'
            },
            success: function(response) {

                news = JSON.parse(response)
                news_length = news.length
                    // alert(news[0])
                    // id_news, title, content, author_name, id_author
                    //alert(news)
                news = JSON.parse(news[0])
                    //alert(news['id_news'])
                id_news = news['id_news']
                title = news['title']
                content = news['content']
                author_name = news['author_name']
                id_author = news['id_author']

                document.getElementById('id_news').value = id_news;
                document.getElementById('title').value = title;
                document.getElementById('content').value = content;
                document.getElementById('author').value = id_author;

                document.getElementById('id_news').disabled = true;

                localStorage.setItem('action', 'updateNews');
            }
        });
    } else if (action == 'updateNews') {
        var id_news = document.getElementById('id_news').value;
        var title = document.getElementById('title').value;
        var content = document.getElementById('content').value;
        var action = localStorage.getItem('action');
        var id_author = document.getElementById('author').value;

        $.ajax({
            type: "POST",
            url: '../controller/news_threatment.php',
            data: {
                id_news: id_news,
                title: title,
                content: content,
                id_author: id_author,
                action: 'updateNews'
            },
            success: function(res) {
                alert(res)
                window.location = '../view/';
                localStorage.setItem('action', 'addNews');
            }
        });
    }
}
let viewNewsContent = (id_news, id_author) => {
    document.getElementsByClassName('show_news_content')[0].classList.add("active");
    $.ajax({
        type: "POST",
        url: '../controller/news_threatment.php',
        data: {
            id_news: id_news,
            title: null,
            content: null,
            id_author: id_author,
            action: 'getUnique'
        },
        success: function(response) {

            news = JSON.parse(response)
            news_length = news.length
                // alert(news[0])
                // id_news, title, content, author_name, id_author
                //alert(news)
            news = JSON.parse(news[0])
                //id_news, title, content, author_name, id_author, publish_date, updating_date
            title = news['title']
            content = news['content']
            author_name = news['author_name']
            publish_date = news['publish_date']
            updating_date = news['updating_date']

            document.getElementById('news_title_message').textContent = 'Title : ' + title;
            document.getElementById('news_content_message').textContent = 'Content : ' + content;
            document.getElementById('news_author_message').textContent = 'Author : ' + author_name;
            document.getElementById('news_publish_message').textContent = 'Published date : ' + publish_date;
            document.getElementById('news_update_message').textContent = 'Last Update : ' + updating_date;

            localStorage.setItem('action', 'addNews');
        }
    });
}
let search = () => {
    $.ajax({
        type: "POST",
        url: '../controller/news_threatment.php',
        data: {
            id_news: null,
            title: null,
            content: null,
            id_author: null,
            action: 'getNewsList'
        },
        success: function(response) {
            loadNews(response)
        }
    });
}