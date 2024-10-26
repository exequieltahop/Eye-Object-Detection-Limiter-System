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
            <form id="formTimeOut" class="p-3">
                <label for="time" class="mb-1">Time</label>
                <input type="number" name="time" id="time" class="form-control mb-3" min="0" placeholder="In Minutes" required>
                <!-- <label for="timeType" class="mb-1">Type</label>
                <select name="timeType" id="timeType" class="form-control mb-3" placeholder="Type" required>
                    <option value=""></option>
                    <option value="seconds">Seconds</option>
                    <option value="minutes">Minutes</option>
                    <option value="hours">Hours</option>
                </select> -->
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
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('formTimeOut').onsubmit = (e) => {
            e.preventDefault();

            /**
             * Get the submit button and time input
             */
            const btnSubmit = document.getElementById('btnSubmit');
            const inputTime = document.getElementById('time');

            /**
             * Create the formData object to get the input time value
             */
            const formData = new FormData(e.target);
            const time = formData.get('time');

            /**
             * Firebase Realtime Database URL
             */
            const url = 'https://eyedetectiontimer-default-rtdb.asia-southeast1.firebasedatabase.app/';

            /**
             * Disable the submit button and set alertify notifier position
             */
            btnSubmit.disabled = true;
            alertify.set('notifier', 'position', 'top-left');

            /**
             * POST the data asynchronously to Firebase
             */
            PUT(url, time)
                .then(response => {
                    if (response) {
                        alertify.success("Successfully Set Timer");
                        inputTime.value = '';  // Clear the input field
                        btnSubmit.disabled = false;  // Re-enable the button
                    }
                })
                .catch(error => {
                    console.error(error.message);
                    alertify.error(error.message);
                    btnSubmit.disabled = false;  // Re-enable the button on error
                });
        };
    });

    /**
     * Asynchronous function to send data to Firebase Realtime Database
     */
    async function PUT(url, data) {
        try {
            // Send a PUT request to Firebase, passing the timer data
            const response = await fetch(`${url}timer.json`, {
                method: 'PUT',  // Use PUT method to update data
                headers: {
                    'Content-Type': 'application/json'  // Specify that the request body is JSON
                },
                body: JSON.stringify({ duration: parseInt(data) })  // Send the timer duration as JSON
            });

            // Check if the response is OK
            if (!response.ok) {
                throw new Error("Failed to set timer on the server");
            }

            return true;  // Return true if the request succeeds
        } catch (error) {
            throw error;  // Rethrow any errors to be caught in the caller
        }
    }
</script>


