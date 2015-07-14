<tr>
    <td>$customerid</td>
    <td>$loginname</td>
    <td>$name</td>
    <td>$firstname</td>
    <td>$company</td>
    <td>Unbekannte PayPal</td>
    <td>$hdl_abo_type</td>
    <td>$hdl_abo_payed</td>
    <td>$hdl_abo_expire</td>
    <td>
    <a href="{$linker->getLink(array('section' => 'billing_overview', 'page' => $page, 'action' => 'edit', 'id' => $customerid, 'state' => 'edit'))}">
        <img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
    </a>&nbsp;
    <a href="{$linker->getLink(array('section' => 'billing_overview', 'page' => $page, 'action' => 'delete', 'id' => $customerid))}">
        <img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
    </a>
    </td>
</tr>



