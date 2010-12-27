<?
    $v['content'] = '<table>
                         <tr>
                             <th colspan="2">Eintrag</th>
                             <th>Wert</th>
                         </tr>';
    foreach ($v['config'] as $key => $value) {
      $v['content'] .= '
                  <tr>
                      <td colspan="2">'.$key.'</td>
                      <td>';
      if (is_bool($value)) {
        if ($value) {
          $v['content'] .= 'true</td>';
        } else {
          $v['content'] .= 'false</td>';
        }
      } elseif (is_array($value)) {
        $v['content'] .= '</td>';
        foreach($value as $subkey => $subvalue) {
          $v['content'] .= '
                      <tr>
                          <td width="20px"></td>
                          <td>'.$subkey.'</td>
                          <td>'.print_r($subvalue, true).'</td>';
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
