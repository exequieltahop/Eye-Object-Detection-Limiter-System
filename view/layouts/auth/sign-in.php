<?php
    require __DIR__.'/../../../middleware/metainance.php';
?>
<section class="container d-grid vh-100" style="place-items: center;">
    <!-- form -->
    <form class="w-100 p-5 border rounded shadow" style="max-width: 600px;" id="form_sign_in">
        <h3>Sign In</h3>
        <hr>

        <!-- username -->
        <input type="text" name="username" id="username" placeholder="Username" class="form-control mb-3" autocomplete="name" required>
        
        <!-- password -->
        <input type="password" name="password" id="password" class="form-control mb-3" placeholder="Password" autocomplete="current-password" minlength="8" required>

        <!-- shot hide password -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <input type="checkbox" id="ShowPassword">
                <label for="ShowPassword" style="font-size: 0.9rem;">Show Password</label>
            </div>
        </div>

        <!-- btn -->
        <button class="btn btn-primary w-100" type="submit" id="btn_signin">Sign In</button>
    </form>
    
    <!-- script -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            // show password
            document.getElementById('ShowPassword').onchange = function(e){
                const pass = document.getElementById('password');

                if(e.target.checked){
                    pass.type = 'text';
                }else{
                    pass.type = 'password';
                }
            };

            // submit
            document.getElementById('form_sign_in').onsubmit = function(e){
                e.preventDefault();

                const formData = new FormData(e.target);
                // const url = './controller/auth/sign-in.php';
                const url = 'https://eyedetection-6aad0-default-rtdb.asia-southeast1.firebasedatabase.app/';
                const btn_login = document.getElementById('btn_signin');

                const username = formData.get('username');
                const password = formData.get('password');
                
                btn_login.disabled = true;
                alertify.set('notifier','position', 'top-left');
                
                // log in
                LOGIN(url, formData)
                .then(response => response.json())
                .then(response => {
                    if(response == null){
                        throw new Error("Wrong Username");
                    }

                    if(formData.get('password') != response.password){
                        throw new Error("Wrong Password");
                    }
                    
                    alertify.success("Successfully Log In");
                    btn_login.textContent = "Redirecting..."
                    btn_login.disabled = false;
                    
                    // set session variables
                    <?php 
                        PutSesssionArray([
                            'HasLog' => 1,
                        ]);
                    ?>
                    // redirecting
                    setTimeout(function(){
                        btn_login.textContent = "Sign in";
                        window.location.href = './?rl=home';
                    }, 2000);
                })
                .catch(error => {
                    console.error(error.message);
                    alertify.error(error.message)
                    btn_login.disabled = false;
                    btn_login.textContent = "Sign in"
                });
            };

            // log in
            async function LOGIN(url, data){
                try {

                    const username = sanitize(data.get('username'));
                    const response = await fetch(`${url}users/${username}/.json`);

                    if(!response.ok){
                        throw new Error("Server Error");
                    }

                    return await response;
                } catch (error) {
                    throw error;
                }
            }
        });

        // username sanitizer 
        function sanitize(username) {
            return username.replace(/\./g, '_');
        }
    </script>
</section>