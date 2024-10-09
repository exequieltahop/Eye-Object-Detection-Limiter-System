<?php
    /**
     * Use the middleware like this 
     * require __DIR__.'/../../../middleware/auth.php';
     */
    
    require __DIR__.'/../../../middleware/auth.php';
    require __DIR__.'/../../../middleware/metainance.php';

    /**
     * include the header
     */
    require __DIR__.'/../sub-components/header.php';
?>

<section class="container d-grid vh-100" style="place-items: center;">
    <div class="card w-100 bg-white shadow" style="max-width: 500px;">
        <div class="card-header">
            <h3>Set Machine Time Out</h3>
        </div>
        <div class="card-body">
            <!-- form time limiter -->
            <form id="formTimeOut">
                <label for="time" class="mb-1">Time</label>
                <input type="number" name="time" id="time" class="form-control mb-3" min="0" required>
                <label for="timeType" class="mb-1">Type</label>
                <select name="timeType" id="timeType" class="form-control mb-3" placeholder="Type" required>
                    <option value=""></option>
                    <option value="seconds">Seconds</option>
                    <option value="minutes">Minutes</option>
                    <option value="hours">Hours</option>
                </select>
                <button class="btn btn-primary w-100" type="submit" id="btnSubmit">Submit</button>
            </form>
        </div>
        <div class="card-footer">
            Time Limiter
        </div>
    </div>
</section>

<!-- script -->
<script>
    document.addEventListener('DOMContentLoaded', ()=>{
        document.getElementById('formTimeOut').onsubmit = (e)=>{
            e.preventDefault();

            /**
             * get the input time
             * get the btn submit
             */
            const btnSubmit = document.getElementById('btnSubmit');
            const inputTime = document.getElementById('time');

            /**
             * Make the url, data and dataType
             */
            const formData = new FormData(e.target);
            const url = './controller/page/submit-time-limiter.php';
            const dataType = 'FORM_DATA';
            
            /**
             * disabled btn submit
             * set alertify
             */
            btnSubmit.disabled = true;
            alertify.set('notifier', 'position', 'top-left');

            /**
             * POST the asynchronous function
             * then handle the response from the function in getting the response from the server
             * catch() catch the errors and exceptions
             */
            POST(url, formData, dataType)
            .then(response => {
                if(response.success){
                    alertify.success(response.success);
                    btnSubmit.disabled = false;
                    inputTime.value = '';
                } else if(response.error){
                    throw new Error(response.error);
                } else {
                    throw new Error("Unexpected error!");
                }
            })
            .catch(error => {
                console.error(error.message);
                alertify.error(error.message);
                btnSubmit.disabled = false;
            });
        };
    });
</script>


