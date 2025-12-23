<div class="modal fade" id="rescheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="rescheduleForm">
                @csrf
                <input type="hidden" name="hearing_id" id="modalHearingId">
                <div class="modal-header">
                    <h5 class="modal-title">Reschedule Hearing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label>New Date:</label>
                    <input type="date" name="new_date" class="form-control" required>
                    <label>New Time:</label>
                    <input type="time" name="new_time" class="form-control mt-2">

                    <div class="mt-3">
                        <label>Witnesses:</label>
                        <div id="witnessContainer"></div>
                        <button type="button" id="addWitnessBtn" class="btn btn-sm btn-success mt-2">Add Witness</button>
                    </div>

                    <div class="mt-3">
                        <label>Send Notifications:</label><br>
                        <div class="form-check">
                            <input class="form-check-input sms-schedule-checkbox" type="checkbox" value="10_days_before" id="10Days">
                            <label class="form-check-label" for="10Days">10 days before</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sms-schedule-checkbox" type="checkbox" value="3_days_before" id="3Days">
                            <label class="form-check-label" for="3Days">3 days before</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input sms-schedule-checkbox" type="checkbox" value="send_now" id="sendNow">
                            <label class="form-check-label" for="sendNow">Send Now</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Reschedule & Notify</button>
                </div>
            </form>
        </div>
    </div>
</div>
