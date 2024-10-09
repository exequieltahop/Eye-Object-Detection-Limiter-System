<section class="container d-grid vh-100" style="place-items: center;">
    <div class="card bg-white w-100 shadow" style="max-width: 500px;">
        <div class="card-header">
            <h1 class="m-0 text-center display-5">Migration Status</h1>
        </div>
        <div class="card-body p-5 text-center">
            <h5 class=" mb-3">
                <?php
                    if(!SessionHas('MigrationStatus')){
                        header('Location: ./?rl=unauthorized');
                        exit;
                    }
                    
                    if(SessionHas('MigrationStatus')){
                        ?>
                            <div class="alert alert-sucess">
                                <?php 
                                    echo Session('MigrationStatus');           
                                ?>
                            </div>
                        <?php
                    }
                ?>
            </h5>
            <hr>
            <div class="d-flex justify-content-center">
                <a href="./" class="btn btn-primary rounded-pill" style="font-size: 0.9rem;">Go Back To Sign In Page</a>
            </div>
        </div>
    </div>
</section>