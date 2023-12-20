<!-- Put this part before </body> tag -->
<input type="checkbox" id="view_patient" class="modal-toggle" />
<div class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Patient Info!</h3>
        <p class="py-4">This modal works with a hidden checkbox!</p>
        <p>{{ $getId }}</p>
        <div class="modal-action">
            <label for="view_patient" class="btn">Close!</label>
        </div>
    </div>
</div>
