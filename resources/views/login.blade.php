@extends('layouts.main')
@section('title','Shuttle Bus System')
@section('content')
    <section class="columns is-centered mt-3 mb-3">
      <div class="column is-4 box pl-5 pr-5">
          <img src="{{asset('img/shuttle-bus-logo.png')}}" width="90%" style="margin-left: 5%;">
          <h1 class="is-size-2 has-text-centered mb-3">School Shuttle Bus System</h1>
          <form class="" id="Login Box">
          <div class="field">
            <label class="label is-size-5 has-font-weight-normal">Username</label>
            <div class="control">
              <input id="username" class="input is-medium" type="text" placeholder="e.g. yousername">
            </div>
          </div>
          <div class="field">
            <label class="label is-size-5 has-font-weight-normal">Password</label>
            <div class="control">
              <input id="password" class="input is-medium" type="password" placeholder="e.g. •••••••••••••">
            </div>
          </div>
        </form>
          <button class="button is-primary mt-3" id="login_button"><strong>Log in</strong>&nbsp;&nbsp;<i class="fas fa-sign-in-alt"></i></button>
      </div>
    </section>
    <style type="text/css">
      html {
        background-color: #eee;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js" integrity="sha256-JLmknTdUZeZZ267LP9qB+/DT7tvxOOKctSKeUC2KT6E=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function login(event){
        event.target.classList.add('is-loading');
        let username = document.getElementById('username').value
        let password = document.getElementById('password').value
        axios
            .post("https://mp-authentication-server.herokuapp.com/admin/login",
                {"adminID":document.getElementById('username').value,"password":document.getElementById('password').value},
                {headers: {"Content-type":"application/json"}},
            )
            .then(function(response){
                if(!response.data.error){
                    window.localStorage.setItem("usu_access_token", response.data.data.accessToken);
                    window.localStorage.setItem("usu_refresh_token", response.data.data.refreshToken);
                    window.localStorage.setItem("usu_username", username);
                    window.localStorage.setItem("usu_password", password);
                    window.location.href = "{{route('app.dashboard')}}";
                }
            });
        }
        document.getElementById('login_button').addEventListener('click',login);

        /*
        curl -H "Accept: application/json"
        -H "Content-type: application/json"
        --request POST 'https://mp-authentication-server.herokuapp.com/admin/login'
        --data-raw '{"adminID":1801488,"password":"password"}'
        */
    </script>
@endsection
