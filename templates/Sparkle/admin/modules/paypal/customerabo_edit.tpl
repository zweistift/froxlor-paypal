$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_add_big.png" alt="abos anlegen" />&nbsp;
				Kundenabos bearbeiten
			</h2>
		</header>

		<section>
			<form action="{$linker->getLink(array('section' => 'billing_overview', 'page' => 'overview', 'action' => 'edit', 'id' => $id))}" method="post" enctype="application/x-www-form-urlencoded">
				<input type="hidden" name="s" value="$s" />
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="action" value="$action" />
				<input type="hidden" name="send" value="send" />
				<table class="full">
                    <tbody>
                    <tr class="section">
                        <th colspan="3">Kunde</th>    
                    </tr>
                    <tr>
                        <td>Name</td><td>$name</td> 
                    </tr>
                    <tr>
                        <td>Vorname</td><td>$firstname</td> 
                    </tr>
                    <tr>
                        <td>Firma</td><td>$company</td> 
                    </tr>
                    <tr>
                        <td>Benutzername</td><td>$username</td> 
                    </tr>                        
                    </tbody>
                </table>
                
                <br>
                <p style="color: red !important; font-weight: bold">Bitte denken Sie daran, das PAYPAL ABO vorher zu kuendigen! der Client wird ansonsten doppelt belastet!</p>
                <br>
				<table class="full">
                    {$customer_add_form}
				</table>
			</form>

		</section>

	</article>
	<br />
	<article>
		<section>
			<p>
				<span class="red">*</span>: {$lng['admin']['valuemandatory']}
			</p>
		</section>
	</article>

