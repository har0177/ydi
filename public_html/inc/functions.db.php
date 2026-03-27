<?php

function list_courses($cur = 0) {
    $db = new database();
    $db->query("SELECT course_id, course_name FROM courses");
    $course = '';
    while ($r = $db->fetchObject()) {
        $class = $cur == $r->course_id ? "selected=''" : "";
        $course .= "<option value='$r->course_id' $class> $r->course_name </option>";
    }
    return $course;
}



function list_menu($cur = 0) {
    $db = new database();
    $db->query("SELECT page_id, page_title FROM pages");
    $options = '';
    while ($r = $db->fetchObject()) {
        $class = $cur == "page.php?id=".$r->page_id ? "selected=''" : "";
        $options .= "<option value='$r->page_id' $class> $r->page_title </option>";
    }
    return $options;
}

function list_submenu($cur = 0) {
    $db = new database();
    $db->query("SELECT menu_id, menu_label FROM menus");
    $options = '';
    while ($r = $db->fetchObject()) {
        $class = $cur == $r->menu_id ? "selected=''" : "";
        $options .= "<option value='$r->menu_id' $class> $r->menu_label </option>";
    }
    return $options;
}

function menu_name($id) {
    $db = new database();
    $db->query("SELECT menu_label FROM menus where menu_id = ?", array(
        $id));
    $r = $db->fetchObject();
    return $r->menu_label;
}

function program_name($id) {
    $db = new database();
    $db->query("SELECT p_title FROM programs where p_id = ?", array(
        $id));
    $r = $db->fetchObject();
    return $r->p_title;
}

function list_answer($cur = 0) {
    foreach (range(1, 4) as
            $star) {
        $st = $cur == $star ? "selected=''" : "";
        echo "<option value='" . $star . "' $st>" . $star . "</option>";
    }
    return $st;
}

function list_topics($cur = 0) {
    $db = new database();
    $db->query("SELECT topic_id, topic_name FROM topics WHERE parent_id = 0");
    $options = '';
    while ($r = $db->fetchObject()) {
        $class = $cur == $r->topic_id ? "selected=''" : "";
        $options .= "<option value='$r->topic_id' $class> $r->topic_name </option>";
    }
    return $options;
}

function topics($cur = 0) {
    $db = new database();
    $db->query("SELECT topic_id, topic_name FROM topics");
    $options = '';
    while ($r = $db->fetchObject()) {
        $class = $cur == $r->topic_id ? "selected=''" : "";
        $options .= "<option value='$r->topic_id' $class> $r->topic_name </option>";
    }
    return $options;
}

function topic_name($id) {
    $db = new database();
    $db->query("SELECT topic_name FROM topics where topic_id = ?", array(
        $id));
    $r = $db->fetchObject();
    // Decode HTML entities before returning
    return html_entity_decode($r->topic_name, ENT_QUOTES, 'UTF-8');
}

function list_gender($cur = "") {
    $m = ($cur === "Male") ? "selected=''" : "";
    $f = ($cur === "Female") ? "selected=''" : "";
    $gender = "
                <option value='Male' $m> Male </option>
                <option value='Female' $f> Female </option>
                ";
    return $gender;
}

function list_status($cur = "") {
    $a = ($cur === "1") ? "selected=''" : "";
    $d = ($cur === "0") ? "selected=''" : "";
    $status = "
                <option value='1' $a> Active </option>
                <option value='0' $d> Deactive </option>
                ";
    return $status;
}

function print_button() {
    ?>
    <div class="hidden-print">
        <button type="button" onclick="print_it()" class="btn btn-primary btn-block btn-lg">Print</button>
    </div>
    <?php
}

function pagination($query, $per_page = 5, $page = 1, $url = '?') {
    $db = new database();
    $query = "SELECT COUNT(*) as num FROM {$query}";
    $row = $db->fetchObject($db->query($query));
    $total = $row->num;
    $adjacents = "2";
    $fistlabel = "&lsaquo;&lsaquo;  First";
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";

    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $per_page;


    $prev = $page - 1;
    $next = $page + 1;

    $lastpage = ceil($total / $per_page);

    $lpm1 = $lastpage - 1; // //last page minus 1

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<ul class='pagination'>";
        if ($page > 1)
            $pagination.= "<li><a href='{$url}page=1'>{$fistlabel}</a></li>";
        if ($page > 1)
            $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";

        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1;
                    $counter <= $lastpage;
                    $counter++) {
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {

            if ($page < 1 + ($adjacents * 2)) {

                for ($counter = 1;
                        $counter < 4 + ($adjacents * 2);
                        $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents;
                        $counter <= $page + $adjacents;
                        $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
            } else {

                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2));
                        $counter <= $lastpage;
                        $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
                }
            }
        }

        if ($page < $counter - 1) {
            $pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
            $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
        }

        $pagination.= "</ul>";
    }

    return $pagination;
}

function gen_color() {
    mt_srand((double) microtime() * 1000000);
    $color_code = '';
    while (strlen($color_code) < 6) {
        $color_code .= sprintf("%02X", mt_rand(0, 255));
    }
    return $color_code;
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

function jt_get_font_icons() {
    return array(
        'fa-glass',
        'fa-envelope-o',
        'fa-heart',
        'fa-star',
        'fa-star-o',
        'fa-user',
        'fa-film',
        'fa-th-large',
        'fa-th',
        'fa-th-list',
        'fa-file-o',
        'fa-graduation-cap',
        'fa-leaf',
        'fa-plane',
    );
}

function list_colors() {
    return array(
        'list-group-item-primary',
        'list-group-item-secondary',
        'list-group-item-success',
        'list-group-item-danger',
        'list-group-item-warning',
        'list-group-item-info',
        'list-group-item-light',
        'list-group-item-dark',
       
    );
}

function list_animation() {
    return array(
        'w3-animate-top',
        'w3-animate-bottom',
        'w3-animate-left',
        'w3-animate-right',
        'w3-animate-zoom',
         'w3-animate-fading',
      
       
    );
}
