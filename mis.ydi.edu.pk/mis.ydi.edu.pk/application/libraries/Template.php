<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Template
{

    /**
     *
     * @var type 
     */
    private $CI;

    /**
     *
     * @var type 
     */
    private $footer_scripts = [];

    /**
     *
     * @var type 
     */
    private $footer_js_files = [];
    private $header_js_files = [];
    private $css_files = [];
    private $css_styles = [];

    /**
     *
     * @var type 
     */
    private $base_tpl = '';

    /**
     *
     * @var type 
     */
    private $views = [];

    /**
     *
     * @var type 
     */
    private $tpl_data = [];

    /**
     *
     * @var type 
     */
    private $view_data = [];

    /**
     * 
     */
    function __construct()
    {
        $this->CI = & get_instance();
    }

    /**
     * 
     * @param type $view
     */
    public function baseView($view)
    {
        $this->base_tpl = $view;
    }

    /**
     * 
     * @param type $title
     */
    public function title($title)
    {
        $this->tpl_data['title'] = $title;
    }

    /**
     * Add View to the template
     * @param type $view
     * @param type $name
     */
    public function addView($view, $name = '')
    {
        if (empty($name)) {
            if (strpos($view, '/') !== FALSE) {
                $name = substr($view, strrpos($view, '/') + 1);
            } else {
                $name = $view;
            }
        }
        $this->views[] = [$name => $view];
    }

    public function assign($name, $value)
    {
        $this->view_data[$name] = $value;
    }

    public function data($data)
    {
        $this->view_data = array_merge($this->view_data, $data);
    }

    public function addJs($jsPath, $footer = TRUE)
    {
        if ($footer) {
            $this->footer_js_files[] = $jsPath;
        } else {
            $this->header_js_files[] = $jsPath;
        }
    }

    public function addScript($script)
    {
        $this->footer_scripts[] = $script;
    }

    public function addStyle($style)
    {
        $this->css_styles[] = $style;
    }

    public function addCss($cssFile)
    {
        $this->css_files[] = $cssFile;
    }

    public function display($baseView = '')
    {
        if (!empty($baseView)) {
            $this->base_tpl = $baseView;
        }
        // prepare data
        $this->tpl_data['t_js_footer'] = $this->prepare_scripts_footer();
        $this->tpl_data['t_js_header'] = $this->prepare_scripts_header();
        $this->tpl_data['t_css'] = $this->prepare_css();

        $main_data = array_merge($this->view_data, $this->tpl_data);
        $views_data = array_merge($main_data, $this->prepare_views($main_data));
        $this->CI->load->view($this->base_tpl, $views_data);
    }

    /**
     * 
     * @param type $tpl_view
     * @param type $body_view
     * @param type $data
     */
    public function load($tpl_view, $body_view = null, $data = null)
    {
        if (!is_null($body_view)) {
            if (file_exists(APPPATH . 'views/' . $tpl_view . '/' . $body_view)) {
                $body_view_path = $tpl_view . '/' . $body_view;
            } else if (file_exists(APPPATH . 'views/' . $tpl_view . '/' . $body_view . '.php')) {
                $body_view_path = $tpl_view . '/' . $body_view . '.php';
            } else if (file_exists(APPPATH . 'views/' . $body_view)) {
                $body_view_path = $body_view;
            } else if (file_exists(APPPATH . 'views/' . $body_view . '.php')) {
                $body_view_path = $body_view . '.php';
            } else {
                show_error('Unable to load the requested file: ' . $tpl_view . '/' . $body_view . '.php');
            }

            $body = $this->CI->load->view($body_view_path, $data, TRUE);

            if (is_null($data)) {
                $data = array('body' => $body);
            } else if (is_array($data)) {
                $data['body'] = $body;
            } else if (is_object($data)) {
                $data->body = $body;
            }
        }

        $this->CI->load->view($tpl_view, $data);
    }
    /* ------------------------------------------------
     *  PRIVATE METHODS
     * -----------------------------------------------
     */

    private function prepare_scripts_footer()
    {
        $script_code = '';
        $script_files = '';

        if (!empty($this->footer_js_files)) {
            foreach ($this->footer_js_files as $jsfile) {
                $script_files .= '<script type="text/javascript" src="' . $jsfile . '"></script>';
            }
        }

        if (!empty($this->footer_scripts)) {
            $script_code .= '<script type="text/javascript">';
            foreach ($this->footer_scripts as $script) {
                $script_code .= $script;
            }
            $script_code .= '</script>';
        }

        return $script_files . $script_code;
    }

    private function prepare_css()
    {
        $css_code = '';
        $css_files = '';

        if (!empty($this->css_files)) {
            foreach ($this->css_files as $css) {
                $css_files .= '<link rel="stylesheet" type="text/css" href="' . $css . '" />';
            }
        }

        if (!empty($this->css_styles)) {
            $css_code .= '<style type="text/css">';
            foreach ($this->css_styles as $css) {
                $css_code .= $css;
            }
            $css_code .= '</style>';
        }

        return $css_files . $css_code;
    }

    private function prepare_scripts_header()
    {
        $script_files = '';

        if (!empty($this->header_js_files)) {
            foreach ($this->header_js_files as $jsfile) {
                $script_files .= '<script type="text/javascript" src="' . $jsfile . '"></script>';
            }
        }

        return $script_files;
    }

    private function prepare_views($data)
    {
        $view_data = [];
        if (!empty($this->views)) {
            foreach ($this->views as $value) {
                $view_data[key($value)] = $this->CI->load->view($value[key($value)], $data, TRUE);
            }
        }
        return $view_data;
    }
}