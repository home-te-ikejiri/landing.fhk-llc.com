<style>
    #status-success {
        display: none;
    }

    #status-error {
        display: none;
    }
</style>

<div id="status-success" class="alert alert-info alert-dismissible status-success" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <span><i class="icon fas fa-info"></i> <span id="success-message"></span></span>
</div>

<div id="status-error" class="alert alert-danger alert-dismissible status-error" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <span><i class="icon fas fa-exclamation-triangle"></i> <span id="error-message"></span></span>
</div>
