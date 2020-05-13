<?php


    /**
     * Show 404
     *
     * Sends 404 not found header
     * And shows 404 HTML page
     *
     * @return void
     */
    function show_404()
    {
        header("HTTP/1.0 404 Not Found");
        include_once "404.php";
        die();
    }


    /**
     * Is AJAX
     *
     * Determines if request was AJAXed into existence
     *
     * @return bool
     */
    function is_ajax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }


    /**
     * Is Even
     *
     * Returns TRUE if $number is even
     * FALSE if odd
     *
     * @param integer $number number in question
     * @return boolean          true if even
     */
    function is_even($number)
    {
        return $number % 2 === 0;
    }


    /**
     * Get Parity
     *
     * Returns string "even" for even numbers
     * And, surprise, "odd" for odd numbers
     *
     * @param integer $number number in question
     * @return string          "even" if true, "odd" if false
     */
    function get_parity($number)
    {
        return is_even($number) ? 'even' : 'odd';
    }


    /**
     *
     * @param string $path
     * @param string $base
     * @return string
     */
    function asset($path, $base = BASE_URL . '/assets/')
    {
        $path = trim($path, '/');
        return filter_var($base . $path, FILTER_SANITIZE_URL);
    }

    /**
     * Get segments
     *
     * From url like http://example.com/edit/5
     * is creted an array of URI segments [ edit, 5 ]
     *
     * @return array
     */
    function get_segments()
    {
        $current_url = 'http' .
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's://' : '://') .
            $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $path = str_replace(BASE_URL, '', $current_url);
        $path = trim(parse_url($path, PHP_URL_PATH), '/');

        $segments = explode('/', $path);


        return $segments;

    }

    /**
     * Segemetn
     *
     * Reurns the $index-th URI segment
     *
     * @param $index
     * @return string or false
     */
    function segment($index)
    {
        $segments = get_segments();
        return isset($segments[$index - 1]) ? $segments[$index - 1] : false;
    }


    /**
     * Redirect
     *
     * @param $page
     * @param int $status_code
     */
    function redirect($page, $status_code = 302)
    {

        if ($page === 'back') {
            $location = $_SERVER['HTTP_REFERER'];
        } else {
            $page = str_replace( BASE_URL, '', $page );
            $page = ltrim($page, '/');
            $location = BASE_URL . "/$page";
        }

        header("Location: $location", true, $status_code);
        die();
    }

    /**
     *
     * * Arrays Compare
     *
     * compare two arrays
     * same 0, diff 1
     *
     * @param $arr1
     * @param $arr2
     * @return bool
     */
    function arrays_compare( $arr1, $arr2 )
    {
        $diff = array_merge(array_diff($arr1, $arr2), array_diff($arr2, $arr1));
        return $diff;
    }