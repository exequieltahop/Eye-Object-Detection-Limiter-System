<?php
    require_once __DIR__.'/../../service-provider/general/session.php';
?>
<section class="container d-grid vh-100" style="place-items: center;">
    <div class="card bg-white w-100 shadow" style="max-width: 500px;">
        <div class="card-header">
            <h1 class="m-0 text-center display-5">Exception Page</h1>
        </div>
        <div class="card-body p-5">
            <h5 class="text-center mb-3">
                <?php
                    if(SessionHas('exception')){
                        if($message = SessionFlash('exception')){
                            echo $message;
                        }
                    }else{
                        header('location: ./?rl=unauthorized');
                        exit;
                    }
                ?>
            </h5>
            <hr>
            <div class="d-flex justify-content-center">
                <a href="./" class="btn btn-primary rounded-pill" style="font-size: 0.9rem;">Go Back Home</a>
            </div>
        </div>
    </div>
</section>