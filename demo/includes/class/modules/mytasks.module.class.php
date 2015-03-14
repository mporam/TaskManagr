<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/class/modules/module.abstract.php');

class mytasks extends moduleAbstract {

    public function display() {
        $el = '';
        $el .= '<h3>My Tasks</h3>';
        $el .= '<div class="inner-module">';
        $el .= '<table>
                    <thead>
                        <tr>
                            <th>Task no:</th>
                            <th>Priority:</th>
                            <th>Title:</th>
                            <th>Deadline:</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <img src="images/site/icons/loading.gif" class="loader">';
        $el .= '</div>';

        return $el;
    }
} 