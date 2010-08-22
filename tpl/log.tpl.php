<?
    $v['content'] = '<table>
                         <tr>
                             <th>Zeit</th>
                             <th>Level</th>
                             <th>Herkunft</th>
                             <th>Nachricht</th>
                         </tr>';
    foreach ($v['log'] as $log) {
        $v['content'] .= '
                    <tr>
                        <td>'.$log['time'].'</td>
                        <td>'.$log['severity'].'</td>
                        <td>'.$log['origin'].'</td>
                        <td>'.$log['message'].'</td>
                    </tr>';
    }
    $v['content'] .= '</table>';
    $v['menu'] = '';
    include(dirname(__FILE__).'/index.tpl.php');
?>
