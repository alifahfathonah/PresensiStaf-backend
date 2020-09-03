<?php

// ref https://medium.com/@lamaaurizkhal/create-a-helper-for-active-link-in-laravel-5-6-30827a760593
function setActive($path, $active = 'active'){
    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

