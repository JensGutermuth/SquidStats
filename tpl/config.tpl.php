<?
    $v['content'] = '<table>
                         <tr>
                             <th>Eintrag</th>
                             <th>Wert</th>
                         </tr>';
    foreach ($v['config'] as $key => $value) {
      $v['content'] .= '
                  <tr>
                      <td>'.$key.'</td>
                      <td>';
      if (is_bool($value)) {
        if ($value) {
          $v['content'] .= 'true</td>';
        } else {
          $v['content'] .= 'false</td>';
        }
      } else {
        $v['content'] .= print_r($value, true).'</td>';
      }
      $v['content'] .= '</tr>';
    }
    $v['content'] .= '</table>';
    $v['menu'] = '';
    include(dirname(__FILE__).'/index.tpl.php');
?>
