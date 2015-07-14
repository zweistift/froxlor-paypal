<tr>
    <td>$customerid</td>
    <td>$loginname</td>
    <td>$name</td>
    <td>$firstname</td>
    <td>$company</td>
    <td>Unbekannte PayPal</td>
    <td>$abo_desc</td>
    <td>$pp_sub_completed</td>
    <td>$pp_abo_expire</td>
    <td>
    <a href="{$linker->getLink(array('section' => 'paypal', 'page' => $page, 'action' => 'edit', 'id' => $customerid, 'state' => 'edit'))}">
        <img src="templates/{$theme}/assets/img/icons/edit.png" alt="{$lng['panel']['edit']}" title="{$lng['panel']['edit']}" />
    </a>&nbsp;
    <a href="{$linker->getLink(array('section' => 'paypal', 'page' => $page, 'action' => 'delete', 'id' => $customerid))}">
        <img src="templates/{$theme}/assets/img/icons/delete.png" alt="{$lng['panel']['delete']}" title="{$lng['panel']['delete']}" />
    </a>
    </td>
</tr>

