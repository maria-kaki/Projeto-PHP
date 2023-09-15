<?php
// This function loads a model file based on the provided modelName
function loadModel($modelName) {
    require_once(MODEL_PATH . "/{$modelName}.php");
}
// This function loads a view file and passes parameters to it
function loadView($viewName, $params = array()) {

    // If there are parameters, create variables with the parameter names and values
    if(count($params) > 0) {
        foreach($params as $key => $value) {
            if(strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    // Load the view file
    require_once(VIEW_PATH . "/{$viewName}.php");
}
// This function loads a template view, includes header, left, and footer templates
function loadTemplateView($viewName, $params = array()) {
    // If there are parameters, create variables with the parameter names and values
    if(count($params) > 0) {
        foreach($params as $key => $value) {
            if(strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }
    // Get user information from session
    $user = $_SESSION['user'];
    // Load working hours and related information
    $workingHours = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));
    $workedInterval = $workingHours->getWorkedInterval()->format('%H:%I:%S');
    $exitTime = $workingHours->getExitTime()->format('H:i:s');
    $activeClock = $workingHours->getActiveClock();
    // Include header, left, and view files
    require_once(TEMPLATE_PATH . "/header.php");
    require_once(TEMPLATE_PATH . "/left.php");
    require_once(VIEW_PATH . "/{$viewName}.php");
    require_once(TEMPLATE_PATH . "/footer.php");
}
// This function renders a title using a title.php template
function renderTitle($title, $subtitle, $icon = null) {
    require_once(TEMPLATE_PATH . "/title.php");
}