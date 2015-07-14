<tr>
    <td>$pk_abo_id</td>
    <td>$abo_kurz</td>
    <td>$abo_desc</td>
    <td>{$abo_costs_mth} CHF</td>
    <td>$abo_costs_year CHF</td>
    <td>
    <a href="{$linker->getLink(array('section' => 'billing', 'page' => $page, 'action' => 'edit', 'id' => $pk_abo_id, 'state' => 'edit'))}">
        <img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
    </a>&nbsp;
    <a href="{$linker->getLink(array('section' => 'billing', 'page' => $page, 'action' => 'delete', 'id' => $pk_abo_id))}">
        <img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
    </a>
    </td>
</tr>