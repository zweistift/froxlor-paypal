$header
	<article>
		<header>
			<h2>
				<img src="templates/{$theme}/assets/img/icons/user_add_big.png" alt="abos anlegen" />&nbsp;
				$lng[modules][paypal][editclientsubs]
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
                        <th colspan="3">$lng['modules']['paypal']['client']</th>    
                    </tr>
                    <tr>
                        <td>$lng['modules']['paypal']['name']</td><td>$name</td> 
                    </tr>
                    <tr>
                        <td>$lng['modules']['paypal']['firstname']</td><td>$firstname</td> 
                    </tr>
                    <tr>
                        <td>$lng['modules']['paypal']['company']</td><td>$company</td> 
                    </tr>
                    <tr>
                        <td>$lng['modules']['paypal']['username']</td><td>$username</td> 
                    </tr>                        
                    </tbody>
                </table>
                
                <br>
                <p style="color: red !important; font-weight: bold">$lng['modules']['paypal']['abodeletewarning']</p>
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
</table>
$footer
