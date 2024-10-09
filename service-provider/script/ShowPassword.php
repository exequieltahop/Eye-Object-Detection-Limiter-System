<?php
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                document.getElementById('ShowPassword').onchange = function(e){
                    e.preventDefault();
                    
                    const password = document.getElementById('password');

                    if(e.target.checked){
                        password.type = 'text';
                    }else{
                        password.type = 'password';
                    }
                };
            });
        </script>
    ";
    
?>