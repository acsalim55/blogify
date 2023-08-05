'use strict'

setTimeout(function () {
    if (!localStorage.getItem('auth_token') &&
        window.location.href.indexOf('signin.html') == -1
        && window.location.href.indexOf('signup.html') == -1
    ) {
        window.location.href = 'signin.html';
    }
}, 100);


var forms = document.querySelectorAll('.needs-validation')

forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
        event.preventDefault()
        event.stopPropagation()
        form.classList.add('was-validated')
        if (form.checkValidity()) {
            let obj = JSON.stringify(Object.fromEntries(new FormData(form).entries()), (key, value) => value ? value : undefined);

            if (form.getAttribute('id') == 'login-form') {
                fetch('http://localhost:8000/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: obj
                }).then(rep => rep.json())
                    .then(data => {
                        if (!data.token) {
                            document.querySelector('#login-error').classList.remove('d-none');
                        } else {
                            localStorage.setItem('auth_token', data.token);
                            window.location.href = 'index.html';
                        }
                    });
            }

            if (form.getAttribute('id') == 'register-form') {


                fetch('http://localhost:8000/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: obj
                }).then(rep => rep.json())
                    .then(data => {
                        if(!data.errors){
                            alert(data.message);
                            window.location.href = 'signin.html';
                        }
                    });

            }

            if (form.getAttribute('id') == 'blog-form') {

                fetch('http://localhost:8000/api/blogs', {
                    method: localStorage.getItem('blog') ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                    },
                    body: obj
                }).then(rep => rep.json())
                    .then(data => {
                        alert(data.message);
                        window.location.href = 'index.html';
                    });
            }
        }

    }, false)
});


let bloglist = document.querySelector('#blog-list');

function getBlogs() {
    if (bloglist) {
        bloglist.innerHTML = '';
        fetch('http://localhost:8000/api/blogs', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }

        }).then(rep => rep.json())
            .then(data => {

                data.forEach((blog) => {

                    bloglist.innerHTML += `
                    <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                        <small class="float-end text-navy"></small>
                        <strong>${blog.title}</strong> 
                        <br />
                        <small class="text-muted">
                        ${new Date(blog.created_at).toLocaleString({}, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' })}
                        </small>
                        <div class="border text-sm text-muted p-2 mt-1">
                            <p class="blog-content">${blog.content}</p>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="#" class="btn btn-sm btn-warning mt-1 edit-blog-button" data-blog='${JSON.stringify(blog)}' >
                                <i class="feather-sm" data-feather="trash-2"></i> Edit
                            </a>
                            <a href="#" class="btn btn-sm btn-danger mt-1 delete-blog-button" data-id-blog="${blog['_id']}">
                                <i class="feather-sm" data-feather="trash-2"></i> Delete
                            </a>
                        </div>
                    </div>
                    </div>
                    <hr />`
                });

                document.querySelectorAll('.edit-blog-button').forEach(x => {
                    x.addEventListener('click', function (e) {
                        e.preventDefault();
                        localStorage.setItem('blog', x.getAttribute('data-blog'));
                        window.location.href = 'blog.html';
                    });
                });

                document.querySelectorAll('.delete-blog-button').forEach(x => {
                    x.addEventListener('click', function (e) {
                        e.preventDefault();


                        fetch('http://localhost:8000/api/blogs/' + x.getAttribute('data-id-blog'), {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                            }
                        }).then(rep => rep.json()).then(data => {
                            alert(data.message);
                            getBlogs();
                        });

                    });
                });

            });
    }

}

window.onload = function () {
    if (localStorage.getItem('auth_token'))
        fetch('http://localhost:8000/api/auth/me', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        }).then(rep => rep.json()).then(data => {

                [...document.querySelectorAll('.user-name')].forEach(x => {
                    x.innerHTML = data.name + ' ' + data.surname;
                });

                [...document.querySelectorAll('.user-username')].forEach(x => {
                    x.innerHTML = data.username;
                });

                [...document.querySelectorAll('.user-email')].forEach(x => {
                    x.innerHTML = data.email;
                });

                localStorage.removeItem('blog');
            
            localStorage.setItem('user_id', data.id);
        });
    getBlogs();
}

const logoutbutton = document.querySelector('.logout-button');

if (logoutbutton)
    logoutbutton.addEventListener('click', function (e) {
        e.preventDefault();

        if (localStorage.getItem('auth_token')) {
            fetch('http://localhost:8000/api/auth/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
                }
            }).then(rep => rep.json()).then(data => {
                alert(data.message + ' \nYou will be redirected to login page');
                localStorage.clear();
                window.location.href = 'signin.html';
            });
        }
    });