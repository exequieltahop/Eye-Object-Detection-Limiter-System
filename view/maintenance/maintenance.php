<section class="container d-grid vh-100" style="place-items: center;">
    <div class="card bg-white w-100 shadow" style="max-width: 500px;">
        <div class="card-header">
            <h1 class="m-0 text-center display-5">Mentainance Mode</h1>
        </div>
        <div class="card-body p-5 text-center">
            <h5 class=" mb-3">
                <?php
                    if(!SessionHas('mentainance')){
                        header('Location: ./?rl=unauthorized');
                        exit;
                    }
                    echo Session('mentainance');
                ?>
            </h5>
        </div>
    </div>
</section>